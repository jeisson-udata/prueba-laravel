<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceType extends Model
{
    protected $table = 'resource_type';

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
