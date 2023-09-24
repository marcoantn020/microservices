<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected string $endpoint = "/categories";

    public function test_get_all_categories()
    {
        Category::factory(10)
            ->create();
        $response = $this->getJson($this->endpoint);
        $response->assertOk()
            ->assertJsonStructure([
                'data'
            ])
            ->assertJsonCount(10,'data');
    }

    public function test_get_one_category_not_found()
    {
        $response = $this->getJson("{$this->endpoint}/fake_slug");
        $response->assertNotFound()
            ->assertExactJson(['message' => 'Not found']);
    }

    public function test_get_one_category()
    {
        $category = Category::factory()
            ->create();
        $response = $this->getJson("{$this->endpoint}/{$category['url']}");
        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'slug',
                    'description',
                    'created_at'
                ]
            ]);
    }

    public function test_missing_params_in_create()
    {

        $response = $this->postJson($this->endpoint, []);
        $response->assertUnprocessable()
            ->assertJsonStructure([
                "message",
                "errors" => []
            ])
            ->assertJsonMissing(data: ['title', 'description'], exact: true);
    }

    public function test_create_category()
    {
        $payload = [
            'title' => 'Test category',
            'description' => 'only description to test'
        ];
        $response = $this->postJson($this->endpoint, $payload);
        $response->assertCreated()
            ->assertJsonFragment($payload)
            ->assertJsonStructure([
                'data' => [
                    "id",
                    "title",
                    "slug",
                    "description",
                    "created_at"

                ]
            ]);
    }

    public function test_error_update_category_not_found()
    {
        $payload = [
            'title' => 'Test category',
            'description' => 'only description to test'
        ];
        $response = $this->putJson("{$this->endpoint}/fake_slug", $payload);
        $response->assertNotFound()
            ->assertExactJson(['message' => 'Not found']);
    }

    public function test_update_category()
    {
        $category = Category::factory()->create(['title' => 'teste title']);
        $payload = [
            'title' => 'teste title updated',
            'description' => 'only description to test'
        ];
        $response = $this->putJson("{$this->endpoint}/{$category->url}", $payload);
        $response->assertOk()
            ->assertExactJson(["message" => "success"]);
    }

    public function test_error_delete_category_not_found()
    {
        $response = $this->deleteJson("{$this->endpoint}/fake_slug");
        $response->assertNotFound()
            ->assertExactJson(['message' => 'Not found']);
    }

    public function test_delete_category()
    {
        $category = Category::factory()->create();
        $response = $this->deleteJson("{$this->endpoint}/{$category->url}");
        $response->assertNoContent();
    }
}
