<?php

namespace Tests\Support;

use App\Libraries\AuthContext;
use App\Libraries\JwtService;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * Base feature test for /api endpoints.
 *
 * @internal
 */
abstract class ApiTestCase extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $namespace = 'Tests\Support';
    protected $migrate   = true;
    protected $refresh   = true;
    protected $seed      = '';

    /** @var array<string, int> */
    protected array $createdIds = [];

    protected string $authToken = '';

    protected array $authUser = [];

    protected function setUp(): void
    {
        parent::setUp();
        AuthContext::reset();
        $this->createdIds = [];
        $this->authToken  = '';
        $this->authUser   = [];

        $this->withHeaders([
            'Accept' => 'application/json',
        ]);

        if ($this->needsAuth()) {
            $this->authenticateAsApiUser();
        }
    }

    protected function tearDown(): void
    {
        AuthContext::reset();
        parent::tearDown();
    }

    /**
     * Override in tests that hit public endpoints only.
     */
    protected function needsAuth(): bool
    {
        return true;
    }

    protected function authenticateAsApiUser(): void
    {
        $password = 'Password123!';
        $email    = 'api.tester@kcu.test';

        $this->db->table('users')->insert([
            'first_name' => 'Api',
            'last_name'  => 'Tester',
            'email'      => $email,
            'password'   => password_hash($password, PASSWORD_DEFAULT),
            'role'       => 'admin',
            'status'     => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $userId = (int) $this->db->insertID();
        $this->authUser = [
            'id'    => $userId,
            'email' => $email,
            'role'  => 'admin',
        ];

        $issued = (new JwtService())->issueToken($this->authUser);
        $this->authToken = $issued['access_token'];

        $this->withHeaders([
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $this->authToken,
        ]);
    }

    /**
     * @param array<string, mixed> $payload
     *
     * @return array<string, mixed>
     */
    protected function resolvePlaceholders(array $payload): array
    {
        foreach ($payload as $key => $value) {
            if (! is_string($value)) {
                continue;
            }

            if (preg_match('/^\{\{([a-z0-9\-]+)\}\}$/', $value, $m) !== 1) {
                continue;
            }

            $resource = $m[1];
            $payload[$key] = $this->ensureResource($resource);
        }

        return $payload;
    }

    /**
     * Ensure a resource exists and return its id.
     */
    protected function ensureResource(string $resource): int
    {
        if (isset($this->createdIds[$resource])) {
            return $this->createdIds[$resource];
        }

        $catalog = ApiResourceCatalog::all();
        $this->assertArrayHasKey($resource, $catalog, "Unknown dependency resource [{$resource}]");

        foreach ($catalog[$resource]['depends'] as $dep) {
            $this->ensureResource($dep);
        }

        $payload = $this->resolvePlaceholders($catalog[$resource]['create']);
        $result  = $this->withBodyFormat('json')->post('api/' . $resource, $payload);

        $result->assertStatus(201);
        $json = json_decode($result->getJSON(), true);

        $this->assertTrue($json['status'] ?? false, "Failed creating dependency [{$resource}]: " . $result->getJSON());
        $this->assertArrayHasKey('id', $json['data'] ?? []);

        $this->createdIds[$resource] = (int) $json['data']['id'];

        return $this->createdIds[$resource];
    }

    /**
     * @return array<string, mixed>
     */
    protected function decodeJson(string $raw): array
    {
        $decoded = json_decode($raw, true);
        $this->assertIsArray($decoded, 'Response was not valid JSON: ' . $raw);

        return $decoded;
    }
}
