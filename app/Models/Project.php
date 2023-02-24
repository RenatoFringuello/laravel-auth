<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author_name', 'author_lastname', 'content', 'start_date', 'end_date', 'slug'];
    protected $dates = ['start_date','end_date'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}