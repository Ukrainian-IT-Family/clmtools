<?php

namespace App\Helpers;

class Youtube
{
    public static function getPreviewImage($link, $title): string
    {
        $link_parts = stristr($link, '=');
        return $link_parts ?
            config('constants.thumbnail.youtube').mb_substr($link_parts, 1).config('constants.thumbnail.youtube_size') :
            config('constants.thumbnail.empty').$title;
    }
}
