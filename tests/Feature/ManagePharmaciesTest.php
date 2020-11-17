<?php

namespace Tests\Feature;

use App\Http\Controllers\PharmacyController;
use App\Http\Requests\CreateUpdatePharmacyRequest;
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
        $pharmacies = Pharmacy::factory(5)->create();

        // needs refactoring
        $this->get('/pharmacies')
            ->assertStatus(200)
            ->assertSee($pharmacies[0]->name)
            ->assertSee($pharmacies[1]->name)
            ->assertSee($pharmacies[2]->name)
            ->assertSee($pharmacies[3]->name)
            ->assertSee($pharmacies[4]->name);
    }

    /** @test */
    public function a_user_can_create_a_pharmacy()
    {
        $this->withoutExceptionHandling();
        $this->asAuthenticated();

        $this->get('/pharmacies/create')->assertStatus(200);

        $attributes = [
            'name' => 'Test pharmacy',
            'town' => 'Test town',
            'municipality' => 'Test mun',
            'address' => 'Test address',
            'add_address' => 'Test additional',
            'phone' => '12345678',
            'am' => '1234'
        ];

        $this->followingRedirects()
            ->post('/pharmacies', $attributes)
            ->assertSee($attributes);

        $this->assertDatabaseHas('pharmacies', $attributes);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_manage_a_pharmacy()
    {
        $pharmacy = Pharmacy::factory()->create();
        $this->get($pharmacy->path())->assertRedirect('/login');
        $this->get('/pharmacies/create')->assertRedirect('/login');
        $this->post('/pharmacies')->assertRedirect('/login');
        $this->get($pharmacy->path().'/edit')->assertRedirect('/login');
        $this->patch($pharmacy->path())->assertRedirect('/login');
        $this->delete($pharmacy->path())->assertRedirect('/login');

    }

    /** @test */
    public function a_user_can_update_a_pharmacy()
    {
        $this->withoutExceptionHandling();

        $this->asAuthenticated();

        $pharmacy = Pharmacy::factory()->create();

        $this->get($pharmacy->path().'/edit')->assertOk();

        $attributes = [
            'name' => 'Edited',
            'town' => 'Edited',
            'municipality' => 'Edited',
            'address' => 'Edited',
            'add_address' => 'Edited',
            'phone' => '11111111',
            'am' => '1111'
        ];

        $this->followingRedirects()
            ->patch($pharmacy->path(), $attributes)
            ->assertSee($attributes);

        $this->assertDatabaseHas('pharmacies', $attributes);
    }

    /** @test */
    public function a_user_can_view_a_pharmacy_created()
    {
        $this->withoutExceptionHandling();

        $this->asAuthenticated();

        $pharmacy = Pharmacy::factory()->create();

        $this->get($pharmacy->path())
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

        $this->assertDatabaseHas('pharmacies', $pharmacy->getAttributes());
    }

    /** @test */
    public function a_user_can_delete_a_pharmacy()
    {
        $this->withoutExceptionHandling();

        $this->asAuthenticated();

        $pharmacy = Pharmacy::factory()->create();

        $this->delete($pharmacy->path())->assertRedirect('/pharmacies');

        $this->assertDatabaseMissing('pharmacies', $pharmacy->getAttributes());
    }

    // form request validation
    /** @test */
    public function validation_for_pharmacy_creation()
    {
        $this->assertActionUsesFormRequest(
            PharmacyController::class,
            'store',
            CreateUpdatePharmacyRequest::class
        );
    }
}
