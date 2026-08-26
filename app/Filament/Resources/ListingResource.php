<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ListingResource\Pages;
use App\Models\Listing;
use App\Models\ListingImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ListingResource extends Resource
{
    protected static ?string $model = Listing::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
        protected static ?string $navigationGroup = null;
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('nav.group_listings');
    }

    public static function getNavigationLabel(): string
    {
        return __('nav.listings');
    }

    public static function getModelLabel(): string
    {
        return __('nav.listing_singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('nav.listings');
    }

    protected static function statusOptions(): array
    {
        return [
            'pending' => __('fields.status_pending'),
            'active' => __('fields.status_active'),
            'rejected' => __('fields.status_rejected'),
            'sold' => __('fields.status_sold'),
            'expired' => __('fields.status_expired'),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->label(__('fields.title'))
                ->required()
                ->maxLength(200),

            Forms\Components\Select::make('user_id')
                ->label(__('fields.publisher'))
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

            Forms\Components\Select::make('category_id')
                ->label(__('fields.category'))
                ->relationship('category', 'name_ar')
                ->searchable()
                ->required(),

            Forms\Components\Select::make('city_id')
                ->label(__('fields.wilayat'))
                ->relationship('city', 'name_ar')
                ->searchable()
                ->required(),

            Forms\Components\Textarea::make('description')
                ->label(__('fields.description'))
                ->columnSpanFull(),

            Forms\Components\TextInput::make('price')
                ->label(__('fields.price'))
                ->numeric(),

            Forms\Components\TextInput::make('currency')
                ->label(__('fields.currency'))
                ->default('OMR')
                ->required(),

            Forms\Components\Select::make('status')
                ->label(__('fields.status'))
                ->options(self::statusOptions())
                ->required(),

            // ✅ رفع صور متعددة للإعلان
            Forms\Components\FileUpload::make('listing_images')
                ->label('صور الإعلان')
                ->image()
                ->multiple()
                ->reorderable()
                ->disk('public')
                ->directory('listings')
                ->visibility('public')
                ->imageEditor()
                ->maxSize(4096) // 4 ميجابايت لكل صورة
                ->helperText('أول صورة (أقصى اليسار) هي الصورة الرئيسية اللي تظهر بالتطبيق. اسحب أي صورة وحطها بالبداية لتصير هي الرئيسية.')
                ->columnSpanFull()
                // نعبّي الحقل بالصور الحالية وقت فتح صفحة التعديل
                ->afterStateHydrated(function (Forms\Components\FileUpload $component, ?Model $record) {
                    if (!$record) return;
                    $paths = $record->images()->orderBy('sort_order')->pluck('path')->toArray();
                    $component->state($paths);
                })
                // نحفظ الصور كسجلات ListingImage بعد حفظ الإعلان (إنشاء أو تعديل)
                ->saveRelationshipsUsing(function (Forms\Components\FileUpload $component, Model $record, $state) {
                    // نحذف الصور القديمة غير الموجودة بالقائمة الجديدة، ونضيف الجديد، مع الحفاظ على الترتيب
                    $record->images()->delete();
                    foreach (array_values($state ?? []) as $index => $path) {
                        ListingImage::create([
                            'listing_id' => $record->id,
                            'path' => $path,
                            'sort_order' => $index,
                        ]);
                    }
                })
                ->dehydrated(false), // ما نخزن هذا الحقل مباشرة بجدول listings (نتعامل معه يدوياً فوق)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable(),

                Tables\Columns\ImageColumn::make('images.path')
                    ->label('الصورة')
                    ->disk('public')
                    ->limit(1)
                    ->stacked(),

                Tables\Columns\TextColumn::make('title')
                    ->label(__('fields.title'))
                    ->searchable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('category.name_ar')
                    ->label(__('fields.category')),

                Tables\Columns\TextColumn::make('city.name_ar')
                    ->label(__('fields.wilayat')),

                Tables\Columns\TextColumn::make('price')
                    ->label(__('fields.price'))
                    ->money('OMR'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('fields.publisher')),

                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('fields.status'))
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'active',
                        'danger' => 'rejected',
                        'gray' => 'sold',
                        'secondary' => 'expired',
                    ])
                    ->formatStateUsing(fn (string $state): string => self::statusOptions()[$state] ?? $state),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('fields.published_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('fields.status'))
                    ->options(self::statusOptions()),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label(__('fields.approve'))
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (Listing $record) => $record->status === 'pending')
                    ->action(fn (Listing $record) => $record->update(['status' => 'active'])),

                Tables\Actions\Action::make('reject')
                    ->label(__('fields.reject'))
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn (Listing $record) => $record->status === 'pending')
                    ->action(fn (Listing $record) => $record->update(['status' => 'rejected'])),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListListings::route('/'),
            'create' => Pages\CreateListing::route('/create'),
            'edit' => Pages\EditListing::route('/{record}/edit'),
        ];
    }
}