<?php

namespace App\Filters;

use App\Libraries\AuthContext;
use App\Libraries\JwtService;
use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use RuntimeException;

class JwtFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        AuthContext::reset();

        $jwt   = new JwtService();
        $token = $jwt->extractBearer($request->getHeaderLine('Authorization'));

        if ($token === null) {
            return $this->unauthorized('Missing Bearer token.');
        }

        try {
            $claims = $jwt->decode($token);
        } catch (RuntimeException $e) {
            return $this->unauthorized($e->getMessage());
        }

        $userId = (int) ($claims['sub'] ?? 0);
        if ($userId < 1) {
            return $this->unauthorized('Invalid token subject.');
        }

        $user = model(UserModel::class)->find($userId);
        if ($user === null || ($user['status'] ?? '') !== 'active') {
            return $this->unauthorized('User is inactive or not found.');
        }

        unset($user['password']);
        AuthContext::setUser($user);
        AuthContext::setClaims($claims);

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }

    private function unauthorized(string $message): ResponseInterface
    {
        return Services::response()
            ->setStatusCode(401)
            ->setJSON([
                'status'  => false,
                'message' => $message,
                'data'    => null,
            ]);
    }
}
