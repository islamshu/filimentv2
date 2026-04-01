<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Models\Country;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'إدارة الدول';
    protected static ?string $modelLabel = 'الدولة';
    protected static ?string $pluralModelLabel = 'الدول';
    protected static ?string $navigationLabel = 'الدول';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('اسم الدولة')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('code')
                    ->label('رمز الدولة')
                    ->required()
                    ->maxLength(10)
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('currency')
                    ->label('العملة')
                    ->required()
                    ->maxLength(10),

                Forms\Components\FileUpload::make('flag')
                    ->label('علم الدولة')
                    ->image()
                    ->directory('countries')
                    ->imagePreviewHeight('100')
                    ->nullable(),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('flag')
                    ->label('العلم')
                    ->disk('public')
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->label('اسم الدولة')
                    ->searchable(),

                Tables\Columns\TextColumn::make('code')
                    ->label('الرمز')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('currency')
                    ->label('العملة')
                    ->badge()
                    ->color('success'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
}