<?php

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function generateRandomString($length)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    public function getAuthToken($user, $password)
    {
        return $this->call('POST', '/api/login', [
            'email' => $user->email,
            'password' => $password
        ])->getData()->token;
    }

    public function getValidGroup()
    {
        $user = factory(\App\Models\User::class)->create();
        $group = factory(\App\Models\Group::class)->make();
        $group->user()->associate($user);
        $group->save();
        return $group;
    }

    public function getValidMember()
    {
        $member = factory(\App\Models\Member::class)->make();
        $group = factory(\App\Models\Group::class)->create();
        $member->group()->associate($group);
        $member->save();
        return $member;
    }

    public function getValidTransaction()
    {
        $group = $this->getValidGroup();
        $transaction = factory(\App\Models\Transaction::class)->make();
        $transaction->group()->associate($group);
        return $transaction;
    }
}
