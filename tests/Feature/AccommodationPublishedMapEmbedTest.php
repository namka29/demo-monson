<?php

namespace Tests\Feature;

use App\Enums\AccommodationType;
use App\Enums\PublicationStatus;
use App\Models\Accommodation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class AccommodationPublishedMapEmbedTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_page_contains_embed_when_coordinates_are_valid(): void
    {
        Accommodation::query()->create([
            'name' => 'Map Test Inn',
            'slug' => 'map-test-inn',
            'accommodation_type' => AccommodationType::Hotel,
            'status' => PublicationStatus::Published->value,
            'latitude' => '20.2500000',
            'longitude' => '105.9200000',
        ]);

        $response = $this->get(route('accommodations.show', 'map-test-inn'));

        $response->assertOk();
        $response->assertSee('output=embed', false);
        $response->assertSee('LodgingBusiness', false);
    }

    public function test_published_page_skips_iframe_when_coordinates_are_out_of_range(): void
    {
        Accommodation::query()->create([
            'name' => 'Bad Coords Inn',
            'slug' => 'bad-coords-inn',
            'accommodation_type' => AccommodationType::Hotel,
            'status' => PublicationStatus::Published->value,
            'latitude' => '91',
            'longitude' => '105',
        ]);

        $response = $this->get(route('accommodations.show', 'bad-coords-inn'));

        $response->assertOk();
        $response->assertDontSee('output=embed', false);
        $response->assertSee('Bad Coords Inn');
    }
}
