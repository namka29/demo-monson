<?php

namespace Tests\Unit;

use App\Support\TouristMaps;
use PHPUnit\Framework\TestCase;

final class TouristMapsTest extends TestCase
{
    public function test_can_embed_accepts_decimal_strings(): void
    {
        $this->assertTrue(TouristMaps::canEmbedIframe('20.2895', '105.9100'));
        $this->assertTrue(TouristMaps::canEmbedIframe(-33.8651, 151.2094));
    }

    public function test_can_embed_rejects_null_or_empty(): void
    {
        $this->assertFalse(TouristMaps::canEmbedIframe(null, null));
        $this->assertFalse(TouristMaps::canEmbedIframe(null, '105'));
        $this->assertFalse(TouristMaps::canEmbedIframe('21', ''));
        $this->assertFalse(TouristMaps::canEmbedIframe('xy', '105'));
    }

    public function test_can_embed_rejects_out_of_range(): void
    {
        $this->assertFalse(TouristMaps::canEmbedIframe(91, 0));
        $this->assertFalse(TouristMaps::canEmbedIframe(0, 181));
    }

    public function test_google_iframe_src_is_embed_without_api_key_placeholder(): void
    {
        $src = TouristMaps::googleIframeSrc(20.25, 105.92);

        $this->assertStringContainsString('maps.google.com', $src);
        $this->assertStringContainsString('output=embed', $src);
        $this->assertStringMatchesFormat('%Aq=20.25%A105.92%A', $src);
    }
}
