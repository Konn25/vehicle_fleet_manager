<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class CurrencyService
{
    private string $baseUrl = 'https://api.frankfurter.dev/v2';

    /**
     * Get the exchange rate between two currencies for a specific date.
     */
    public function getRate(string $from, string $to, Carbon|string $date): float
    {
        $from = strtoupper($from);
        $to = strtoupper($to);

        if ($from === $to) {
            return 1.0;
        }

        $date = $date instanceof Carbon
            ? $date->format('Y-m-d')
            : Carbon::parse($date)->format('Y-m-d');

        $cacheKey = "currency_rate:{$from}:{$to}:{$date}:MNB";

        return Cache::remember(
            $cacheKey,
            now()->addDays(30),
            function () use ($from, $to, $date) {
                $response = Http::get(
                    "{$this->baseUrl}/rate/{$from}/{$to}",
                    [
                        'date' => $date,
                        'providers' => 'MNB',
                    ]
                );

                if ($response->failed()) {
                    throw new RuntimeException(
                        "Unable to retrieve exchange rate: {$from}/{$to} for {$date}"
                    );
                }

                $rate = $response->json('rate');

                if ($rate === null) {
                    throw new RuntimeException(
                        "Exchange rate not found: {$from}/{$to} for {$date}"
                    );
                }

                return (float) $rate;
            }
        );
    }

    /**
     * Convert an amount between two currencies for a specific date.
     */
    public function convert(
        float $amount,
        string $from,
        string $to,
        Carbon|string $date
    ): float {
        $rate = $this->getRate($from, $to, $date);

        return round($amount * $rate, 2);
    }
}
