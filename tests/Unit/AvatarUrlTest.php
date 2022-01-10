<?php

namespace Tests\Unit;

use App\Models\Pharmacy;
use PHPUnit\Framework\TestCase;

class AvatarUrlTest extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_get_avatar_is_retrieved_successfully($name, $result): void
    {
        $pharmacy = new Pharmacy;
        $pharmacy->name = $name;

        $this->assertSame($pharmacy->avatar_url, "https://ui-avatars.com/api/?name={$result}&color=7F9CF5&background=EBF4FF");
    }

    public function provider()
    {
        return [
            ['Test Test', 'TT'],
            ['Test A', 'TA'],
            ['Foo Bar (Test)', 'FB'],
            ['A', 'A'],
        ];
    }
}
