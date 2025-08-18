<?php

namespace App\Filament\Resources\PaymentSettingsResource\Pages;

use App\Filament\Resources\PaymentSettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaymentSettings extends ListRecords
{
    protected static string $resource = PaymentSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
