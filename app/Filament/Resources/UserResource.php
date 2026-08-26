<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
        protected static ?string $navigationGroup = null;
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('nav.group_users');
    }

    public static function getNavigationLabel(): string
    {
        return __('nav.users');
    }

    public static function getModelLabel(): string
    {
        return __('nav.user_singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('nav.users');
    }

    protected static function statusOptions(): array
    {
        return [
            'active' => __('fields.user_status_active'),
            'banned' => __('fields.user_status_banned'),
            'pending' => __('fields.user_status_pending'),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label(__('fields.name'))->required(),
            Forms\Components\TextInput::make('phone')->label(__('fields.phone'))->required(),
            Forms\Components\TextInput::make('email')->label(__('fields.email'))->email(),
            Forms\Components\Select::make('country_id')
                ->label(__('fields.country'))
                ->relationship('country', 'name_ar'),
            Forms\Components\Select::make('status')
                ->label(__('fields.status'))
                ->options(self::statusOptions())
                ->required(),
            Forms\Components\Toggle::make('is_business')->label(__('fields.business_account')),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#'),
                Tables\Columns\TextColumn::make('name')->label(__('fields.name'))->searchable(),
                Tables\Columns\TextColumn::make('phone')->label(__('fields.phone'))->searchable(),
                Tables\Columns\TextColumn::make('country.name_ar')->label(__('fields.country')),
                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('fields.status'))
                    ->colors([
                        'success' => 'active',
                        'danger' => 'banned',
                        'warning' => 'pending',
                    ])
                    ->formatStateUsing(fn (string $state): string => self::statusOptions()[$state] ?? $state),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('fields.registered_at'))
                    ->dateTime('Y-m-d'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('fields.status'))
                    ->options(self::statusOptions()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
