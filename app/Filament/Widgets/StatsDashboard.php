<?php

namespace App\Filament\Widgets;

use App\Models\categories;
use App\Models\tasks;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsDashboard extends BaseWidget
{
    protected function getStats(): array
    {
        $countTasks = tasks::count();
        $countCategories = categories::count();
        $countUsers = User::count();
        return [
            Stat::make('Total Tasks', $countTasks . ' Tasks')
                ->description('Total number of tasks created')
                ->icon('heroicon-o-briefcase')
                ->color('primary'),
            Stat::make('Total Categories', $countCategories . ' Categories')
                ->description('Total number of categories')
                ->icon('heroicon-o-rectangle-stack')
                ->color('primary'),
            Stat::make('Total Users', $countUsers . ' Users')
                ->description('Total number of categories')
                ->icon('heroicon-o-user')
                ->color('primary'),
        ];
    }
}
