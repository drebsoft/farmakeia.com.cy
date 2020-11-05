<?php

namespace Tests\Feature;

use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManagePharmaciesTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function anyone_can_view_a_list_of_pharmacies()
    {
        $this->withoutExceptionHandling();

        $pharmacy = Pharmacy::factory()->create([
            'name' => 'Test pharmacy',
            'town' => 'Test town',
            'municipality' => 'Test mun',
            'address' => 'Test address',
            'add_address' => 'Test additional',
            'phone' => '1231231',
            'am' => '1234'
        ]);

        $this->get('/pharmacies')
            ->assertStatus(200)
            ->assertSee([
                $pharmacy->name,
                $pharmacy->town,
                $pharmacy->municipality,
                $pharmacy->address,
                $pharmacy->add_address,
                $pharmacy->phone,
                $pharmacy->am
            ]);
    }
}
