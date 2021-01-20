<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RssSuggestion extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function rss_loaded_feed()
    {
        return $this->belongsToMany('App\Models\RssLoadedFeed');
    }
}
