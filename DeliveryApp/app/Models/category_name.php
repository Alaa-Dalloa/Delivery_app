<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class category_name extends Pivot
{
    use HasFactory;
 
    protected $table = 'owner_category';

    // Additional fields or methods specific to the pivot table
}

