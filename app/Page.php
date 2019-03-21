<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    // список полів, які дозволені для автоматичного заповнення
    protected $fillable = ['name', 'text', 'alias', 'images'];
}
