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

use function Symfony\Component\String\s;

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
                            ->suffix((fn ($record) => $record->order_currancy)),

                       
                    ])
                    ->columns(2),


                Section::make('تفاصيل المنتجات')
                    ->schema([
                        RepeatableEntry::make('orderDetails')
                            ->label('المنتجات')
                            ->schema([
                                TextEntry::make('product_name')->label('اسم المنتج'),
                                TextEntry::make('quantity')->label('الكمية'),
                                TextEntry::make('price')->label('السعر')->suffix((fn ($record) => $record->order_currancy)),
                                TextEntry::make('total')
                                    ->label('الإجمالي')
                                    ->suffix((fn ($record) => $record->order_currancy))
                                    ->state(function ($record) {
                                        return $record->price * $record->quantity;
                                    }),
                            ])
                            ->columns(4),
                    ]),
              

            ]);
    }
 
}
