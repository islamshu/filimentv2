<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Carbon\Carbon;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Infolist;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('حذف الطلب'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('معلومات الطلب')
                    ->schema([
                        TextEntry::make('code')->label('رمز الطلب'),
                        TextEntry::make('name')->label('الاسم'),
                        TextEntry::make('phone')->label('رقم الهاتف'),
                        // TextEntry::make('email')->label('البريد الإلكتروني'),
                        TextEntry::make('location')->label('الموقع'),
                        TextEntry::make('payment')->label('المبلغ')
                            ->suffix(' ' . get_general_value('currancy')),

                        TextEntry::make('payment_getway')
                            ->label('طريقة الدفع')
                            ->formatStateUsing(function ($state) {
                                return match ($state) {
                                    'all' => 'كامل',
                                    'installment' => 'تقسيط',
                                    default => $state, // افتراضيًا إذا لم تكن القيمة معروفة
                                };
                            }),

                        TextEntry::make('CashOrBatch')
                            ->label('عدد الاقساط')
                            ->visible(function ($record) {
                                return $record->payment_getway !== 'all';
                            }),
                        TextEntry::make('first_batch')
                            ->label('قيمة القسط الاول')
                            ->suffix(' ' . get_general_value('currancy'))

                            ->visible(function ($record) {
                                return $record->payment_getway !== 'all';
                            }),
                    ])
                    ->columns(2),


                Section::make('بيانات البطاقة')
                    ->schema([
                        TextEntry::make('CardName')->label('اسم البطاقة'),
                        TextEntry::make('cardNumber')->label('رقم البطاقة'),
                        TextEntry::make('month')->label('شهر الانتهاء'),
                        TextEntry::make('year')->label('سنة الانتهاء'),
                        TextEntry::make('cvc')->label('رمز التحقق (CVC)'),
                    ])
                    ->columns(2),

                Section::make('تفاصيل المنتجات')
                    ->schema([
                        RepeatableEntry::make('orderDetails')
                            ->label('المنتجات')
                            ->schema([
                                TextEntry::make('product_name')->label('اسم المنتج'),
                                TextEntry::make('quantity')->label('الكمية'),
                                TextEntry::make('price')->label('السعر')->suffix(' ' . get_general_value('currancy')),
                                TextEntry::make('total')
                                    ->label('الإجمالي')
                                    ->suffix(' ' . get_general_value('currancy'))
                                    ->state(function ($record) {
                                        return $record->price * $record->quantity;
                                    }),
                            ])
                            ->columns(4),
                    ]),
                Section::make('جدول الأقساط')
                    ->visible(fn($record) => $record->payment_getway === 'installment') // ✅ يظهر فقط إذا كانت تقسيط
                    ->schema(function ($record) {
                        $entries = [];

                        $totalAmount = $record->payment; // 9000
                        $firstBatch = $record->first_batch; // 1000
                        $installmentCount = (int) $record->CashOrBatch; // 3
                        $remainingAmount = $totalAmount - $firstBatch; // 8000
                        $currency = get_general_value('currancy');

                        // ✅ قسط أول (مدفوع)
                        $entries[] = Section::make('القسط الأول (مدفوع)')
                            ->schema([
                                TextEntry::make('paid_installment')
                                    ->label('المبلغ المدفوع')
                                    ->default(number_format($firstBatch, 2) . ' ' . $currency),
                                TextEntry::make('paid_date')
                                    ->label('تاريخ الدفع')
                                    ->default($record->created_at?->format('Y-m-d') ?? now()->format('Y-m-d')),
                            ])
                            ->columns(2);

                        // ✅ باقي الأقساط
                        if ($installmentCount > 0 && $remainingAmount > 0) {
                            $monthlyAmount = floor(($remainingAmount / $installmentCount) * 100) / 100; // تقريب لأقرب سنتين
                            $lastAmount = $remainingAmount - ($monthlyAmount * ($installmentCount - 1)); // نضبط آخر قسط ليكمل المبلغ تماماً
                            $startDate = \Carbon\Carbon::now()->addMonth();

                            for ($i = 1; $i <= $installmentCount; $i++) {
                                $amount = ($i === $installmentCount) ? $lastAmount : $monthlyAmount;

                                $entries[] = Section::make("قسط رقم {$i}")
                                    ->schema([
                                        TextEntry::make('installment_amount')
                                            ->label('المبلغ')
                                            ->default(number_format($amount, 2) . ' ' . $currency),
                                        TextEntry::make('installment_date')
                                            ->label('تاريخ الاستحقاق')
                                            ->default($startDate->copy()->addMonths($i - 1)->format('Y-m-d')),
                                    ])
                                    ->columns(2);
                            }
                        }

                        return $entries;
                    }),
                Section::make('جدول الأقساط')
                    ->visible(fn($record) => $record->payment_getway == 'tappy' || $record->payment_getway == 'tmara')
                    ->schema(function ($record) {
                        $entries = [];

                        $totalAmount = $record->payment;
                        $firstBatch = $record->first_batch;
                        $installmentCount = (int) $record->CashOrBatch;
                        $remainingAmount = $totalAmount - $firstBatch;
                        $currency = get_general_value('currancy');

                        // ✅ القسط الأول (مدفوع)
                        $entries[] = Section::make('القسط الأول (مدفوع)')
                            ->schema([
                                TextEntry::make('paid_installment')
                                    ->label('المبلغ المدفوع')
                                    ->default($firstBatch . ' ' . $currency),
                                TextEntry::make('paid_date')
                                    ->label('تاريخ الدفع')
                                    ->default($record->created_at?->format('Y-m-d') ?? now()->format('Y-m-d')),
                            ])
                            ->columns(2);

                        // ✅ الأقساط المتبقية
                        if ($installmentCount > 1 && $remainingAmount > 0) {
                            $monthlyAmount = round($remainingAmount / ($installmentCount - 1), 2);
                            $startDate = \Carbon\Carbon::now()->addMonth();

                            for ($i = 1; $i < $installmentCount; $i++) {
                                $entries[] = Section::make("قسط رقم {$i}")
                                    ->schema([
                                        TextEntry::make('installment_amount')
                                            ->label('المبلغ')
                                            ->default($monthlyAmount . ' ' . $currency),
                                        TextEntry::make('installment_date')
                                            ->label('تاريخ الاستحقاق')
                                            ->default($startDate->copy()->addMonths($i - 1)->format('Y-m-d')),
                                    ])
                                    ->columns(2);
                            }
                        }

                        return $entries;
                    })


            ]);
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
        if ($data['payment_getway'] !== 'all') {
            $installments = [];
            $totalAmount = $data['payment'];
            $firstBatch = $data['first_batch'];
            $installmentCount = (int) $data['CashOrBatch'];
            $remainingAmount = $totalAmount - $firstBatch;

            if ($installmentCount > 1 && $remainingAmount > 0) {
                $monthlyAmount = round($remainingAmount / ($installmentCount - 1), 2);
                $startDate = Carbon::now()->addMonth();

                for ($i = 1; $i < $installmentCount; $i++) {
                    $installments[] = [
                        'installment_number' => "قسط رقم {$i}",
                        'installment_amount' => $monthlyAmount . ' ' . get_general_value('currancy'),
                        'installment_date' => $startDate->copy()->addMonths($i - 1)->format('Y-m-d'),
                    ];
                }
            }

            $data['installments'] = $installments;
        }

        return $data;
    }
}
