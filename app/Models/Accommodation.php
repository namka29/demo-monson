<?php

namespace App\Models;

use App\Enums\AccommodationType;
use App\Enums\PublicationStatus;
use App\Models\Concerns\HasPublicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use Concerns\GeneratesSlug;
    use HasFactory;
    use HasPublicationStatus;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'accommodation_type',
        'description',
        'address',
        'latitude',
        'longitude',
        'price_hint',
        'contact_phone',
        'image_url',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => PublicationStatus::class,
            'accommodation_type' => AccommodationType::class,
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    protected function slugSourceColumn(): string
    {
        return 'name';
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
