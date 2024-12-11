<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    /**
     * Override the delete method to add custom logic.
     */
    public function delete(): true
    {
        // Update the active column to false
        $this->active = false;
        $this->save();

        // Optionally, you can add custom logic here, such as logging the deletion

        // Return true to indicate the "deletion" was successful
        return true;
    }
}
