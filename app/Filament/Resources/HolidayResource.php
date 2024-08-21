<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HolidayResource\Pages;
use App\Filament\Resources\HolidayResource\RelationManagers;
use App\Models\Holiday;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HolidayResource extends Resource
{
    protected static ?string $model = Holiday::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-2-stack';

    protected static ?string $navigationGroup = 'Details';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([

                    Section::make()
                    ->schema([

                        TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur:true)
                        ->afterStateUpdated(function($set,  $state)
                        {
                            $set('slug',Str::slug($state));
                        }),

                        TextInput::make('arname')
                        ->label('Arabic Name')
                        ->maxLength(255),

                        TextInput::make('slug')
                        ->maxLength(255),

                    ])->columns(3),

                    Fieldset::make()
                    ->label('Holiday Start and Ending Date')
                    ->schema([

                        DatePicker::make('from')
                        ->live(),

                        DatePicker::make('to')
                        ->live(),

                        Placeholder::make('count')
                        ->content(function(Get $get){
                            $date1=Carbon::parse($get('from'));
                            $date2=Carbon::parse($get('to'));
                            $diff=$date1->diffInDays($date2);
                            return $diff.' Days';
                        })

                    ])->columns(3),


                    Toggle::make('isactive')
                    ->label('Is Active?')
                    ->onIcon('heroicon-m-check-circle')
                    ->offIcon('heroicon-m-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->inline(false)
                    ->required(),


                ])->columns(2),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('arname')
                ->label('Arabic Name')
                    ->searchable(),

                TextColumn::make('slug')
                    ->searchable(),

                TextColumn::make('from')
                ->label('Start Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('to')
                ->label('Ending Date')
                    ->date()
                    ->sortable(),

                IconColumn::make('isactive')
                ->label('Active')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([

                Tables\Actions\EditAction::make()
                ->icon('heroicon-m-pencil-square')
                ->iconButton(),

                Tables\Actions\ViewAction::make()
                ->icon('heroicon-m-eye')
                ->iconButton(),

                Tables\Actions\DeleteAction::make()
                ->icon('heroicon-m-trash')
                ->iconButton(),

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
            'index' => Pages\ListHolidays::route('/'),
            'create' => Pages\CreateHoliday::route('/create'),
            'edit' => Pages\EditHoliday::route('/{record}/edit'),
        ];
    }
}
