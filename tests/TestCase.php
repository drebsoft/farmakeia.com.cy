<?php

namespace Tests;

use App\Models\User;
use JMac\Testing\Traits\AdditionalAssertions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, AdditionalAssertions;

    protected function asAuthenticated(): void
    {
        $user = User::factory()->create();
        $this->be($user);
    }

    protected function asAdmin(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->be($admin);
    }
}
