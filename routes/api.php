<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts', function (Request $request) {
	//$posts = App\Models\RssLoadedFeed::query()->orderBy('pubdate','desc')->paginate(30);
	$posts = \DB::table('rss_loaded_feeds as rlf')
				->select('rlf.id as rlf_id', 'rlf.title', 'rlf.url', 'rlf.img', 'rlf.img_type', 'rll.site_name')
				->join('rss_load_lists as rll','rlf.rss_load_list_id','=','rll.id')
				->orderBy('pubdate','desc')->paginate(30);
	foreach ( $posts as $index => $post ) {
		$posts[ $index ]->tags = App\Models\RssLoadedFeed::find( $post->rlf_id )->rss_suggestion;
	}
	return response()->json(['posts' => $posts]);
});

Route::get('/posts/{id}', function ( $id ) {
	$site_ids = [];
	foreach ( App\Models\Category::find( $id )->rssLoadLists as $site ) {
		$site_ids[] = $site->id;
	}
	$posts = \DB::table('rss_loaded_feeds as rlf')
				->select('rlf.id as rlf_id', 'rlf.title', 'rlf.url', 'rlf.img', 'rlf.img_type', 'rll.site_name')
				->join('rss_load_lists as rll','rlf.rss_load_list_id','=','rll.id')
				->whereIn('rss_load_list_id', $site_ids)
				->orderBy('pubdate','desc')->paginate(30);
	return response()->json(['posts' => $posts]);
});