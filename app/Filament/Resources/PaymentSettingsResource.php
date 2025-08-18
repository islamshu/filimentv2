<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentSettingsResource\Pages;
use App\Models\PaymentSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class PaymentSettingsResource extends Resource
{
    protected static ?string $model = PaymentSettings::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'إعدادات الدفعات';
    protected static ?string $modelLabel = 'إعدادات الدفعات';
    protected static ?string $navigationGroup = 'الإعدادات';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('إعدادات نظام الدفع')
                    ->schema([
                        Forms\Components\Toggle::make('custom_payment_enabled')
                            ->label('تفعيل الدفعة المخصصة')
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $set('multiple_payments_enabled', false);
                                    $set('multiple_payments', null);
                                }
                            }),
                        Forms\Components\TextInput::make('batch')
                            ->label('قيمة الدفعة المخصصة')
                            ->numeric()
                            ->visible(fn (Forms\Get $get) => $get('custom_payment_enabled'))
                            ->required(fn (Forms\Get $get) => $get('custom_payment_enabled')),
                        Forms\Components\Toggle::make('multiple_payments_enabled')
                            ->label('تفعيل الدفعات المتعددة')
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $set('custom_payment_enabled', false);
                                    $set('batch', null);
                                }
                            }),
                        Forms\Components\Repeater::make('multiple_payments')
                            ->label('قيم الدفعات المتعددة')
                            ->visible(fn (Forms\Get $get) => $get('multiple_payments_enabled'))
                            ->required(fn (Forms\Get $get) => $get('multiple_payments_enabled'))
                            ->schema([
                                Forms\Components\TextInput::make('value')
                                    ->label('قيمة الدفعة')
                                    ->numeric()
                                    ->required(),
                            ])
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\EditPaymentSettings::route('/'),
        ];
    }
}
