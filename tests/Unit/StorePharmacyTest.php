<?php

namespace Tests\Unit;

use App\Http\Requests\StorePharmacy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Session\Store;
use Tests\TestCase;

class StorePharmacyTest extends TestCase
{
    use RefreshDatabase;
    private $pharmacy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pharmacy = new StorePharmacy();
    }

    /** @test */
    public function testRules()
    {
        $this->assertEquals([
            'name' => 'required|unique:pharmacies|max:25',
            'town' => 'required',
            'municipality' => 'required',
            'address' => 'required',
            'add_address' => 'nullable',
            'phone' => 'required|digits:6',
            'am' => 'required|digits:4'
        ],
            $this->pharmacy->rules()
        );
    }

    /** @test */
    public function testAuthorize()
    {
        $this->assertTrue($this->pharmacy->authorize());
    }
}
