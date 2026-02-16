<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\NationalHoliday;

class NationalHolidayService
{
    public function syncHolidays(int $year): void
    {
        $url = "https://date.nager.at/api/v3/PublicHolidays/{$year}/ID";

        $response = Http::get($url);

        if (!$response->ok()) {
            throw new \Exception("Gagal mengambil data libur nasional");
        }

        $holidays = $response->json();

        foreach ($holidays as $holiday) {
            NationalHoliday::updateOrCreate(
                ['date' => $holiday['date']],
                ['name' => $holiday['localName']]
            );
        }
    }
}
