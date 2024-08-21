<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\LeaverequestResource\Pages\ListLeaverequests;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Leaverequest;
use App\Models\Project;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EmployeeWidget extends BaseWidget
{


    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListLeaverequests::class;
    }
    protected function getStats(): array
    {
        return [




            Stat::make('Project', Project::count())
            ->description('New Projects that has been Inculded')
            ->descriptionIcon('heroicon-m-newspaper', IconPosition::Before)
            ->chart([1000,4000 ,8000 , 10000, 25000 , 40000])
            ->color('info'),

            Stat::make('Leave Application', Leaverequest::count())
            ->description('Leave Request Application that has been Inculded')
            ->descriptionIcon('heroicon-m-document-text', IconPosition::Before)
            ->chart([1000,4000 ,8000 , 10000, 25000 , 40000])
            ->color('success'),

            Stat::make('Users',User::count())
            ->description(' Users that has been Joined ')
            ->descriptionIcon('heroicon-m-user', IconPosition::Before)
            ->chart([1000,4000 ,8000 , 10000, 25000 , 40000])
            ->color('gray'),


            Stat::make('Total Leaves ', $this->getPageTableRecords()->count())
            ->description(' Total Leave Request Application that has been Inculded')
            ->descriptionIcon('heroicon-m-users', IconPosition::Before)
            ->chart([1000,4000 ,8000 , 10000, 25000 , 40000])
            ->color('primary'),

            Stat::make('Number of Leave Days', $this->getPageTableRecords()->sum('leavedays'))
            ->description('Total Number of Leave, which as been taken by the Employee ')
            ->descriptionIcon('heroicon-m-document-text', IconPosition::Before)
            ->chart([1000,4000 ,8000 , 10000, 25000 , 40000])
            ->color('warning'),

            Stat::make('Paid Leaves', $this->getPageTableRecords()->where('leave.isPaidleave','==', 1)->sum('leavedays'))
            ->description('Paid Leave, which as been taken by the Employee')
            ->descriptionIcon('heroicon-m-currency-rupee', IconPosition::Before)
            ->chart([1000,4000 ,8000 , 10000, 25000 , 40000])
            ->color('info'),

            Stat::make('UnPaid Leaves', $this->getPageTableRecords()->where('leave.isPaidleave','==',0)->sum('leavedays'))
            ->description('UnPaid Leave, which as been taken by the Employee ')
            ->descriptionIcon('heroicon-m-x-circle', IconPosition::Before)
            ->chart([1000,4000 ,8000 , 10000, 25000 , 40000])
            ->color('danger'),


        ];
    }
}
