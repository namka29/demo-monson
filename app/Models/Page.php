<?php

namespace App\Models;

use App\Enums\PublicationStatus;
use App\Models\Concerns\HasPublicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
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
        'body',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => PublicationStatus::class,
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
