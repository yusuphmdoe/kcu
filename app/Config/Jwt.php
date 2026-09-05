<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Jwt extends BaseConfig
{
    /**
     * Secret key used to sign tokens.
     * Override via JWT_SECRET in .env
     */
    public string $secret = '';

    /**
     * Token time-to-live in seconds (default 8 hours).
     */
    public int $ttl = 28800;

    /**
     * Issuer claim.
     */
    public string $issuer = 'kcu-api';

    /**
     * Audience claim.
     */
    public string $audience = 'kcu-clients';

    /**
     * Algorithm.
     */
    public string $algorithm = 'HS256';

    public function __construct()
    {
        parent::__construct();

        $secret = env('JWT_SECRET', '');
        $this->secret = is_string($secret) && $secret !== ''
            ? $secret
            : (string) env('encryption.key', 'kcu-dev-jwt-secret-change-me');

        $ttl = env('JWT_TTL', $this->ttl);
        $this->ttl = (int) $ttl;

        $issuer = env('JWT_ISSUER', $this->issuer);
        if (is_string($issuer) && $issuer !== '') {
            $this->issuer = $issuer;
        }

        $audience = env('JWT_AUDIENCE', $this->audience);
        if (is_string($audience) && $audience !== '') {
            $this->audience = $audience;
        }
    }
}
