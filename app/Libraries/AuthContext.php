<?php

namespace App\Libraries;

/**
 * Request-scoped auth state set by JwtFilter.
 */
final class AuthContext
{
    private static ?array $user = null;

    /** @var array<string, mixed>|null */
    private static ?array $claims = null;

    public static function setUser(?array $user): void
    {
        self::$user = $user;
    }

    public static function user(): ?array
    {
        return self::$user;
    }

    /**
     * @param array<string, mixed>|null $claims
     */
    public static function setClaims(?array $claims): void
    {
        self::$claims = $claims;
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function claims(): ?array
    {
        return self::$claims;
    }

    public static function reset(): void
    {
        self::$user   = null;
        self::$claims = null;
    }
}
