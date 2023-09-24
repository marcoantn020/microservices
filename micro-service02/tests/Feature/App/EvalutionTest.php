<?php

namespace Tests\Feature\App;

use App\Models\Evaluation;
use Tests\TestCase;

class EvalutionTest extends TestCase
{
    public function test_all_evaluations()
    {
        Evaluation::factory(10)->create(['company' => '805a7ac7-1e2c-3321-a4d7-cb7497e1c2b6']);
        $response = $this->getJson('/evaluations/805a7ac7-1e2c-3321-a4d7-cb7497e1c2b6');

        $response->assertOk()
            ->assertJsonCount(10, 'data');
    }

    public function test_all_evaluations_empty()
    {
        $response = $this->getJson('/evaluations/fake-company');

        $response->assertOk()
            ->assertJsonCount(0, 'data');
    }

    public function test_create_evaluations_unprocessable()
    {
        $response = $this->postJson('/evaluations', []);

        $response->assertUnprocessable()
            ->assertJsonStructure([
                "message",
                  "errors" => []
            ]);
    }

    public function test_create_evaluations_not_found()
    {
        $payload = [
            "company" => "805a7ac7-1e2c-3321-a4d7-cb7497e1c2b6",
            "comment" => "only the comment of test",
            "stars" => "3",
        ];
        $response = $this->postJson('/evaluations', $payload);

        $response->assertNotFound()
            ->assertJsonFragment(["message" => "company not found"]);
    }

}
