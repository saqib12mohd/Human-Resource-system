<?php

namespace App\Filament\Resources\LeaverequestResource\Pages;

use App\Filament\Resources\LeaverequestResource;
use App\Filament\Resources\LeaverequestResource\Widgets\LeaverequestOverview;
use App\Filament\Resources\LeaverequestResource\Widgets\leavewideget;
use App\Filament\Widgets\EmployeeWidget;
use App\Filament\Widgets\TestWidget;
use App\Models\Leaverequest as ModelsLeaverequest;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;




class ListLeaverequests extends ListRecords
{
    use ExposesTableToWidgets;
    protected static string $resource = LeaverequestResource::class;

    protected function getHeaderWidgets(): array
    {
        return [

            LeaverequestOverview::class,

        ];
    }



    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Leave Request'),
            // Actions\ExportAction::make(),

        ];
    }

    public function getTabs(): array
    {

        return[
            // 'All' => Tab::make(),
            // 'name' => Tab::make()
            // ->modifyQueryUsing(function (Builder $query) {
            //     $query->where('employee_id', true);
            // }),
            // 'Un published' => Tab::make()
            // ->modifyQueryUsing(function (Builder $query) {
            //     $query->where('published', false);
            // }),
        ];

    }







}
