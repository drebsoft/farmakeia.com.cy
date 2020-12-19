<?php

namespace Tests\Feature;

use App\Models\Pharmacy;
use Tests\TestCase;

class RegionTests extends TestCase
{
    /**
     * @test
     */
    public function a_region_is_rendered_properly()
    {
        Pharmacy::factory()->count(10)->create();

        $this->get(route('farmakeia', ['region' => 'lefkosia']))
            ->assertStatus(200)
            ->assertSeeText('Φαρμακεία στη Λευκωσία');
    }
}
