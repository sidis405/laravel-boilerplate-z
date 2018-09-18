<?php

namespace Tests;

use Blog\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        return $this;
    }

    public function signIn(User $user = null)
    {
        $user = $user ?? factory(User::class)->create();

        $this->be($user);

        return $this;
    }
}
