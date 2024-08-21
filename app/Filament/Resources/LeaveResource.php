<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveResource\Pages;
use App\Filament\Resources\LeaveResource\RelationManagers;
use App\Models\Leave;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeaveResource extends Resource
{
    protected static ?string $model = Leave::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell-snooze';

    protected static ?string $navigationGroup = 'Details';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()
                ->schema([

                    TextInput::make('name')
                    ->required()
                    ->columnSpan(2)
                    ->maxLength(255)
                    ->live(onBlur:true)
                    ->afterStateUpdated(function($set,  $state)
                    {
                        $set('slug',Str::slug($state));
                    }),

                TextInput::make('arname')
                ->label('Arabic Name')
                ->columnSpan(2)
                    ->maxLength(255),

                TextInput::make('slug')
                    ->maxLength(255),

                TextInput::make('leavedays')
                    ->numeric()
                    ->default(1),

                Radio::make('applicablegender')
                ->label('Applicable Gender')
                ->inline()
                ->inlineLabel(false)
                ->columnSpan(2)
                    ->options([
                        'all' => 'All',
                        'male' => 'Male',
                        'female' => 'Female'
                    ]),

                Toggle::make('isDocumentrequired')
                ->label('Document Required?')
                ->inline(false)
                ->onIcon('heroicon-m-check-circle')
                    ->offIcon('heroicon-m-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->required(),

                Toggle::make('isPaidleave')
                ->label('Paid Leave')
                ->inline(false)
                ->onIcon('heroicon-m-check-circle')
                    ->offIcon('heroicon-m-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->required(),

                Toggle::make('isactive')
                ->label('Active')
                ->inline(false)
                ->onIcon('heroicon-m-check-circle')
                    ->offIcon('heroicon-m-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->required(),

                Textarea::make('description')
                ->columnSpanFull()
                    ->maxLength(255),




                ])->columns(4),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->striped()
            ->columns([

                TextColumn::make('name')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('arname')
                ->label('Arabic Name')
                ->wrap()
                    ->searchable(),

                TextColumn::make('slug')
                ->wrap()
                    ->searchable(),

                TextColumn::make('leavedays')
                ->wrap()
                    ->numeric()
                    ->sortable(),

                TextColumn::make('description')
                ->wrap()
                ->label('Description')
                    ->searchable(),

                TextColumn::make('applicablegender')
                ->wrap()
                ->label('Applicablilty')
                    ->searchable(),

                IconColumn::make('isDocumentrequired')
                ->wrap()
                ->label('Document')
                    ->boolean(),

                IconColumn::make('isPaidleave')
                ->wrap()
                ->label('Paid')
                    ->boolean(),

                IconColumn::make('isactive')
                ->wrap()
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
            'index' => Pages\ListLeaves::route('/'),
            'create' => Pages\CreateLeave::route('/create'),
            'edit' => Pages\EditLeave::route('/{record}/edit'),
        ];
    }
}
