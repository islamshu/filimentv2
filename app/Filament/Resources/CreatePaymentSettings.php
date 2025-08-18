<?php

namespace App\Filament\Resources\PaymentSettingsResource\Pages;

use App\Filament\Resources\PaymentSettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentSettings extends CreateRecord
{
    protected static string $resource = PaymentSettingsResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Convert repeater data to simple array
        if (isset($data['multiple_payments'])) {
            $data['multiple_payments'] = array_column($data['multiple_payments'], 'value');
        }
        
        return $data;
    }
}