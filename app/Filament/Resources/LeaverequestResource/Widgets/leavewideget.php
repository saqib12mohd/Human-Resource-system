<?php

namespace App\Filament\Resources\LeaverequestResource\Widgets;

use App\Models\Leaverequest;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class leavewideget extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            // Stat::make('Leave Application', Leaverequest::count())
            // ->description('Leave Request Application that has been Inculded')
            // ->descriptionIcon('heroicon-m-tag', IconPosition::Before)
            // ->chart([1000,4000 ,8000 , 10000, 25000 , 40000])
            // ->color('warning'),
        ];
    }
}
