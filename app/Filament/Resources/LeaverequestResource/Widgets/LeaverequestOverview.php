<?php

namespace App\Filament\Resources\LeaverequestResource\Widgets;

use App\Filament\Resources\LeaverequestResource;
use App\Filament\Resources\LeaverequestResource\Pages\ListLeaverequests;
use App\Models\Leaverequest;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LeaverequestOverview extends BaseWidget
{


    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListLeaverequests::class;
    }

    protected function getStats(): array
    {
        return [

            Stat::make('Total ', $this->getPageTableRecords()->count())
            ->description('Leave Request Application that has been Inculded')
            ->descriptionIcon('heroicon-m-users', IconPosition::Before)
            ->chart([1000,4000 ,8000 , 10000, 25000 , 40000])
            ->color('success'),

            Stat::make('Number of Leave Days', $this->getPageTableRecords()->sum('leavedays'))
            ->description('Total Number of Leave, which as been taken by the Employee ')
            ->descriptionIcon('heroicon-m-document-text', IconPosition::Before)
            ->chart([1000,4000 ,8000 , 10000, 25000 , 40000])
            ->color('warning'),

            Stat::make('Paid Leaves', $this->getPageTableRecords()->where('leave.isPaidleave','==', 1)->sum('leavedays'))
            ->description('Total Number of Leave, which as been taken by the Employee ')
            ->descriptionIcon('heroicon-m-document-text', IconPosition::Before)
            ->chart([1000,4000 ,8000 , 10000, 25000 , 40000])
            ->color('info'),

            Stat::make('UnPaid Leaves', $this->getPageTableRecords()->where('leave.isPaidleave','==',0)->sum('leavedays'))
            ->description('Total Number of Leave, which as been taken by the Employee ')
            ->descriptionIcon('heroicon-m-document-text', IconPosition::Before)
            ->chart([1000,4000 ,8000 , 10000, 25000 , 40000])
            ->color('danger'),
        ];
    }
}
