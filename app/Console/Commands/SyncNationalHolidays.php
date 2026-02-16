<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NationalHolidayService;

class SyncNationalHolidays extends Command
{
    protected $signature = 'holidays:sync {year?}';

    protected $description = 'Sinkronisasi hari libur nasional Indonesia';

    public function handle(NationalHolidayService $service)
    {
        $year = $this->argument('year') ?? now()->year;

        $this->info("Mengambil libur nasional tahun {$year}...");

        $service->syncHolidays($year);

        $this->info("Sinkronisasi selesai!");
    }
}
