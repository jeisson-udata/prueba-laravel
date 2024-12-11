<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /**
         * Create the resource_type table.
         *
         * This table stores different types of resources.
         *
         * Columns:
         * - id: Primary key.
         * - name: Name of the resource type.
         * - active: Indicates if the resource type is active.
         * - created_at: Timestamp when the resource type was created.
         * - updated_at: Timestamp when the resource type was last updated.
         *
         * Indexes:
         * - active: Index for the active column.
         */
        Schema::create('resource_type',function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->timestamps();

            //indexes
            $table->index('active');
        });

        /**
         * Create the resource table.
         * This table stores the resources.
         * Columns:
         * - id: Primary key.
         * - resource_type_id: Foreign key to the resource_type table.
         * - code: Code of the resource.
         * - name: Name of the resource.
         * - detail: Detailed description of the resource.
         * - is_available: Indicates if the resource is available.
         * - availability_schedule: Availability schedule of the resource.
         * - recommendations: Recommendations for the resource.
         * - active: Indicates if the resource is active.
         * - created_at: Timestamp when the resource was created.
         * - updated_at: Timestamp when the resource was last updated.
         * Indexes:
         * - active: Index for the active column.
         * - is_available: Index for the is_available column.
         */
        Schema::create('resource',function (Blueprint $table){
            $table->id();
            $table->foreignId('resource_type_id')->constrained('resource_type');
            $table->string('code');
            $table->string('name');
            $table->string('detail')->nullable();
            $table->boolean('is_available')->default(true);
            $table->json('availability_schedule');//model: {"monday":{"start":"08:00","end":"17:00"}}
            $table->longText('recommendations');
            $table->boolean('active')->default(true);
            $table->timestamps();

            //indexes
            $table->index('active');
            $table->index('is_available');
        });

        /**
         * Create the resource_type_equipment table.
         * This table stores the equipment resources.
         * Columns:
         * - id: Primary key.
         * - resource_id: Foreign key to the resource table.
         * - warehouse_location: Location of the equipment in the warehouse.
         * - active: Indicates if the equipment is active.
         * - created_at: Timestamp when the equipment was created.
         * - updated_at: Timestamp when the equipment was last updated.
         * Indexes:
         * - active: Index for the active column.
         */
        Schema::create('resource_type_equipment',function (Blueprint $table){
            $table->id();
            $table->foreignId('resource_id')->unique()->constrained('resource');
            $table->string('warehouse_location');
            $table->boolean('active')->default(true);
            $table->timestamps();

            //indexes
            $table->index('active');
        });

        /**
         * Create the resource_type_space table.
         * This table stores the space resources.
         * Columns:
         * - id: Primary key.
         * - resource_id: Foreign key to the resource table.
         * - capacity_of_people: Capacity of people in the space.
         * - location_type: Type of location (VIRTUAL, PHYSICAL).
         * - location_link: Link to the location.
         * - location_information: Information about the location.
         * - active: Indicates if the space is active.
         * - created_at: Timestamp when the space was created.
         * - updated_at: Timestamp when the space was last updated.
         * Indexes:
         * - active: Index for the active column.
         * - location_type: Index for the location_type column.
         */
        Schema::create('resource_type_space',function (Blueprint $table){
            $table->id();
            $table->foreignId('resource_id')->constrained('resource');
            $table->integer('capacity_of_people')->default(1);
            $table->string('location_type'); // types: VIRTUAL, PHYSICAL
            $table->string('location_link')->nullable();
            $table->string('location_information')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            //indexes
            $table->index('active');
            $table->index('location_type');
        });

        /**
         * Create the reservation table.
         * This table stores the reservations.
         * Columns:
         * - id: Primary key.
         * - resource_id: Foreign key to the resource table.
         * - user_id: Foreign key to the users table.
         * - start_at: Start date and time of the reservation.
         * - end_at: End date and time of the reservation.
         * - observations: Observations of the reservation.
         * - all_correct: Indicates if all the information is correct.
         * - user_checker_id: Foreign key to the users table.
         * - status: Status of the reservation (PENDING, APPROVED, REJECTED, CANCELLED, FINISHED, EXPIRED).
         * - active: Indicates if the reservation is active.
         * - created_at: Timestamp when the reservation was created.
         * - updated_at: Timestamp when the reservation was last updated.
         * Indexes:
         * - active: Index for the active column.
         * - status: Index for the status column.
         */
        Schema::create('reservation',function (Blueprint $table){
            $table->id();
            $table->foreignId('resource_id')->constrained('resource');
            $table->foreignId('user_id')->constrained('users');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->string('observations')->nullable();
            $table->boolean('all_correct');
            $table->foreignId('user_checker_id')->nullable()->constrained('users');
            $table->string('status')->default('PENDING'); // types: PENDING, APPROVED, REJECTED, CANCELLED, FINISHED, EXPIRED
            $table->boolean('active')->default(true);
            $table->timestamps();

            //indexes
            $table->index('active');
            $table->index('status');
        });

        /**
         * Create the reservation_log table.
         * This table stores the logs of the reservations.
         * Columns:
         * - id: Primary key.
         * - reservation_id: Foreign key to the reservation table.
         * - user_checker_id: Foreign key to the users table.
         * - status: Status of the reservation (CREATED, UPDATED, DELETED, APPROVED, REJECTED, CANCELLED, FINISHED, EXPIRED).
         * - observations: Observations of the reservation.
         * - active: Indicates if the log is active.
         * - created_at: Timestamp when the log was created.
         * - updated_at: Timestamp when the log was last updated.
         * Indexes:
         * - active: Index for the active column.
         */
        Schema::create('reservation_log',function (Blueprint $table){
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservation');
            $table->foreignId('user_checker_id')->constrained('users');
            $table->string('status'); // types: CREATED, UPDATED, DELETED, APPROVED, REJECTED, CANCELLED, FINISHED, EXPIRED
            $table->string('observations')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            //indexes
            $table->index('active');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_type');
        Schema::dropIfExists('resource');
        Schema::dropIfExists('resource_type_equipment');
        Schema::dropIfExists('resource_type_space');
        Schema::dropIfExists('reservation');
        Schema::dropIfExists('reservation_log');

    }
};
