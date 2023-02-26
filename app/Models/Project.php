<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'content',
        'start_date',
        'end_date',
        // url,
        // github_uri, //must be {{user->github_nickname/(project->slug || project->github_title)}}
        'image',
        'user_id'
    ];
    protected $dates = [
        'start_date',
        'end_date'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * get the user data related to the project
     *
     * @return BelongsTo
     */
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
}