<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'username'      => $this->username,
            'mobile_number' => $this->mobile_number,
            'is_verified'   => $this->is_verified,
            'location'      => [
                'name'      => $this->location_name,
                'latitude'  => $this->latitude,
                'longitude' => $this->longitude,
            ],
            'images'        => [
                'profile'   => $this->profile_image ? asset('storage/' . $this->profile_image) : null,
                'thumbnail' => $this->thumbnail ? asset('storage/' . $this->thumbnail) : null,
            ],
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
