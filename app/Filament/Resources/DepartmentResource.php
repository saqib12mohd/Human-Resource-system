<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentResource\Pages;
use App\Filament\Resources\DepartmentResource\RelationManagers;
use App\Models\Department;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationGroup = 'Details';


    // protected static ?string $navigationParentItem = 'Department';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Department Details')
                ->collapsible()
                ->schema([
                    TextInput::make('name')
                    ->label('Department Name')
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
                    ->readOnly()
                    ->maxLength(255),


                    TextInput::make('grade')
                    ->label('Grade')
                    ->numeric()
                        ->maxLength(3),
                ])->columns(2),

                Section::make()
                ->schema([


                    TableRepeater::make('departmententry')
                    ->label('Position')
                    ->relationship()
                    ->schema([
                        TextInput::make('name')
                        ->label('Department Name')
                        ->required()
                        ->live(onBlur:true)
                        ->afterStateUpdated(function($set,  $state)
                        {
                            $set('slug',Str::slug($state));
                        })
                        ->maxLength(255),

                        TextInput::make('arname')
                        ->label('Arabic Name')
                        ->maxLength(255),

                        TextInput::make('slug')
                        ->maxLength(255),

                        TextInput::make('grade')
                        ->label('Grade')
                        ->maxLength(3),

                        // Select::make('department_id')
                        // ->relationship('department','id')
                        // ->label('Department id')
                        // ->searchable()
                        // ->preload(),
                    ]),
                ]),


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

                TextColumn::make('grade')
                    ->searchable(),

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
            'index' => Pages\ListDepartments::route('/'),
            'create' => Pages\CreateDepartment::route('/create'),
            'edit' => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}
