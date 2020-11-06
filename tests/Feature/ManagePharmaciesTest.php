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

    /** @test */
    public function a_user_can_create_a_pharmacy()
    {

        $this->asAuthenticated();

        $this->get('/pharmacies/create')->assertStatus(200);

        $attributes = [
            'name' => 'Test pharmacy',
            'town' => 'Test town',
            'municipality' => 'Test mun',
            'address' => 'Test address',
            'add_address' => 'Test additional',
            'phone' => '123456',
            'am' => '1234'
        ];

        $this->followingRedirects()
            ->post('/pharmacies', $attributes)
            ->assertSee($attributes);

        $this->assertDatabaseHas('pharmacies', $attributes);
    }

    /** @test */
    public function a_user_can_update_a_pharmacy()
    {
        $this->withoutExceptionHandling();

        $this->asAuthenticated();

        $pharmacy = Pharmacy::factory()->create();

        $this->get('/pharmacies/'.$pharmacy->id.'/edit')->assertOk();

        $attributes = [
            'name' => 'Edited',
            'town' => 'Edited',
            'municipality' => 'Edited',
            'address' => 'Edited',
            'add_address' => 'Edited',
            'phone' => '111111',
            'am' => '1111'
        ];

        $this->followingRedirects()
            ->patch('/pharmacies/'.$pharmacy->id, $attributes)
            ->assertSee($attributes);

        $this->assertDatabaseHas('pharmacies', $attributes);
    }
}
