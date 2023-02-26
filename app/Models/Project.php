<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    // 'author_username', 'author_name', 'author_lastname',
    protected $fillable = ['slug','title',  'content', 'start_date', 'end_date', 'image', 'user_id'];
    protected $dates = ['start_date','end_date'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
}