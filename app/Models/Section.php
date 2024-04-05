<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections';

    protected $guarded = ['id'];

    protected $fillable = ['name', 'file_url']; 
}
