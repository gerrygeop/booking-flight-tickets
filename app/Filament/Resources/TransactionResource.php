<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Umum')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('flight_id')
                            ->relationship('flight', 'flight_number')
                            ->required(),
                        Forms\Components\Select::make('flight_class_id')
                            ->relationship('class', 'class_type')
                            ->required(),
                    ]),
                Forms\Components\Section::make('Informasi Penumpang')
                    ->schema([
                        Forms\Components\TextInput::make('number_of_passengers')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Section::make('Daftar Penumpang')
                            ->schema([
                                Forms\Components\Repeater::make('passenger')
                                    ->relationship('passengers')
                                    ->schema([
                                        Forms\Components\TextInput::make('seat.name')
                                            ->label('Seat Name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\DatePicker::make('date_of_birth')
                                            ->required(),
                                        Forms\Components\TextInput::make('nationality')
                                            ->required()
                                            ->maxLength(255),
                                    ]),
                            ]),
                    ]),

                Forms\Components\Section::make('Pembayaran')
                    ->schema([
                        Forms\Components\TextInput::make('promo.code')
                            ->numeric(),
                        Forms\Components\TextInput::make('promo.discount_type'),
                        Forms\Components\TextInput::make('promo.discount')
                            ->numeric(),
                        Forms\Components\TextInput::make('payment_status')
                            ->required(),
                        Forms\Components\TextInput::make('subtotal')
                            ->numeric(),
                        Forms\Components\TextInput::make('grandtotal')
                            ->numeric(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('flight.flight_number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_of_passengers')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('promo.code')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status'),
                Tables\Columns\TextColumn::make('subtotal')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grandtotal')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
