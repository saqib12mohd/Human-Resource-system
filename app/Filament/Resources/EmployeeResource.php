<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Doctrine\DBAL\Types\Type;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\MorphToSelect\Type as MorphToSelectType;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use illuminate\Support\str;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Ramsey\Collection\Collection as CollectionCollection;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-Users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()
                ->schema([

                    Section::make()
                    ->schema([

                        TextInput::make('name')
                        ->live(onBlur:true)
                        ->afterStateUpdated(function($set,  $state)
                        {
                            $set('slug',Str::slug($state));
                        })
                            ->required()
                            ->maxLength(255),

                        TextInput::make('arname')
                        ->label('Arabic Name')
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->maxLength(255),

                        TextInput::make('code')
                            ->required()
                            ->numeric(),

                    ])->columns(4),

                    Section::make()
                    ->schema([




                    Select::make('department_id')
                    ->label('Department')
                    ->relationship('department','name')
                    ->live()
                    ->required(),

                    Select::make('position_id')
                    ->label('Position')
                    ->relationship('position','name', fn($get , Builder $query)=> $query->where('department_id', $get('department_id')))
                    ->required(),

                    Select::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'other' => 'Other',
                    ])
                    ->required(),

                    ])->columns(3),



                    Fieldset::make()
                    ->schema([

                        Toggle::make('overtime')
                        ->label('Over Time?')
                        ->onIcon('heroicon-m-check-circle')
                        ->offIcon('heroicon-m-x-circle')
                        ->onColor('success')
                        ->offColor('danger')
                        ->inline(false),

                        Toggle::make('ticket')
                        ->label('Company Ticket?')
                        ->onIcon('heroicon-m-check-circle')
                        ->offIcon('heroicon-m-x-circle')
                        ->onColor('success')
                        ->offColor('danger')
                        ->inline(false),
                    ]),



                    Fieldset::make()
                    ->schema([

                    DatePicker::make('StartDate')
                    ->label('From'),

                    DatePicker::make('EndDate')
                    ->label('To'),

                ]),


                ])->columns(2),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('department.name')
                ->label('Department')
                ->wrap()
                ->toggleable()
                ->searchable()
                ->sortable(),

                TextColumn::make('position.name')
                ->label('Position')
                ->wrap()
                ->toggleable()
                ->sortable(),

                TextColumn::make('name')
                ->label('Name')
                ->wrap()
                ->toggleable()
                ->searchable(),

                TextColumn::make('arname')
                ->label('Arabic Name')
                ->wrap()
                ->toggleable()
                ->searchable(),

                TextColumn::make('slug')
                ->wrap()
                ->toggleable()
                ->searchable(),

                TextColumn::make('code')
                ->wrap()
                ->toggleable()
                ->numeric()
                ->sortable(),

                TextColumn::make('gender')
                ->wrap()
                ->toggleable()
                ->searchable(),

                TextColumn::make('overtime')
                ->label('Over Time')
                ->wrap()
                ->toggleable()
                ->searchable(),

                IconColumn::make('ticket')
                ->label('Ticket')
                ->wrap()
                ->toggleable()
                ->boolean(),

                TextColumn::make('StartDate')
                ->label('Start Date')
                ->wrap()
                ->toggleable()
                ->date()
                ->sortable(),

                TextColumn::make('EndDate')
                ->label('Ending Date')
                ->wrap()
                ->toggleable()
                ->date()
                ->sortable(),

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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
