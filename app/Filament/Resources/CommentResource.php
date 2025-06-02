<?php

namespace App\Filament\Resources;

use App\Models\Comment;
use App\Models\Product;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationGroup = 'إدارة التعليقات';
    protected static ?string $modelLabel = 'تعليق';
    protected static ?string $pluralModelLabel = 'التعليقات';
    protected static ?string $navigationLabel = 'التعليقات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('الاسم')
                    ->required(),

                TextInput::make('stars')
                    ->label('عدد النجوم')
                    ->numeric()
                    ->step(0.1)
                    ->minValue(0)
                    ->maxValue(5)
                    ->required(),

                Textarea::make('comment')
                    ->label('التعليق')
                    ->rows(4)
                    ->required(),

                Select::make('page_or_product')
                    ->label('الصفحة أو المنتج')
                    ->options([
                        'homepage' => 'الصفحة الرئيسية',
                        'products' => 'منتجات',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('الاسم'),
                TextColumn::make('stars')
                    ->label('عدد النجوم')
                    ->formatStateUsing(fn($state) => number_format($state, 1))
                    ->sortable(),
                TextColumn::make('comment')->label('التعليق')->limit(40),
                TextColumn::make('page_or_product')
                    ->label('المكان')
                    ->formatStateUsing(fn($state) => $state === 'homepage' ? 'الصفحة الرئيسية' : 'المنتجات'),
            ])
           
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => CommentResource\Pages\ListComments::route('/'),
            'create' => CommentResource\Pages\CreateComment::route('/create'),
            'edit' => CommentResource\Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
