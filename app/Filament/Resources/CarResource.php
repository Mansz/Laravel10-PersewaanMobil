<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Filament\Resources\CarResource\RelationManagers;
use App\Models\Car;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Forms\Components\TextInput::make('brand')->required(),
                    Forms\Components\TextInput::make('model')->required(),
                    Forms\Components\TextInput::make('plate_number')->required()->unique(),
                    Forms\Components\TextInput::make('rental_rate')->required()->numeric(),
                    Forms\Components\Toggle::make('available')->default(true),
                    Forms\Components\FileUpload::make('photo') // Tambahkan komponen upload foto
                    ->nullable()
                    ->disk('public') // Adjust disk as needed
                    ->directory('photos'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('brand'),
                Tables\Columns\TextColumn::make('model'),
                Tables\Columns\TextColumn::make('plate_number'),
                Tables\Columns\TextColumn::make('rental_rate'),
                Tables\Columns\BooleanColumn::make('available'),
                Tables\Columns\ImageColumn::make('photo')
                    ->url(fn ($record) => $record->photo ? asset('storage/' . $record->photo) : null),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
