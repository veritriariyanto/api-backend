<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class person extends Model
{

    use HasFactory;
    protected $table = 'person';
    protected $fillable = ['name', 'email'];
}
