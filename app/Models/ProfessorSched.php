<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessorSched extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'file_url'];

    // public function professor() 
    // {
    //     return $this->belongsTo(Professor::class);
    // }
}