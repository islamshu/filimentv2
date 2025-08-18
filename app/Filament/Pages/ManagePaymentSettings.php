<?php

namespace App\Filament\Resources\PaymentSettingsResource\Pages;

use App\Filament\Resources\PaymentSettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePaymentSettings extends ManageRecords
{
    protected static string $resource = PaymentSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('إنشاء إعدادات الدفع')
                ->using(function (array $data) {
                    // Delete all existing records
                    static::getModel()::query()->delete();
                    
                    // Create new record
                    return static::getModel()::create($data);
                }),
        ];
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Convert repeater data to simple array
        if (isset($data['multiple_payments'])) {
            $data['multiple_payments'] = array_column($data['multiple_payments'], 'value');
        }
        
        return $data;
    }
}