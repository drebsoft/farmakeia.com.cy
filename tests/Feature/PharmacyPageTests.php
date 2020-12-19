<?php

namespace Tests\Feature;

use App\Models\Pharmacy;
use Tests\TestCase;

class PharmacyPageTests extends TestCase
{
    /**
     * @test
     */
    public function a_pharmacy_is_rendered_properly()
    {
        /** @var Pharmacy $pharmacy */
        $pharmacy = Pharmacy::factory()->create();

        $this->get(route('farmakeio', ['am' => $pharmacy->name]))
            ->assertStatus(200)
            ->assertSeeText($pharmacy->name);
    }
}
