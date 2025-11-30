<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PexelsService;

class CheckPexelsUsage extends Command
{
    protected $signature = 'pexels:usage';
    protected $description = 'Check Pexels API usage statistics';

    public function handle(): void
    {
        $service = new PexelsService();
        $stats = $service->getUsageStats();

        $this->info('Pexels API Usage Statistics:');
        $this->line('Hourly requests: ' . $stats['hourly'] . '/' . $stats['hourly_limit']);
        $this->line('Monthly requests: ' . $stats['monthly'] . '/' . $stats['monthly_limit']);
        $this->line('Remaining hourly: ' . $stats['remaining_hourly']);
        $this->line('Remaining monthly: ' . $stats['remaining_monthly']);

        if ($stats['remaining_hourly'] < 20) {
            $this->warn('Warning: Hourly limit almost reached!');
        }

        if ($stats['remaining_monthly'] < 100) {
            $this->warn('Warning: Monthly limit almost reached!');
        }
    }
}
