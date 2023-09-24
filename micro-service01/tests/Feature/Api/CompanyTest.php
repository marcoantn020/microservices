<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    protected string $endpoint = "/companies";

    public function test_get_all_companies()
    {
        Company::factory(10)
            ->create(['category_id' => Category::factory()->create()]);
        $response = $this->getJson($this->endpoint);
        $response->assertOk()
            ->assertJsonStructure([
                'data'
            ])
            ->assertJsonCount(10,'data');
    }

    public function test_get_one_company_not_found()
    {
        $response = $this->getJson("{$this->endpoint}/fake_uuid");
        $response->assertNotFound()
            ->assertExactJson(['message' => 'Not found']);
    }

    public function test_get_one_company()
    {
        $company = Company::factory()
            ->create(['category_id' => Category::factory()->create()]);
        $response = $this->getJson("{$this->endpoint}/{$company['uuid']}");
        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    "category" => [
                        "id",
                        "title",
                        "slug",
                        "description",
                        "created_at",
                    ],
                    "identify",
                    "name",
                    "slug",
                    "phone",
                    "whatsapp",
                    "email",
                    "facebook",
                    "instagram",
                    "youtube",
                    "created_at",

                ]
            ]);
    }

    public function test_missing_params_in_create_company()
    {
        $response = $this->postJson($this->endpoint, []);
        $response->assertUnprocessable()
            ->assertJsonMissing(data: ['email', 'category_id', 'name', 'whatsapp'], exact: true)
            ->assertJsonStructure([
                "message",
                "errors" => []
            ]);
    }

    public function test_create_company()
    {
        $category = Category::factory()->create();
        $payload = [
            'email' => 'email@gmail.com',
            'category_id' => $category['id'],
            'name' => 'name teste',
            'whatsapp' => '1499996633'
        ];
        $image = UploadedFile::fake()->image('image.png');
        $response = $this->call(
            'POST',
            $this->endpoint,
            $payload,
            [],
            ['image' => $image]
        );
        $response->assertCreated()
            ->assertJsonFragment(['email' => 'email@gmail.com'])
            ->assertJsonStructure([
                'data' => [
                    "category" => [
                        "id",
                        "title",
                        "slug",
                        "description",
                        "created_at",
                    ],
                    "identify",
                    "name",
                    "image",
                    "slug",
                    "phone",
                    "whatsapp",
                    "email",
                    "facebook",
                    "instagram",
                    "youtube",
                    "created_at",

                ]
            ]);
    }

    public function test_error_update_company_not_found()
    {
        $payload = [
            'title' => 'Test company',
            'description' => 'only description to test'
        ];
        $response = $this->putJson("{$this->endpoint}/fake_slug", $payload);
        $response->assertNotFound()
            ->assertExactJson(['message' => 'Not found']);
    }

    public function test_update_company()
    {
        $company = Company::factory()
            ->create(['category_id' => Category::factory()->create()]);

        $payload = [
            'email' => 'updated@gmail.com'
        ];

        $response = $this->putJson("{$this->endpoint}/{$company->url}", $payload);
        $response->assertOk()
            ->assertExactJson(["message" => "success"]);
    }

    public function test_error_delete_company_not_found()
    {
        $response = $this->deleteJson("{$this->endpoint}/fake_slug");
        $response->assertNotFound()
            ->assertExactJson(['message' => 'Not found']);
    }

    public function test_delete_company()
    {
        $company = Company::factory()
            ->create(['category_id' => Category::factory()->create()]);
        $response = $this->deleteJson("{$this->endpoint}/{$company->uuid}");
        $response->assertNoContent();
    }
}
