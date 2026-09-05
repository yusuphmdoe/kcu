<?php

namespace Tests\API;

use Tests\Support\ApiTestCase;

/**
 * Security-focused checks for password-bearing resources.
 *
 * @internal
 */
final class ApiUsersAndSuppliersSecurityTest extends ApiTestCase
{
    public function testUserPasswordIsHashedAndHidden(): void
    {
        $payload = [
            'first_name' => 'Sec',
            'last_name'  => 'User',
            'email'      => 'secure.user@test.com',
            'password'   => 'PlainTextPass1!',
            'role'       => 'user',
            'status'     => 'active',
        ];

        $create = $this->withBodyFormat('json')->post('api/users', $payload);
        $create->assertStatus(201);
        $json = $this->decodeJson($create->getJSON());

        $this->assertArrayNotHasKey('password', $json['data']);

        $row = $this->db->table('users')->where('id', $json['data']['id'])->get()->getRowArray();
        $this->assertNotSame('PlainTextPass1!', $row['password']);
        $this->assertTrue(password_verify('PlainTextPass1!', $row['password']));
    }

    public function testSupplierPasswordIsHashedAndHidden(): void
    {
        $payload = [
            'name'     => 'Secure Supplier',
            'phone'    => '0700111222',
            'password' => 'SupplierPass1!',
            'email'    => 'secure.supplier@test.com',
            'address'  => 'Dar',
            'location' => 'TZ',
        ];

        $create = $this->withBodyFormat('json')->post('api/suppliers', $payload);
        $create->assertStatus(201);
        $json = $this->decodeJson($create->getJSON());

        $this->assertArrayNotHasKey('password', $json['data']);

        $row = $this->db->table('suppliers')->where('id', $json['data']['id'])->get()->getRowArray();
        $this->assertNotSame('SupplierPass1!', $row['password']);
        $this->assertTrue(password_verify('SupplierPass1!', $row['password']));
    }

    public function testUpdateUserWithoutPasswordDoesNotClearHash(): void
    {
        $create = $this->withBodyFormat('json')->post('api/users', [
            'first_name' => 'Keep',
            'last_name'  => 'Hash',
            'email'      => 'keep.hash@test.com',
            'password'   => 'KeepHashPass1!',
            'role'       => 'staff',
            'status'     => 'active',
        ]);
        $create->assertStatus(201);
        $id = (int) $this->decodeJson($create->getJSON())['data']['id'];

        $before = $this->db->table('users')->where('id', $id)->get()->getRowArray()['password'];

        $update = $this->withBodyFormat('json')->put('api/users/' . $id, [
            'first_name' => 'Kept',
        ]);
        $update->assertStatus(200);

        $after = $this->db->table('users')->where('id', $id)->get()->getRowArray()['password'];
        $this->assertSame($before, $after);
    }
}
