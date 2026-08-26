<?php
namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationGroup = null;
    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('nav.group_content');
    }

    public static function getNavigationLabel(): string
    {
        return __('nav.faqs');
    }

    public static function getModelLabel(): string
    {
        return __('nav.faq_singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('nav.faqs');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('languages')->tabs([
                Forms\Components\Tabs\Tab::make('عربي')->schema([
                    Forms\Components\TextInput::make('question_ar')->label(__('fields.question'))->required(),
                    Forms\Components\Textarea::make('answer_ar')->label(__('fields.answer'))->required(),
                ]),
                Forms\Components\Tabs\Tab::make('English')->schema([
                    Forms\Components\TextInput::make('question_en')->label(__('fields.question'))->required(),
                    Forms\Components\Textarea::make('answer_en')->label(__('fields.answer'))->required(),
                ]),
            ])->columnSpanFull(),
            Forms\Components\TextInput::make('sort_order')->label(__('fields.sort_order'))->numeric()->default(0),
            Forms\Components\Toggle::make('is_active')->label(__('fields.active'))->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('question_ar')->label(__('fields.name_ar_short'))->searchable()->limit(50),
            Tables\Columns\TextColumn::make('question_en')->label(__('fields.name_en_short'))->limit(50),
            Tables\Columns\IconColumn::make('is_active')->label(__('fields.active'))->boolean(),
            Tables\Columns\TextColumn::make('sort_order')->label(__('fields.sort_order'))->sortable(),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit' => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
