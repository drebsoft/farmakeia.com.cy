<?php

namespace Tests\Unit;

use App\Http\Requests\CreateUpdatePharmacyRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Session\Store;
use Tests\TestCase;

class CreateUpdatePharmacyTest extends TestCase
{
    use RefreshDatabase;
    private $pharmacy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pharmacy = new CreateUpdatePharmacyRequest();
    }

    /** @test */
    public function testRules()
    {
        $this->assertEquals([
            'name' => 'required|unique:pharmacies|max:25',
            'region' => 'required',
            'area' => 'nullable',
            'address' => 'required',
            'additional_address' => 'nullable',
            'phone' => 'nullable|digits:8',
            'home_phone' => 'nullable|digits:8',
            'am' => 'nullable|unique:pharmacies',
            'owner_id' => 'nullable|exists:users,id'
        ],
            $this->pharmacy->rules()
        );
    }
}
