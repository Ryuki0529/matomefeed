<?php
namespace App\Library;

class MyFunc
{
    public static function httpLoadRequest( $url )
    {
        //サイトから情報を取得します。
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL,$url);
        curl_setopt( $ch, CURLOPT_HEADER, false );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla5.0 (Windows NT 6.1; WOW64; rv20.0) Gecko20100101 Firefox20.0' );

        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch,CURLOPT_COOKIEJAR,      'cookie');
        curl_setopt($ch,CURLOPT_COOKIEFILE,     'tmp');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION, TRUE);

        $result = curl_exec( $ch );
        curl_close( $ch );

        if ( isset($result) && $result != "" ){
             //改行削除（じゃまな場合）
            $result = str_replace(array("\r", "\n"), '', $result);
            return $result;
        } else{
            return false;
        }
    }

    public static function feedObjectFormation( $xml )
    {
        $invalid_characters = '/[^\x9\xa\x20-\xD7FF\xE000-\xFFFD]/';
        $feed = preg_replace($invalid_characters, '', $xml);
        return simplexml_load_string($feed, 'SimpleXMLElement', LIBXML_NOCDATA);
    }

    public static function getFeedObject( $url )
    {
        return self::feedObjectFormation( self::httpLoadRequest( $url ) );
    }
}