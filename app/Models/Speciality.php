<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
* This is the model class for table "specialities".
*/

class Speciality extends Model
{ 
    protected $table = 'specialities';

    protected $fillable = [
    "id",
    "name",
    "description",
    "created_at",
    "updated_at"
];
    

}
