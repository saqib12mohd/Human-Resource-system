<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use illuminate\support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpParser\Node\Stmt\Label;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

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

                        TextInput::make('code')
                        ->label('Project Code')
                            ->required()
                            ->numeric(),


                    ])->columns(4),


                    Section::make()
                    ->schema([



                        TextInput::make('customer')
                            ->required()
                            ->maxLength(255),

                        Select::make('status')
                        ->label('Project Status')
                            ->options([
                                'pending' => 'Pending',
                                'complete' => 'Complete',
                            ])
                            ->required(),


                        Textarea::make('Description')
                        ->columnSpanFull()
                            ->maxLength(255),

                    ])->columns(2),

                    Section::make()
                    ->schema([


                    Fieldset::make()
                    ->label(' Estimated  Date')
                    ->schema([


                        DatePicker::make('esstimedStartDate')
                        ->Label('Start Date'),

                        DatePicker::make('esstimedEndDate')
                        ->Label('Ending Date'),


                    ]),

                    Fieldset::make()
                    ->label(' Actual  Date')
                    ->schema([

                        DatePicker::make('accualstartDate')
                        ->Label('Start Date'),

                        DatePicker::make('accualendDate')
                        ->Label('Ending Date'),

                    ]),

                    Fieldset::make()
                    ->label(' Hour Details')
                    ->schema([


                    TextInput::make('hourlyrate')
                    ->label('Hourly Rate')
                        ->required()
                        ->numeric(),

                    TimePicker::make('esstimedhours')
                    ->label('Esstimed Hours'),

                    ]),

                    ]),




                ])->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([






                            TextColumn::make('name')
                            ->wrap(),

                                // ->searchable(isIndividual:true),


                            TextColumn::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'complete' => 'success',
                                'pending' => 'danger',
                            })
                            ->toggleable()
                            ->wrap()
                            ->searchable(),








                        TextColumn::make('arname')
                        ->toggleable()
                        ->wrap()
                        ->label('Arabic Name')
                            ->searchable(),



                            TextColumn::make('code')
                            ->toggleable()
                            ->wrap()
                            ->numeric()
                            ->sortable(),

                            TextColumn::make('esstimedStartDate')
                            ->label('Esstimed Start')
                            ->toggleable()
                                ->date()
                                ->sortable(),

                            TextColumn::make('esstimedEndDate')
                            ->label('Esstimed End')
                            ->toggleable()
                                ->date()
                                ->sortable(),


                                TextColumn::make('accualstartDate')
                                ->label('Actual Start')
                                ->toggleable()
                                    ->date()
                                    ->sortable(),

                                TextColumn::make('accualendDate')
                                ->label('Actual End')
                                ->toggleable()
                                    ->date()
                                    ->sortable(),



                                TextColumn::make('hourlyrate')
                                ->label(' Hourly Rate')
                                ->toggleable()
                                    ->numeric()
                                    ->sortable(),

                                TextColumn::make('esstimedhours')
                                ->label('Estimed Hour')
                                ->toggleable()
                                    ->date()
                                    ->sortable(),



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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
