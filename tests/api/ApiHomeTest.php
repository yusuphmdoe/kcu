<?php

namespace Tests\API;

use Tests\Support\ApiResourceCatalog;
use Tests\Support\ApiTestCase;

/**
 * @internal
 */
final class ApiHomeTest extends ApiTestCase
{
    public function testApiIndexListsAllResources(): void
    {
        $result = $this->get('api');

        $result->assertStatus(200);
        $result->assertJSONFragment(['status' => true]);

        $json = $this->decodeJson($result->getJSON());
        $this->assertSame('KCU API', $json['data']['name']);
        $this->assertArrayHasKey('auth', $json['data']);
        $this->assertArrayHasKey('endpoints', $json['data']);
        $this->assertCount(count(ApiResourceCatalog::names()), $json['data']['endpoints']);
    }

    public function testApiIndexEndpointsIncludeMethods(): void
    {
        $result = $this->get('api');
        $json   = $this->decodeJson($result->getJSON());

        $first = $json['data']['endpoints'][0];
        $this->assertArrayHasKey('resource', $first);
        $this->assertArrayHasKey('list', $first);
        $this->assertArrayHasKey('detail', $first);
        $this->assertSame(['GET', 'POST', 'PUT', 'PATCH', 'DELETE'], $first['methods']);
    }
}
