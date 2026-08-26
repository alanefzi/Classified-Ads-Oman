<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = null;
    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return __('nav.group_content');
    }

    public static function getNavigationLabel(): string
    {
        return __('nav.pages');
    }

    public static function getModelLabel(): string
    {
        return __('nav.page_singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('nav.pages');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('slug')
                ->label(__('fields.slug') . ' (about-us)')
                ->required()
                ->unique(ignoreRecord: true),
            Forms\Components\Tabs::make('languages')->tabs([
                Forms\Components\Tabs\Tab::make('عربي')->schema([
                    Forms\Components\TextInput::make('title_ar')->label(__('fields.title'))->required(),
                    Forms\Components\RichEditor::make('content_ar')->label(__('fields.content'))->required(),
                ]),
                Forms\Components\Tabs\Tab::make('English')->schema([
                    Forms\Components\TextInput::make('title_en')->label(__('fields.title'))->required(),
                    Forms\Components\RichEditor::make('content_en')->label(__('fields.content'))->required(),
                ]),
            ])->columnSpanFull(),
            Forms\Components\Toggle::make('is_active')->label(__('fields.active_f'))->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('slug')->label(__('fields.slug'))->searchable(),
            Tables\Columns\TextColumn::make('title_ar')->label(__('fields.name_ar_short')),
            Tables\Columns\IconColumn::make('is_active')->label(__('fields.active_f'))->boolean(),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
