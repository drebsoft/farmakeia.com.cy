<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PharmacyResource\Pages;
use App\Filament\Resources\PharmacyResource\RelationManagers;
use App\Models\Pharmacy;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class PharmacyResource extends Resource
{
    protected static ?string $model = Pharmacy::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('slug')
                    ->unique(ignorable: fn(Pharmacy $record): Pharmacy => $record)
                    ->required(),
                Forms\Components\TextInput::make('region')->required(),
                Forms\Components\TextInput::make('area')->required(),
                Forms\Components\TextInput::make('address')->nullable(),
                Forms\Components\TextInput::make('additional_address')->nullable(),
                Forms\Components\TextInput::make('map_address')->nullable(),
                Forms\Components\TextInput::make('phone')->nullable(),
                Forms\Components\TextInput::make('home_phone')->nullable(),
                Forms\Components\TextInput::make('am')->nullable(), //numeric()-> weird issue with decimals
                Forms\Components\TextInput::make('lat')->nullable(), //numeric()-> weird issue with decimals
                Forms\Components\TextInput::make('lng')->nullable(), //numeric()-> weird issue with decimals
                Forms\Components\Checkbox::make('does_rapid_tests')->default(false),
                Forms\Components\TextInput::make('rapid_test_cost')->numeric()->nullable(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('region'),
                Tables\Columns\TextColumn::make('lat'),
                Tables\Columns\TextColumn::make('lng'),
                Tables\Columns\BooleanColumn::make('does_rapid_tests'),
                Tables\Columns\TextColumn::make('rapid_test_cost'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListPharmacies::route('/'),
            'create' => Pages\CreatePharmacy::route('/create'),
            'edit' => Pages\EditPharmacy::route('/{record}/edit'),
        ];
    }
}
