<?php

namespace App\Libraries;

use Config\Jwt as JwtConfig;
use DomainException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use InvalidArgumentException;
use RuntimeException;
use UnexpectedValueException;

class JwtService
{
    public function __construct(private readonly JwtConfig $config = new JwtConfig())
    {
        if ($this->config->secret === '') {
            throw new RuntimeException('JWT secret is not configured.');
        }
    }

    /**
     * @param array<string, mixed> $user
     *
     * @return array{access_token: string, token_type: string, expires_in: int}
     */
    public function issueToken(array $user): array
    {
        $now = time();
        $exp = $now + $this->config->ttl;

        $payload = [
            'iss'   => $this->config->issuer,
            'aud'   => $this->config->audience,
            'iat'   => $now,
            'nbf'   => $now,
            'exp'   => $exp,
            'sub'   => (string) $user['id'],
            'email' => $user['email'] ?? null,
            'role'  => $user['role'] ?? null,
        ];

        $token = JWT::encode($payload, $this->config->secret, $this->config->algorithm);

        return [
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => $this->config->ttl,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function decode(string $token): array
    {
        try {
            $decoded = JWT::decode(
                $token,
                new Key($this->config->secret, $this->config->algorithm),
            );
        } catch (InvalidArgumentException|DomainException|UnexpectedValueException $e) {
            throw new RuntimeException('Invalid or expired token.', 0, $e);
        }

        return (array) $decoded;
    }

    public function extractBearer(?string $header): ?string
    {
        if ($header === null || $header === '') {
            return null;
        }

        if (preg_match('/^\s*Bearer\s+(\S+)\s*$/i', $header, $matches) !== 1) {
            return null;
        }

        return $matches[1];
    }
}
