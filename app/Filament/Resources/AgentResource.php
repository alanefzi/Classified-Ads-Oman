<?php
namespace App\Filament\Resources;

use App\Filament\Resources\AgentResource\Pages;
use App\Models\Agent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AgentResource extends Resource
{
    protected static ?string $model = Agent::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = null;
    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): ?string
    {
        return __('nav.group_content');
    }

    public static function getNavigationLabel(): string
    {
        return 'المندوبين';
    }

    public static function getModelLabel(): string
    {
        return 'مندوب';
    }

    public static function getPluralModelLabel(): string
    {
        return 'المندوبين';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('اسم المندوب')
                ->required(),

            Forms\Components\TextInput::make('phone')
                ->label('رقم الهاتف (للاتصال)')
                ->tel()
                ->required()
                ->placeholder('+96890000000')
                ->helperText('اكتب الرقم كامل مع رمز الدولة، مثال: +96890000000'),

            Forms\Components\TextInput::make('whatsapp')
                ->label('رقم الواتساب (اختياري)')
                ->tel()
                ->placeholder('+96890000000')
                ->helperText('لو تركته فاضي، بنستخدم رقم الهاتف نفسه للواتساب تلقائياً'),

            Forms\Components\TextInput::make('city')
                ->label('المنطقة (اختياري)')
                ->placeholder('مثال: مسقط'),

            Forms\Components\TextInput::make('sort_order')
                ->label('الترتيب')
                ->numeric()
                ->default(0),

            Forms\Components\Toggle::make('is_active')
                ->label('مفعّل')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('الهاتف'),
                Tables\Columns\TextColumn::make('whatsapp')->label('واتساب')->placeholder('— نفس الهاتف'),
                Tables\Columns\TextColumn::make('city')->label('المنطقة')->placeholder('—'),
                Tables\Columns\IconColumn::make('is_active')->label('مفعّل')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->label('الترتيب')->sortable(),
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
            'index' => Pages\ListAgents::route('/'),
            'create' => Pages\CreateAgent::route('/create'),
            'edit' => Pages\EditAgent::route('/{record}/edit'),
        ];
    }
}
