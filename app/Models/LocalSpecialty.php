<?php

namespace App\Models;

use App\Enums\PublicationStatus;
use App\Enums\SpecialtyCategory;
use App\Models\Concerns\HasPublicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalSpecialty extends Model
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
        'category',
        'description',
        'origin_hint',
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
            'category' => SpecialtyCategory::class,
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
