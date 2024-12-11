<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\ResourceType;

class ResourceTypeControllerTest extends TestCase
{
    use RefreshDatabase,WithoutMiddleware;

    /** @test */
    public function it_can_list_all_resource_types()
    {
        // Arrange: Create some resource types
        ResourceType::factory()->count(3)->create();

        // Act: Make a GET request to the index route
        $response = $this->getJson('/api/resource-type');

        // Assert: Verify the response is successful and contains the expected data
        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    /** @test */
    public function it_can_create_a_resource_type()
    {
        // Arrange: Prepare the data
        $data = ['name' => 'TEST'];

        // Act: Make a POST request to the store route
        $response = $this->postJson('/api/resource-type', $data);

        // Assert: Verify the resource type was created
        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'TEST']);
        $this->assertDatabaseHas('resource_types', ['name' => 'TEST']);
    }

    /** @test */
    public function it_can_show_a_resource_type()
    {
        // Arrange: Create a resource type
        $resourceType = ResourceType::factory()->create();

        // Act: Make a GET request to the show route
        $response = $this->getJson("/api/resource-type/{$resourceType->id}");

        // Assert: Verify the response is successful and contains the expected data
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $resourceType->name]);
    }
}
