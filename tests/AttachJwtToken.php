<?php

namespace Tests;

use Blog\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

trait AttachJwtToken
{
    /**
     * @var User
     */
    protected $loginUser;

    /**
     * @param User $user
     *
     * @return $this
     */
    public function signInApi(User $user = null)
    {
        $user = $user ? $user : factory(\Blog\Models\User::class)->create();

        $this->loginUser = $user;

        return $this;
    }

    public function apiSignIn(User $user = null)
    {
        return $this->signInApi($user);
    }

    /**
     * @return string
     */
    protected function getJwtToken()
    {
        $user = $this->loginUser ?: factory(\Blog\Models\User::class)->create();

        return JWTAuth::fromUser($user);
    }

    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        if ($this->requestNeedsToken($method, $uri)) {
            $server = $this->attachToken($server);
        }

        return parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);
    }

    /**
     * @param string $method
     * @param string $uri
     *
     * @return bool
     */
    protected function requestNeedsToken($method, $uri)
    {
        return ! ('/auth/login' === $uri && 'POST' === $method);
    }

    /**
     * @param array $server
     *
     * @return string
     */
    protected function attachToken(array $server)
    {
        return array_merge($server, $this->transformHeadersToServerVars([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ]));
    }
}
