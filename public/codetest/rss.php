<?php
$feed = file_get_contents('http://blog.livedoor.jp/rbkyn844/index.rdf');
$invalid_characters = '/[^\x9\xa\x20-\xD7FF\xE000-\xFFFD]/';
$feed = preg_replace($invalid_characters, '', $feed);
$rss = simplexml_load_string($feed, 'SimpleXMLElement', LIBXML_NOCDATA);
foreach ( $rss->item as $item ) {
    echo "タイトル：".$item->title."\n";
    echo "URL：".$item->link."\n";
    echo "カテゴリ：".$item->children('dc', true)->subject."\n";
    echo "日時：".$item->children('dc', true)->date."\n";
    echo "------------------------------\n";
}
echo "done.";
?>