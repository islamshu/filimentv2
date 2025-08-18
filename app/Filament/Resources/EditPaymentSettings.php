<?php

namespace App\Filament\Resources\PaymentSettingsResource\Pages;

use App\Filament\Resources\PaymentSettingsResource;
use App\Models\PaymentSettings;
use Filament\Resources\Pages\EditRecord;

class EditPaymentSettings extends EditRecord
{
    protected static string $resource = PaymentSettingsResource::class;

    // تجاوز mount لتحديد السجل تلقائيًا
    public function mount(string|int $record = null): void
    {
        // جلب أول سجل أو إنشاء سجل جديد إذا لم يوجد
        $paymentSettings = PaymentSettings::firstOrCreate([]);
        parent::mount($paymentSettings->id);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // تحويل بيانات multiple_payments لتنسيق repeater
        if (isset($data['multiple_payments']) && is_array($data['multiple_payments'])) {
            $data['multiple_payments'] = array_map(fn($value) => ['value' => $value], $data['multiple_payments']);
        }
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // تحويل بيانات repeater لمصفوفة عادية
        if (isset($data['multiple_payments'])) {
            $data['multiple_payments'] = array_column($data['multiple_payments'], 'value');
        }
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return []; // إزالة زر الإنشاء
    }
}
