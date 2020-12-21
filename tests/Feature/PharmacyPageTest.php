<?php

namespace Tests\Feature;

use App\Models\Pharmacy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PharmacyPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_pharmacy_is_rendered_properly()
    {
        /** @var Pharmacy $pharmacy */
        $pharmacy = Pharmacy::factory()->create();

        $this->get(route('farmakeio', ['am' => $pharmacy->am, 'name' => $pharmacy->slug]))
            ->assertStatus(200)
            ->assertSeeText($pharmacy->name);
    }
}
