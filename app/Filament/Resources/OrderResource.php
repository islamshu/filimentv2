<?php

namespace App\Filament\Resources;

use App\Filament\Pages\InvoicePage;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Tables\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class OrderResource extends Resource
{
    // تحديد نموذج البيانات
    protected static ?string $model = Order::class;

    // أيقونة التنقل
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag'; // أيقونة أكثر مناسبة

    // تسمية التنقل
    protected static ?string $navigationLabel = 'الطلبات';

    // تسمية نموذج البيانات المفرد
    protected static ?string $modelLabel = 'الطلب';

    // تسمية نموذج البيانات الجمع
    protected static ?string $pluralModelLabel = 'الطلبات';

    // دالة الجدول لعرض الأعمدة
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // عمود لعرض رمز الطلب
                TextColumn::make('code')->searchable()->label('رمز الطلب'),

                // عمود لعرض اسم العميل
                TextColumn::make('name')->label('اسم العميل'),

                // عمود لعرض رقم الهاتف
                TextColumn::make('phone')->label('رقم الهاتف'),

                // عمود لعرض البريد الإلكتروني
                // TextColumn::make('email')->label('البريد الإلكتروني'),

                // عمود لعرض المبلغ المدفوع
                TextColumn::make('payment')->label('المبلغ المدفوع')->suffix(' ' . get_general_value('currancy')),
                TextColumn::make('payment_getway')
                    ->label('طريقة الدفع')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'all' => 'كامل',
                            'installment' => 'تقسيط',
                            default => $state, // افتراضيًا إذا لم تكن القيمة معروفة
                        };
                    }),
                TextColumn::make('CashOrBatch')->label('فترة التقسيط')->formatStateUsing(function ($state) {
                    return match ($state) {

                        '0' => '_',

                        default => $state, // افتراضيًا إذا لم تكن القيمة معروفة
                    };
                }),
                TextColumn::make('first_batch')
                    ->label('الدفعة الأولى')



            ])
            ->actions([
                // إجراء لعرض تفاصيل الطلب
                \Filament\Tables\Actions\ViewAction::make(),
                Action::make('عرض الفاتورة')
                    ->label('عرض الفاتورة')
                    ->icon('heroicon-o-document-text')
                    ->url(fn($record) => route('invoice.show', $record)) // تأكد أن لديك هذا الراوت
                    ->openUrlInNewTab(),
                Action::make('عقد التقسيط ')
                    ->label('عقد التقسيط ')
                    ->icon('heroicon-o-document-text')
                    ->url(fn($record) => route('invoice.contact', $record->code)) // تأكد أن لديك هذا الراوت
                    ->openUrlInNewTab(),

                \Filament\Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // إجراء لحذف الطلبات بشكل جماعي
                \Filament\Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    // دالة العلاقات في حال وجود علاقات مع نماذج أخرى
    public static function getRelations(): array
    {
        return [
            // إضافة مديري العلاقات إذا لزم الأمر
        ];
    }

    // دالة صفحات الموارد
    public static function getPages(): array
    {
        return [
            // صفحة عرض القائمة الرئيسية
            'index' => Pages\ListOrders::route('/'),

            // صفحة عرض تفاصيل الطلب
            'view' => Pages\ViewOrder::route('/{record}'),
            // صفحة مخصصة
        ];
    }
}
