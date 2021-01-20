<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RssLoadList extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function rssLoadedFeeds() {
        return $this->hasMany('App\Models\RssLoadedFeed');
    }
}
