<?php

namespace App\Support;

use App\Enums\UserRole;
use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class TechnicianLocator
{
    private const GREEN_MINUTES = 15;

    private const ORANGE_MINUTES = 60;

    public static function buildOptionsForLocation(
        int $organizationId,
        int $locationId,
    ): array {
        return Cache::remember(
            "technician-options:{$organizationId}:{$locationId}",
            now()->addSeconds(2),
            function () use ($organizationId, $locationId): array {
                $location = Location::query()
                    ->select('latitude', 'longitude')
                    ->find($locationId);

                if (! $location) {
                    return [];
                }

                return self::buildOptions(
                    organizationId: $organizationId,
                    workOrderLatitude: $location->latitude !== null ? (float) $location->latitude : null,
                    workOrderLongitude: $location->longitude !== null ? (float) $location->longitude : null,
                );
            }
        );
    }

    private static function buildOptions(
        int $organizationId,
        ?float $workOrderLatitude,
        ?float $workOrderLongitude,
    ): array {
        $technicians = User::query()
            ->where('organization_id', $organizationId)
            ->where('role', UserRole::Technician)
            ->with('latestLocation')
            ->get();

        $rows = [];

        foreach ($technicians as $technician) {
            $location = $technician->latestLocation;
            if ($workOrderLatitude === null || $workOrderLongitude === null) {
                $rows[] = [
                    'id' => $technician->id,
                    'label' => "{$technician->name} • Work order location unavailable • ⚠️",
                    'distance' => PHP_FLOAT_MAX,
                    'status_order' => 99,
                ];

                continue;
            }
            if (! $location) {
                $rows[] = [
                    'id' => $technician->id,
                    'label' => "{$technician->name} • No location available • ❌",
                    'distance' => PHP_FLOAT_MAX,
                    'status_order' => 99,
                ];

                continue;
            }

            $distance = self::calculateDistance(
                $workOrderLatitude,
                $workOrderLongitude,
                (float) $location->latitude,
                (float) $location->longitude,
            );

            $minutes = $location->created_at->diffInMinutes(now());

            [$emoji, $statusOrder] = self::freshnessStatus($minutes);

            $rows[] = [
                'id' => $technician->id,
                'label' => sprintf(
                    '%s • %s • %s • %s',
                    $technician->name,
                    self::formatDistance($distance),
                    $location->created_at->diffForHumans(),
                    $emoji,
                ),
                'distance' => $distance,
                'status_order' => $statusOrder,
            ];
        }

        usort(
            $rows,
            function (array $a, array $b): int {
                if ($a['status_order'] !== $b['status_order']) {
                    return $a['status_order'] <=> $b['status_order'];
                }

                return $a['distance'] <=> $b['distance'];
            }
        );

        return collect($rows)
            ->pluck('label', 'id')
            ->toArray();
    }

    private static function freshnessStatus(int $minutes): array
    {
        if ($minutes <= self::GREEN_MINUTES) {
            return ['🟢', 1];
        }

        if ($minutes <= self::ORANGE_MINUTES) {
            return ['🟠', 2];
        }

        return ['🔴', 3];
    }

    private static function calculateDistance(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2,
    ): float {
        $earthRadius = 6371;

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a =
            sin($latDelta / 2) * sin($latDelta / 2)
            + cos(deg2rad($lat1))
            * cos(deg2rad($lat2))
            * sin($lonDelta / 2)
            * sin($lonDelta / 2);

        $c = 2 * atan2(
            sqrt($a),
            sqrt(1 - $a),
        );

        return $earthRadius * $c;
    }

    private static function formatDistance(float $distance): string
    {
        if ($distance < 1) {
            return round($distance * 1000).' m';
        }

        return number_format($distance, 1).' km';
    }
}
