<?php

namespace Tests\API;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\ApiResourceCatalog;
use Tests\Support\ApiTestCase;

/**
 * CRUD coverage for every API resource.
 *
 * @internal
 */
final class ApiResourceCrudTest extends ApiTestCase
{
    /**
     * @return iterable<string, array{0: string}>
     */
    public static function resourceProvider(): iterable
    {
        foreach (ApiResourceCatalog::names() as $resource) {
            yield $resource => [$resource];
        }
    }

    #[DataProvider('resourceProvider')]
    public function testListReturnsSuccessEnvelope(string $resource): void
    {
        $result = $this->get('api/' . $resource);

        $result->assertStatus(200);
        $json = $this->decodeJson($result->getJSON());

        $this->assertTrue($json['status']);
        $this->assertArrayHasKey('message', $json);
        $this->assertIsArray($json['data']);
    }

    #[DataProvider('resourceProvider')]
    public function testShowMissingReturnsNotFound(string $resource): void
    {
        $result = $this->get('api/' . $resource . '/999999');

        $result->assertStatus(404);
        $json = $this->decodeJson($result->getJSON());

        $this->assertFalse($json['status']);
        $this->assertNull($json['data']);
    }

    #[DataProvider('resourceProvider')]
    public function testCreateWithoutBodyFailsValidation(string $resource): void
    {
        $result = $this->withBodyFormat('json')->post('api/' . $resource, []);

        $result->assertStatus(422);
        $json = $this->decodeJson($result->getJSON());

        $this->assertFalse($json['status']);
        $this->assertSame('Validation failed', $json['message']);
    }

    #[DataProvider('resourceProvider')]
    public function testDeleteMissingReturnsNotFound(string $resource): void
    {
        $result = $this->delete('api/' . $resource . '/999999');

        $result->assertStatus(404);
        $json = $this->decodeJson($result->getJSON());

        $this->assertFalse($json['status']);
    }

    #[DataProvider('resourceProvider')]
    public function testFullCrudLifecycle(string $resource): void
    {
        $meta = ApiResourceCatalog::all()[$resource];

        foreach ($meta['depends'] as $dep) {
            $this->ensureResource($dep);
        }

        $createPayload = $this->resolvePlaceholders($meta['create']);

        // CREATE
        $create = $this->withBodyFormat('json')->post('api/' . $resource, $createPayload);
        $create->assertStatus(201);
        $created = $this->decodeJson($create->getJSON());

        $this->assertTrue($created['status']);
        $this->assertIsArray($created['data']);
        $this->assertArrayHasKey('id', $created['data']);

        $id = (int) $created['data']['id'];
        $this->createdIds[$resource] = $id;

        foreach ($meta['assert_hidden'] ?? [] as $hidden) {
            $this->assertArrayNotHasKey($hidden, $created['data'], "Hidden field [{$hidden}] leaked on create");
        }

        // SHOW
        $show = $this->get('api/' . $resource . '/' . $id);
        $show->assertStatus(200);
        $shown = $this->decodeJson($show->getJSON());
        $this->assertSame($id, (int) $shown['data']['id']);

        foreach ($meta['assert_hidden'] ?? [] as $hidden) {
            $this->assertArrayNotHasKey($hidden, $shown['data'], "Hidden field [{$hidden}] leaked on show");
        }

        // LIST includes record
        $list = $this->get('api/' . $resource);
        $list->assertStatus(200);
        $listed = $this->decodeJson($list->getJSON());
        $ids    = array_map(static fn (array $row): int => (int) $row['id'], $listed['data']);
        $this->assertContains($id, $ids);

        // UPDATE
        $updatePayload = $meta['update'] ?? [];
        if ($updatePayload !== []) {
            $updatePayload = $this->resolvePlaceholders($updatePayload);
            $update        = $this->withBodyFormat('json')->put('api/' . $resource . '/' . $id, $updatePayload);
            $update->assertStatus(200);
            $updated = $this->decodeJson($update->getJSON());
            $this->assertTrue($updated['status']);

            foreach ($updatePayload as $field => $value) {
                if ($value === null) {
                    continue;
                }
                $this->assertEquals($value, $updated['data'][$field], "Field [{$field}] not updated on {$resource}");
            }

            // PATCH also accepted
            $patch = $this->withBodyFormat('json')->patch('api/' . $resource . '/' . $id, $updatePayload);
            $patch->assertStatus(200);
        }

        // DELETE
        $delete = $this->delete('api/' . $resource . '/' . $id);
        $delete->assertStatus(200);
        $deleted = $this->decodeJson($delete->getJSON());
        $this->assertTrue($deleted['status']);

        $gone = $this->get('api/' . $resource . '/' . $id);
        $gone->assertStatus(404);

        unset($this->createdIds[$resource]);
    }
}
