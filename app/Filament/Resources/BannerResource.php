<?php
namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = null;
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('nav.group_content');
    }

    public static function getNavigationLabel(): string
    {
        return __('nav.banners');
    }

    public static function getModelLabel(): string
    {
        return __('nav.banner_singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('nav.banners');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->label(__('fields.title'))
                ->required(),

            // ✅ الفئة المستهدفة — لو تُركت فاضية، البانر يظهر بالصفحة الرئيسية العامة
            // لو تم اختيار فئة، البانر يظهر فقط بصفحة تلك الفئة (إعلان مدفوع مستهدف)
            Forms\Components\Select::make('category_id')
                ->label('الفئة المستهدفة (اختياري)')
                ->relationship('category', 'name_ar')
                ->searchable()
                ->placeholder('عام - يظهر بالصفحة الرئيسية')
                ->helperText('اتركه فاضي ليظهر البانر بالصفحة الرئيسية للجميع، أو اختر فئة (مثل "المركبات") ليظهر البانر فقط بصفحة تلك الفئة — مناسب للإعلانات المدفوعة المستهدفة.'),

            Forms\Components\FileUpload::make('image')
                ->label(__('fields.image'))
                ->image()
                ->directory('banners')
                ->required()
                ->imageResizeTargetWidth('1200')
                ->imageResizeMode('cover')
                ->imageResizeUpscale(false)
                ->imageEditor()
                ->imageEditorAspectRatios([
                    '3:1',
                ]),

            Forms\Components\TextInput::make('link')
                ->label(__('fields.link'))
                ->url()
                ->nullable(),

            Forms\Components\TextInput::make('sort_order')
                ->label(__('fields.sort_order'))
                ->numeric()
                ->default(0),

            Forms\Components\Toggle::make('is_active')
                ->label(__('fields.active'))
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image')
                ->label(__('fields.image')),
            Tables\Columns\TextColumn::make('title')
                ->label(__('fields.title'))
                ->searchable(),
            Tables\Columns\TextColumn::make('category.name_ar')
                ->label('الفئة المستهدفة')
                ->placeholder('عام (الرئيسية)')
                ->badge(),
            Tables\Columns\IconColumn::make('is_active')
                ->label(__('fields.active'))
                ->boolean(),
            Tables\Columns\TextColumn::make('sort_order')
                ->label(__('fields.sort_order'))
                ->sortable(),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}