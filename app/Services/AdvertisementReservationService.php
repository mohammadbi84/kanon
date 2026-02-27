<?php

namespace App\Services;

use App\Models\Advertisement;
use App\Models\Position;
use App\Models\AdvertisementReservation;
use App\Models\PositionPrice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class AdvertisementReservationService
{
    /**
     * Create reservations for selected days
     */
    public function reserve(
        Advertisement $advertisement,
        Position $position,
        array $days, // ['2026-01-01', '2026-01-02']
        int $durationSeconds
    ) {
        return DB::transaction(function () use (
            $advertisement,
            $position,
            $days,
            $durationSeconds
        ) {

            $totalPrice = 0;
            $reservations = [];

            foreach ($days as $day) {

                $date = Carbon::parse($day)->startOfDay();

                // 1️⃣ بررسی ظرفیت یا تداخل
                $this->ensureCapacity($position, $date);

                // 2️⃣ محاسبه قیمت
                $price = $this->calculatePrice(
                    $position,
                    $date,
                    $durationSeconds
                );

                // 3️⃣ ساخت رزرو
                $reservation = AdvertisementReservation::create([
                    'advertisement_id' => $advertisement->id,
                    'position_id'      => $position->id,
                    'date'             => $date,
                    'duration_seconds' => $durationSeconds,
                    'price'            => $price,
                    'status'           => 'reserved',
                ]);

                $reservations[] = $reservation;
                $totalPrice += $price;
            }

            return [
                'total_price' => $totalPrice,
                'reservations' => $reservations
            ];
        });
    }

    /**
     * Check if position has capacity for that day
     */
    protected function ensureCapacity(Position $position, Carbon $date)
    {
        $capacity = $position->settings['daily_capacity'] ?? 1;

        $reservedCount = AdvertisementReservation::where('position_id', $position->id)
            ->whereDate('date', $date)
            ->where('status', 'reserved')
            ->count();

        if ($reservedCount >= $capacity) {
            throw new Exception("ظرفیت این جایگاه در تاریخ {$date->toDateString()} تکمیل شده است.");
        }
    }

    /**
     * Calculate price based on pricing rules
     */
    protected function calculatePrice(
        Position $position,
        Carbon $date,
        int $durationSeconds
    ): float {

        $rule = PositionPrice::where('position_id', $position->id)
            ->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->first();

        if (!$rule) {
            throw new Exception("قیمت برای تاریخ {$date->toDateString()} تعریف نشده است.");
        }

        $basePrice = $rule->price;

        // اگر قیمت بر اساس ثانیه محاسبه میشه
        if ($rule->price_type === 'per_second') {
            return $basePrice * $durationSeconds;
        }

        // قیمت ثابت روزانه
        return $basePrice;
    }

    /**
     * Cancel reservation
     */
    public function cancel(AdvertisementReservation $reservation)
    {
        $reservation->update([
            'status' => 'cancelled'
        ]);
    }
}
