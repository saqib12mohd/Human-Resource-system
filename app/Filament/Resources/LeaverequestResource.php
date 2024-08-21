<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaverequestResource\Pages;
use App\Filament\Resources\LeaverequestResource\RelationManagers;
use App\Filament\Resources\LeaverequestResource\Widgets\LeaverequestOverview;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Leaverequest;
use App\Models\Position;
use Carbon\Carbon;
use Filament\Actions\Exports\ExportColumn;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Range;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Ramsey\Uuid\Type\Integer;

class LeaverequestResource extends Resource
{
    protected static ?string $model = Leaverequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Leave Request';

    protected static ?string $navigationGroup = 'Details';

    protected static ?string $pluralModelLabel = 'Leave Request';

    // public static function getWidgets(): array
    // {
    //     return [

    //         LeaverequestOverview::class,
    //     ];
    // }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()
                ->schema([

                    DatePicker::make('date')
                    ->default(now())
                    ->columnSpan(1),


                    Section::make()
                    ->schema([

                        Select::make('employee_id')
                        ->label('Employee Name')
                        ->relationship('employee','name')
                        ->required()
                        ->live()

                        ->afterStateUpdated(function ($state, callable $set)
                        {
                        $selectvalue = Employee::find($state);
                        $set('department_id', $selectvalue->department_id);
                        $set('position_id', $selectvalue->position_id);

                        }),

                        Select::make('department_id')
                        ->label('Department')
                        ->options(Department::all()->pluck('name', 'id')),



                        Select::make('position_id')
                        ->label('Position')
                       ->options(Position::all()->pluck('name', 'id')),


                    ])->columns(3),


                    Section::make()
                    ->schema([

                    Select::make('leave_id')
                    ->label('Leave Request For?')
                    ->relationship('leave','name')
                    ->required(),

                    Textarea::make('description')
                    ->maxLength(255),

                    ])
                    ->columns(2),

                    Fieldset::make('Date')
                    ->label('Leave Start And Ending')
                    ->schema([

                    DatePicker::make('from')
                    ->live(),
                    DatePicker::make('upto')
                    ->live(),

                    // TextInput::make('total'),

                    Placeholder::make('count')
                    ->content(function(Get $get){
                        $date1=Carbon::parse($get('from'));
                        $date2=Carbon::parse($get('upto'));
                        $diff=$date1->diffInDays($date2);
                        return $diff.' Days';
                    })




                    ])->columns(3),

                    FileUpload::make('attachment'),


                ])->columns(3),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->deferFilters()
            ->columns([



                Tables\Columns\TextColumn::make('employee.name')
                    ->numeric()
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('leave.name')
                    ->numeric()
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.department.name')
                ->label('department')
                ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.position.name')
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('from')
                    ->date()
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('upto')
                    ->date()
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                ->wrap()
                    ->searchable(),

                    // Tables\Columns\TextColumn::make('daysAuto')
                    // ->getStateUsing(function($record)
                    // {
                    //     $date1=Carbon::parse($record->from);
                    //     $date2=Carbon::parse($record->upto);
                    //     $diff=$date1->diffInDays($date2);
                    //     return $diff;
                    // }),

                    TextColumn::make('leavedays')




                //  ViewColumn::make('count')->view('filament.tables.columns.Leaveday'),


                // Tables\Columns\TextColumn::make('attachment')
                //     ->searchable(),

            ])

            ->filters([



                SelectFilter::make('employee_id')
                ->label('Select Employee Name')
                ->relationship('employee','name'),


                // ->searchable()
                // ->preload(),

                // TernaryFilter::make('is_visible')
                // ->boolean()
                // ->trueLabel('Only Visible')
                // ->falseLabel('only hidden')
                // ->native(false),

            ],layout: FiltersLayout::AboveContent)


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

    // public static function getHeaderWidgets(): array
    // {

    // }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeaverequests::route('/'),
            'create' => Pages\CreateLeaverequest::route('/create'),
            'edit' => Pages\EditLeaverequest::route('/{record}/edit'),
        ];
    }
}
