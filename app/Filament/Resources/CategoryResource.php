<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
        protected static ?string $navigationGroup = null;
    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return __('nav.group_content');
    }

    public static function getNavigationLabel(): string
    {
        return __('nav.categories');
    }

    public static function getModelLabel(): string
    {
        return __('nav.category_singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('nav.categories');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('parent_id')
                ->label(__('fields.main_category_optional'))
                ->relationship('parent', 'name_ar')
                ->searchable()
                ->placeholder(__('fields.none_main_category')),

            Forms\Components\TextInput::make('name_ar')
                ->label(__('fields.name_ar'))
                ->required(),

            Forms\Components\TextInput::make('name_en')
                ->label(__('fields.name_en'))
                ->required(),

            Forms\Components\TextInput::make('slug')
                ->label(__('fields.slug'))
                ->required()
                ->unique(ignoreRecord: true),
				
            // ✅ قائمة منسدلة للأيقونات
            Forms\Components\Select::make('icon')
                ->label(__('fields.icon'))
                ->searchable()
                ->placeholder('اختر أيقونة')
                ->options([
                    'car' => '🚗 سيارات',
                    'home' => '🏠 عقارات',
                    'device' => '💻 إلكترونيات',
                    'phone' => '📱 هواتف',
                    'work' => '💼 وظائف',
                    'chair' => '🪑 أثاث',
                    'build' => '🔧 خدمات / صيانة',
                    'pets' => '🐾 حيوانات',
                    'checkroom' => '👕 ملابس',
                    'sport' => '⚽ رياضة',
                    'book' => '📚 كتب',
                    'food' => '🍽️ أطعمة',
                    'game' => '🎮 ألعاب',
                    'motorcycle' => '🏍️ موتوسيكلات',
                    'baby' => '👶 أطفال',
                    'garden' => '🌿 حدائق',
                    'camera' => '📷 كاميرات',
                    'music' => '🎵 موسيقى',
                    'bus' => '🚌 نقل',
                ]),
				

            Forms\Components\TextInput::make('sort_order')
                ->label(__('fields.sort_order'))
                ->numeric()
                ->default(0),

            Forms\Components\Toggle::make('is_active')
                ->label(__('fields.active_f'))
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#'),
                Tables\Columns\TextColumn::make('parent.name_ar')
                    ->label(__('fields.main_category'))
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('name_ar')->label(__('fields.name_ar_short'))->searchable(),
                Tables\Columns\TextColumn::make('name_en')->label(__('fields.name_en_short')),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('fields.active_f'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->label(__('fields.sort_order'))->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label(__('fields.status')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
