<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RssLoadedFeed extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function rss_suggestion()
    {
        return $this->belongsToMany('App\Models\RssSuggestion');
    }
}
