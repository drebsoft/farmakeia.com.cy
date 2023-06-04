<?php

namespace Tests\Feature;

use App\Models\Pharmacy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_region_is_rendered_properly()
    {
        $this->markTestSkipped(
            'There is an issue with SQLite and raw queries.'
        );

        Pharmacy::factory()->count(10)->create();

        $this->get(route('farmakeia', ['region' => 'lefkosia']))
            ->assertStatus(200)
            ->assertSeeText('Φαρμακεία στη Λευκωσία');
    }
}
