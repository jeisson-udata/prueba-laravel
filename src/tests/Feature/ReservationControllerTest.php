<?php

namespace Tests\Feature;

use App\Models\Resource;
use App\Models\ResourceType;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

     /** @test */
    public function it_can_list_all_reservations()
    {
        // Arrange: Create some resources
        User::factory()->create();

        ResourceType::factory()->count(3)->create()->each(function ($resourceType) {
            Resource::factory()->count(3)->create(['resource_type_id' => $resourceType->id])->each(function ($resource) {
                Reservation::factory()->create(['resource_id' => $resource->id]);
            });
        });


        // Act: Make a GET request to the index route
        $response = $this->getJson('/api/reservation');

        // Assert: Verify the response is successful and contains the expected data
        $response->assertStatus(200)
            ->assertJsonCount(9);
    }

     /** @test */
    public function it_can_create_a_reservation()
    {
        $user=User::factory()->create();
        $resourceType = ResourceType::factory()->create();
        $resource = Resource::factory()->create(['resource_type_id' => $resourceType->id]);

        $data = [
            'resource_id' => $resource->id,
            'start_at' => '2024-12-01 10:00:00',
            'end_at' => '2024-12-01 12:00:00',
            'user_id' => $user->id,
        ];

        // Act: Make a POST request to the store route
        $response = $this->postJson('/api/reservation', $data);

        // Assert: Verify the reservation was created
        $response->assertStatus(201)
            ->assertJsonFragment(['resource_id' => $resource->id]);
        $this->assertDatabaseHas('reservations', ['resource_id' => $resource->id]);
    }

     /** @test */
    public function it_can_show_a_reservation()
    {
        $user=User::factory()->create();
        $resourceType = ResourceType::factory()->create();
        $resource = Resource::factory()->create(['resource_type_id' => $resourceType->id]);

        // Arrange: Create a reservation
        $reservation = Reservation::factory()->create(['resource_id' => $resource->id, 'user_id' => $user->id]);

        // Act: Make a GET request to the show route
        $response = $this->getJson("/api/reservation/{$reservation->id}");

        // Assert: Verify the response is successful and contains the expected data
        $response->assertStatus(200)
            ->assertJsonFragment(['resource_id' => $reservation->resource_id]);
    }

     /** @test */
    public function it_can_update_a_reservation()
    {
        $user=User::factory()->create();
        $resourceType = ResourceType::factory()->create();
        $resource = Resource::factory()->create(['resource_type_id' => $resourceType->id]);

        // Arrange: Create a reservation
        $reservation = Reservation::factory()->create(['resource_id' => $resource->id, 'user_id' => $user->id]);
        $data = [
            'resource_id' => $resource->id,
            'start_at' => '2024-12-01 11:00:00',
            'end_at' => '2024-12-01 13:00:00',
            'user_id' => $user->id,
        ];

        // Act: Make a PUT request to the update route
        $response = $this->putJson("/api/reservation/{$reservation->id}", $data);

        // Assert: Verify the reservation was updated
        $response->assertStatus(200)
            ->assertJsonFragment(['start_at' => '2024-12-01 11:00:00']);
        $this->assertDatabaseHas('reservations', ['id' => $reservation->id, 'start_at' => '2024-12-01 11:00:00']);
    }

     /** @test */
    public function it_can_cancelled_a_reservation()
    {
        $user=User::factory()->create();
        $resourceType = ResourceType::factory()->create();
        $resource = Resource::factory()->create(['resource_type_id' => $resourceType->id]);

        // Arrange: Create a reservation
        $reservation = Reservation::factory()->create(['resource_id' => $resource->id, 'user_id' => $user->id]);

        // Act: Make a DELETE request to the destroy route
        $response = $this->deleteJson("/api/reservation/{$reservation->id}");

        // Assert: Verify the reservation was deleted
        $response->assertStatus(204);

    }

     /** @test */
    public function it_not_can_create_a_reservation_when_is_unavailable()
    {
        $user=User::factory()->create();
        $resourceType = ResourceType::factory()->create();
        $resource = Resource::factory()->create(['resource_type_id' => $resourceType->id]);


        // send first reservation
        $data = [
            'resource_id' => $resource->id,
            'start_at' => '2024-12-01 10:00:00',
            'end_at' => '2024-12-01 12:00:00',
            'user_id' => $user->id,
        ];

        // Act: Make a POST request to the store route
        $this->postJson('/api/reservation', $data);


        // send second reservation
        $data = [
            'resource_id' => $resource->id,
            'start_at' => '2024-12-01 11:30:00',
            'end_at' => '2024-12-01 12:30:00',
            'user_id' => $user->id,
        ];

        // Act: Make a POST request to the store route
        $response=$this->postJson('/api/reservation', $data);


        // Assert: Verify the reservation was created
        $response->assertStatus(500)
            ->assertJsonFragment(['message' => 'Resource is not available in that period']);

    }

     /** @test */
    public function it_can_create_a_reservation_when_is_cancelled()
    {
        $user=User::factory()->create();
        $resourceType = ResourceType::factory()->create();
        $resource = Resource::factory()->create(['resource_type_id' => $resourceType->id]);


        // send first reservation
        $data = [
            'resource_id' => $resource->id,
            'start_at' => '2024-12-01 10:00:00',
            'end_at' => '2024-12-01 12:00:00',
            'user_id' => $user->id,
        ];

        // Act: Make a POST request to the store route
        $response= $this->postJson('/api/reservation', $data);

        // get id of reservation
        $id = $response->json('id');

        // cancel reservation
        $response=$this->deleteJson("/api/reservation/$id");

        $response->assertStatus(204);



        // send second reservation
        $data = [
            'resource_id' => $resource->id,
            'start_at' => '2024-12-01 11:30:00',
            'end_at' => '2024-12-01 12:30:00',
            'user_id' => $user->id,
        ];

        // Act: Make a POST request to the store route
        $response=$this->postJson('/api/reservation', $data);


        // Assert: Verify the reservation was created
        $response->assertStatus(201)
            ->assertJsonFragment(['resource_id' => $resource->id]);
        $this->assertDatabaseHas('reservations', ['resource_id' => $resource->id]);

    }
}
