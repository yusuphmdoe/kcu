<?php

namespace App\Controllers\Api;

use App\Libraries\AuthContext;
use App\Libraries\JwtService;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseApiController
{
    public function login(): ResponseInterface
    {
        $payload = $this->requestPayload();
        $email   = trim((string) ($payload['email'] ?? ''));
        $password = (string) ($payload['password'] ?? '');

        if ($email === '' || $password === '') {
            return $this->failValidation([
                'email'    => 'Email is required',
                'password' => 'Password is required',
            ]);
        }

        /** @var UserModel $users */
        $users = model(UserModel::class);
        $user  = $users->where('email', $email)->first();

        if ($user === null || ! password_verify($password, (string) $user['password'])) {
            return $this->respond([
                'status'  => false,
                'message' => 'Invalid email or password',
                'data'    => null,
            ], 401);
        }

        if (($user['status'] ?? '') !== 'active') {
            return $this->respond([
                'status'  => false,
                'message' => 'Account is not active',
                'data'    => null,
            ], 403);
        }

        $token = (new JwtService())->issueToken($user);
        unset($user['password']);

        return $this->ok([
            'user'  => $user,
            'token' => $token,
        ], 'Login successful');
    }

    public function me(): ResponseInterface
    {
        $user = AuthContext::user();

        if ($user === null) {
            return $this->respond([
                'status'  => false,
                'message' => 'Unauthenticated',
                'data'    => null,
            ], 401);
        }

        return $this->ok($user, 'Current user');
    }
}
