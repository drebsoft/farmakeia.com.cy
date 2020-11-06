<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function asAuthenticated(): void
    {
        $user = User::factory()->create();
        $this->be($user);
    }
}
