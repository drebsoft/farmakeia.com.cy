<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    /**
     * @test
     */
    public function the_homepage_is_rendered_properly()
    {
        $this->get(route('homepage'))
            ->assertStatus(200)
            ->assertSeeText('Όλα τα εφημερεύοντα φαρμακεια της Κυπρου');
    }
}
