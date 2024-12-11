<?php

namespace Tests\Feature;

use App\Models\Resource;
use App\Models\ResourceType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ResourceControllerTest extends TestCase
{

    use RefreshDatabase,WithoutMiddleware;

     /** @test */
    public function it_can_list_all_resources()
    {
        // Arrange: Create some resources types
        $resourceType= ResourceType::factory()->create();

        // Arrange: Create some resources
        Resource::factory()->count(3)->create(['resource_type_id' => $resourceType->id]);

        // Act: Make a GET request to the index route
        $response = $this->getJson('/api/resource');

        // Assert: Verify the response is successful and contains the expected data
        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

     /** @test */
    public function it_can_create_a_resource()
    {
        $resourceType = ResourceType::factory()->create();

        $data = [
            'name' => 'TEST',
            'resource_type_id' => $resourceType->id,
            'code' => 'CODE',
            'detail' => 'DETAIL',
            'availability_schedule' => [
            'monday' => [
                'start' => '08:00',
                'end' => '17:00',
            ],
            'tuesday' => [
                'start' => '08:00',
                'end' => '17:00',
            ],
            'wednesday' => [
                'start' => '08:00',
                'end' => '17:00',
            ],
            'thursday' => [
                'start' => '08:00',
                'end' => '17:00',
            ],
            'friday' => [
                'start' => '08:00',
                'end' => '17:00',
            ],
            'saturday' => [
                'start' => '09:00',
                'end' => '12:00',
            ]
        ],
        'recommendations' => 'RECOMMENDATIONS'];

        // Act: Make a POST request to the store route
        $response = $this->postJson('/api/resource', $data);

        // Assert: Verify the resource was created
        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'TEST']);
        $this->assertDatabaseHas('resources', ['name' => 'TEST']);
    }

     /** @test */
    public function it_can_show_a_resource()
    {
        // Arrange: Create some resources types
        $resourceType = ResourceType::factory()->create();

        // Arrange: Create a resource
        $resource = Resource::factory()->create(['resource_type_id' => $resourceType->id]);

        // Act: Make a GET request to the show route
        $response = $this->getJson("/api/resource/{$resource->id}");

        // Assert: Verify the response is successful and contains the expected data
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $resource->name]);
    }

     /** @test */
    public function it_can_update_a_resource()
    {
        $resourceType = ResourceType::factory()->create();

        // Arrange: Create a resource
        $resource = Resource::factory()->create(['resource_type_id' => $resourceType->id]);
        $data = [
            'name' => 'TEST',
            'resource_type_id' => $resourceType->id,
            'code' => 'CODE',
            'detail' => 'DETAIL',
            'availability_schedule' => [
                'monday' => [
                    'start' => '08:00',
                    'end' => '17:00',
                ],
                'tuesday' => [
                    'start' => '08:00',
                    'end' => '17:00',
                ],
                'wednesday' => [
                    'start' => '08:00',
                    'end' => '17:00',
                ],
                'thursday' => [
                    'start' => '08:00',
                    'end' => '17:00',
                ],
                'friday' => [
                    'start' => '08:00',
                    'end' => '17:00',
                ],
                'saturday' => [
                    'start' => '09:00',
                    'end' => '12:00',
                ]
            ],
            'recommendations' => 'RECOMMENDATIONS'];

        // Act: Make a PUT request to the update route
        $response = $this->putJson("/api/resource/{$resource->id}", $data);

        // Assert: Verify the resource was updated
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'TEST']);
        $this->assertDatabaseHas('resources', ['id' => $resource->id, 'name' => 'TEST']);
    }

     /** @test */
    public function it_can_delete_a_resource()
    {
        $resourceType = ResourceType::factory()->create();

        // Arrange: Create a resource
        $resource = Resource::factory()->create(['resource_type_id' => $resourceType->id]);

        // Act: Make a DELETE request to the destroy route
        $response = $this->deleteJson("/api/resource/{$resource->id}");

        // Assert: Verify the resource was deleted
        $response->assertStatus(204);
    }
}
