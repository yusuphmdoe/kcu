<?php

namespace Tests\API;

use Tests\Support\ApiTestCase;

/**
 * @internal
 */
final class ApiAuthTest extends ApiTestCase
{
    protected function needsAuth(): bool
    {
        return false;
    }

    public function testLoginSuccessReturnsJwt(): void
    {
        $password = 'Password123!';
        $this->db->table('users')->insert([
            'first_name' => 'Login',
            'last_name'  => 'User',
            'email'      => 'login.user@kcu.test',
            'password'   => password_hash($password, PASSWORD_DEFAULT),
            'role'       => 'admin',
            'status'     => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $result = $this->withBodyFormat('json')->post('api/auth/login', [
            'email'    => 'login.user@kcu.test',
            'password' => $password,
        ]);

        $result->assertStatus(200);
        $json = $this->decodeJson($result->getJSON());

        $this->assertTrue($json['status']);
        $this->assertArrayHasKey('access_token', $json['data']['token']);
        $this->assertSame('Bearer', $json['data']['token']['token_type']);
        $this->assertArrayNotHasKey('password', $json['data']['user']);
    }

    public function testLoginWithBadCredentialsFails(): void
    {
        $result = $this->withBodyFormat('json')->post('api/auth/login', [
            'email'    => 'nobody@kcu.test',
            'password' => 'wrong',
        ]);

        $result->assertStatus(401);
        $json = $this->decodeJson($result->getJSON());
        $this->assertFalse($json['status']);
    }

    public function testProtectedRouteWithoutTokenIsUnauthorized(): void
    {
        $result = $this->get('api/customers');
        $result->assertStatus(401);
        $json = $this->decodeJson($result->getJSON());
        $this->assertFalse($json['status']);
        $this->assertSame('Missing Bearer token.', $json['message']);
    }

    public function testMeRequiresValidToken(): void
    {
        $password = 'Password123!';
        $this->db->table('users')->insert([
            'first_name' => 'Me',
            'last_name'  => 'User',
            'email'      => 'me.user@kcu.test',
            'password'   => password_hash($password, PASSWORD_DEFAULT),
            'role'       => 'manager',
            'status'     => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $login = $this->withBodyFormat('json')->post('api/auth/login', [
            'email'    => 'me.user@kcu.test',
            'password' => $password,
        ]);
        $login->assertStatus(200);
        $token = $this->decodeJson($login->getJSON())['data']['token']['access_token'];

        $me = $this->withHeaders([
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->get('api/auth/me');

        $me->assertStatus(200);
        $json = $this->decodeJson($me->getJSON());
        $this->assertSame('me.user@kcu.test', $json['data']['email']);
        $this->assertArrayNotHasKey('password', $json['data']);
    }
}
