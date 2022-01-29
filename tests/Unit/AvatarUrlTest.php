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

        $this->assertSame("https://ui-avatars.com/api/?name={$result}&color=7F9CF5&background=EBF4FF", $pharmacy->avatar_url);
    }

    public function provider()
    {
        return [
            ['Test Test', 'TT'],
            ['Test A', 'TA'],
            ['Test - Test', 'TT'],
            ['Test A', 'TA'],
            ['Foo Bar (Test)', 'FT'],
            ['A', 'A'],
            ['Ανδρέας Ανδρέου', 'ΑΑ'],
            ['Ανδρέας (Ανδρέου)', 'ΑΑ'],
            ['Ανδρέας - (Ανδρέου) Χρίστου', 'ΑΧ'],
            ['Γιάννης (Κάτι) Χρίστου', 'ΓΧ'],
            ['Άννα Κολιού', 'ΆΚ'],
            ['Ελένη (Ελίνα) Τσιελεπή', 'ΕΤ'],
            ['Μαρία Ευθυμίου - Κούλα', 'ΜΚ'],
            ['Βέρα Χριστοφόρου-Παπαπροδρόμου', 'ΒΧ'],
        ];
    }
}
