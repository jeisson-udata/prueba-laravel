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
         * Create the resource_types table.
         *
         * This table stores different types of resourcess.
         *
         * Columns:
         * - id: Primary key.
         * - name: Name of the resources type.
         * - active: Indicates if the resources type is active.
         * - created_at: Timestamp when the resources type was created.
         * - updated_at: Timestamp when the resources type was last updated.
         *
         * Indexes:
         * - active: Index for the active column.
         */
        Schema::create('resource_types',function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->timestamps();

            //indexes
            $table->index('active');
        });

        /**
         * Create the resources table.
         * This table stores the resourcess.
         * Columns:
         * - id: Primary key.
         * - resource_type_id: Foreign key to the resource_types table.
         * - code: Code of the resources.
         * - name: Name of the resources.
         * - detail: Detailed description of the resources.
         * - is_available: Indicates if the resources is available.
         * - availability_schedule: Availability schedule of the resources.
         * - recommendations: Recommendations for the resources.
         * - active: Indicates if the resources is active.
         * - created_at: Timestamp when the resources was created.
         * - updated_at: Timestamp when the resources was last updated.
         * Indexes:
         * - active: Index for the active column.
         * - is_available: Index for the is_available column.
         */
        Schema::create('resources',function (Blueprint $table){
            $table->id();
            $table->foreignId('resource_type_id')->constrained('resource_types');
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
         * Create the resource_type_equipments table.
         * This table stores the equipment resourcess.
         * Columns:
         * - id: Primary key.
         * - resource_id: Foreign key to the resources table.
         * - warehouse_location: Location of the equipment in the warehouse.
         * - active: Indicates if the equipment is active.
         * - created_at: Timestamp when the equipment was created.
         * - updated_at: Timestamp when the equipment was last updated.
         * Indexes:
         * - active: Index for the active column.
         */
        Schema::create('resource_type_equipments',function (Blueprint $table){
            $table->id();
            $table->foreignId('resource_id')->unique()->constrained('resources');
            $table->string('warehouse_location');
            $table->boolean('active')->default(true);
            $table->timestamps();

            //indexes
            $table->index('active');
        });

        /**
         * Create the resource_type_spaces table.
         * This table stores the space resourcess.
         * Columns:
         * - id: Primary key.
         * - resource_id: Foreign key to the resources table.
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
        Schema::create('resource_type_spaces',function (Blueprint $table){
            $table->id();
            $table->foreignId('resource_id')->constrained('resources');
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
         * Create the reservations table.
         * This table stores the reservationss.
         * Columns:
         * - id: Primary key.
         * - resource_id: Foreign key to the resources table.
         * - user_id: Foreign key to the users table.
         * - start_at: Start date and time of the reservations.
         * - end_at: End date and time of the reservations.
         * - observations: Observations of the reservations.
         * - all_correct: Indicates if all the information is correct.
         * - user_checker_id: Foreign key to the users table.
         * - status: Status of the reservations (PENDING, APPROVED, REJECTED, CANCELLED, FINISHED, EXPIRED).
         * - active: Indicates if the reservations is active.
         * - created_at: Timestamp when the reservations was created.
         * - updated_at: Timestamp when the reservations was last updated.
         * Indexes:
         * - active: Index for the active column.
         * - status: Index for the status column.
         */
        Schema::create('reservations',function (Blueprint $table){
            $table->id();
            $table->foreignId('resource_id')->constrained('resources');
            $table->foreignId('user_id')->constrained('users');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->string('observations')->nullable();
            $table->boolean('all_correct')->default(false);
            $table->foreignId('user_checker_id')->nullable()->constrained('users');
            $table->string('status')->default('PENDING'); // types: PENDING, APPROVED, REJECTED, CANCELLED, FINISHED, EXPIRED
            $table->boolean('active')->default(true);
            $table->timestamps();

            //indexes
            $table->index('active');
            $table->index('status');
        });

        /**
         * Create the reservation_logs table.
         * This table stores the logs of the reservationss.
         * Columns:
         * - id: Primary key.
         * - reservation_id: Foreign key to the reservations table.
         * - user_checker_id: Foreign key to the users table.
         * - status: Status of the reservations (CREATED, UPDATED, DELETED, APPROVED, REJECTED, CANCELLED, FINISHED, EXPIRED).
         * - observations: Observations of the reservations.
         * - active: Indicates if the log is active.
         * - created_at: Timestamp when the log was created.
         * - updated_at: Timestamp when the log was last updated.
         * Indexes:
         * - active: Index for the active column.
         */
        Schema::create('reservation_logs',function (Blueprint $table){
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservations');
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
        Schema::dropIfExists('reservation_logs');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('resource_type_equipments');
        Schema::dropIfExists('resource_type_spaces');
        Schema::dropIfExists('resources');
        Schema::dropIfExists('resource_types');

    }
};
