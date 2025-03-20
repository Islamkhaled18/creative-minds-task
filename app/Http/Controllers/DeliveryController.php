<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\NearDeliveryRequest;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function getNearbyDeliveryReps(NearDeliveryRequest $request)
    {
        $latitude  = $request->latitude;
        $longitude = $request->longitude;
        $radius    = $request->radius ?? 10; // Default 10km radius
        $limit     = $request->limit ?? 10;  // Default 10 results

        try {
            // Calculate distance using the Haversine formula
            $deliveryReps = DB::table('users')
                ->select(
                    'id',
                    'username',
                    'mobile_number',
                    'profile_image',
                    'thumbnail',
                    'latitude',
                    'longitude',
                    'location_name',
                    DB::raw('(
                        6371 * acos(
                            cos(radians(' . $latitude . ')) *
                            cos(radians(latitude)) *
                            cos(radians(longitude) - radians(' . $longitude . ')) +
                            sin(radians(' . $latitude . ')) *
                            sin(radians(latitude))
                        )
                    ) AS distance')
                )
                ->where('is_verified', 1)
                ->where('user_type', 'delivery')
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->having('distance', '<=', $radius)
                ->orderBy('distance', 'asc')
                ->limit($limit)
                ->get();

            $formattedResponse = $deliveryReps->map(function ($rep) {
                return [
                    'id'            => $rep->id,
                    'username'      => $rep->username,
                    'mobile_number' => $rep->mobile_number,
                    'profile_image' => $rep->profile_image,
                    'thumbnail'     => $rep->thumbnail,
                    'location'      => [
                        'latitude'  => (float) $rep->latitude,
                        'longitude' => (float) $rep->longitude,
                        'name'      => $rep->location_name,
                    ],
                    'distance'      => round($rep->distance, 2),
                ];
            });

            return response()->json([
                'message' => 'Nearby delivery representatives returned successfully',
                'count'   => count($formattedResponse),
                'data'    => $formattedResponse,
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve nearby delivery representatives: ' . $e->getMessage()], 500);
        }
    }
}
