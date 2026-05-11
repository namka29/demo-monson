<?php

namespace App\Models;

use App\Enums\PublicationStatus;
use App\Models\Concerns\HasPublicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourSuggestion extends Model
{
    use Concerns\GeneratesSlug;
    use HasFactory;
    use HasPublicationStatus;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'body',
        'duration_days',
        'highlights',
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
            'duration_days' => 'integer',
        ];
    }

    protected function slugSourceColumn(): string
    {
        return 'title';
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
