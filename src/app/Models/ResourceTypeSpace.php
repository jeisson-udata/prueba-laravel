<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceTypeSpace extends Model
{
    use HasFactory;

    protected $table = 'resource_type_space';

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
