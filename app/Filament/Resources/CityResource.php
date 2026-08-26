<?php
namespace App\Filament\Resources;
use App\Filament\Resources\CityResource\Pages;
use App\Models\City;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
class CityResource extends Resource
{
    protected static ?string $model = City::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
	protected static ?string $navigationGroup = null;
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('nav.group_geo');
    }

    public static function getNavigationLabel(): string
    {
        return __('nav.wilayats');
    }

    public static function getModelLabel(): string
    {
        return __('nav.wilayat_singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('nav.wilayats');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('state_id')
                ->label(__('fields.governorate'))
                ->relationship('state', 'name_ar')
                ->searchable()
                ->required(),
            Forms\Components\TextInput::make('name_ar')
                ->label(__('fields.name_ar'))
                ->required(),
            Forms\Components\TextInput::make('name_en')
                ->label(__('fields.name_en'))
                ->required(),
            Forms\Components\TextInput::make('latitude')
                ->label('Latitude')
                ->numeric(),
            Forms\Components\TextInput::make('longitude')
                ->label('Longitude')
                ->numeric(),
        ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#'),
                Tables\Columns\TextColumn::make('state.name_ar')->label(__('fields.governorate'))->searchable(),
                Tables\Columns\TextColumn::make('name_ar')
                    ->label(__('fields.name_ar'))
                    ->searchable()
                    ->placeholder('⚠️')
                    ->color(fn ($state) => $state ? null : 'danger'),
                Tables\Columns\TextColumn::make('name_en')
                    ->label(__('fields.name_en'))
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('state_id')
                    ->label(__('fields.governorate'))
                    ->relationship('state', 'name_ar'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            'edit' => Pages\EditCity::route('/{record}/edit'),
        ];
    }
}
