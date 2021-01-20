<?php

namespace App\Console\Commands;

use App\Library\MyFunc;
use Illuminate\Console\Command;
use App\Models\RssLoadList;
use App\Models\RssSuggestion;
use App\Models\RssLoadedFeed;
use Goutte;

class feedUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:feed_update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'RSSフィードの更新処理';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (RssLoadList::all() as $feed) {
            $exc_filter = $feed->exc_filter;
            $rss_url = $feed->rss_url;
            $category_id = $feed->category_id;
            $rss_load_list_id = $feed->id;
            $img_dom_path = $feed->img_dom_path;
            $result = MyFunc::getFeedObject( $rss_url );

            // WordPressブログ or ライブドアブログの判定
            $is_wp = preg_match("/feed$/", $rss_url);
            if ( $is_wp === 1 ) {
                $xmlCustom = $result->channel->item;
            }else {
                $xmlCustom = $result->item;
            }

            $feedCount = 0;
            //echo ( "■" . $feed->site_name . "\n###################\n" );
            foreach ( $xmlCustom  as $item ) {
                if ( preg_match("/${exc_filter}/", $item->title) !== 1 || is_null($exc_filter) ) {
                    if ( !is_null( RssLoadedFeed::where( 'url', $item->link )->first() ) ) break;

                    echo ("タイトル：" . $item->title . "\n");
                    echo ("URL：" . $item->link . "\n");

                    $rss_suggestions = [];
                    if ( preg_match("/feed$/", $rss_url) === 1 ) {
                        echo ("日時：" . $item->pubDate . "\n");
                        $post_pubdate = preg_replace("/\+([0-9]|:).*$/", "+09:00", $item->pubDate);
                        $post_pubdate = date("Y-m-d H:i:s", strtotime( $post_pubdate ));
                        echo ("カテゴリ：");
                        foreach ( $item->category as $cat ) {
                            echo ($cat . " / ");
                            $rss_suggestions[] = $cat;
                        }
                    }else {
                        echo ("カテゴリ：" . $item->children('dc', true)->subject . "\n");
                        echo ( "日時：" . $item->children('dc', true)->date . "\n" );
                        $post_pubdate = date("Y-m-d H:i:s", strtotime( $item->children('dc', true)->date ));
                        $rss_suggestions[] = $item->children('dc', true)->subject;
                    }

                    // サムネイル画像取得
                    $crawler = Goutte::request( 'GET', $item->link );
                    if ( is_null( $img_dom_path ) ) {
                        $crawler->filter( "meta" )->each( function ( $url ) {
                            if ( $url->attr('property') === "og:image" ) {
                                $GLOBALS['thumbnail_path'] = $url->attr('content');
                            }
                        });
                    }else $GLOBALS['thumbnail_path'] = $crawler->filter( $img_dom_path )->eq(0)->attr('src');
                    echo "サムネイル：" . $GLOBALS['thumbnail_path'] . "\n";
                    $finfo = finfo_open( FILEINFO_MIME_TYPE );
                    if ( $GLOBALS['thumbnail_path'] === "" ) {
                        $GLOBALS['thumbnail_path'] = config('app.url').'/img/no-image.jpg';
                    }
                    $post_thumbnail = file_get_contents( $GLOBALS['thumbnail_path'] );
                    $img_mime_type = finfo_buffer( $finfo, $post_thumbnail );

                    // 取得した記事情報の登録
                    $post_meta = RssLoadedFeed::create([
                        'rss_load_list_id' => $rss_load_list_id, 'pubdate' => $post_pubdate,
                        'title' => $item->title, 'url' => $item->link,
                        'img' => base64_encode( $post_thumbnail ), 'img_type' => $img_mime_type
                    ]);

                    // suggestionの登録
                    foreach ( $rss_suggestions as $cat ) {
                        $rss_suggestion = RssSuggestion::where('name', $cat)->first();
                        if ( is_null( $rss_suggestion ) ) {
                            $rss_suggestion = RssSuggestion::create(['name' => $cat, 'category_id' => $category_id]);
                        }
                        $post_meta->rss_suggestion()->attach( $rss_suggestion->id );
                    }

                    echo ("------------------------\n");
                }
                sleep(1);
                $feedCount++; $GLOBALS = [];
                if ($feedCount === 11) break;
            }
            sleep(1);
        }
        return null;
    }
}
