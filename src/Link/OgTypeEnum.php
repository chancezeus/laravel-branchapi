<?php

namespace ChanceZeus\BranchApi\Link;

use ChanceZeus\BranchApi\Types\Enum;

class OgTypeEnum extends Enum {
    const ARTICLE = 'article';
    const BOOK = 'book';
    const MUSIC_ALBUM = 'music.album';
    const MUSIC_PLAYLIST = 'music.playlist';
    const MUSIC_RADIO_STATION = 'music.radio_station';
    const MUSIC_SONG = 'music.song';
    const PROFILE = 'profile';
    const VIDEO_EPISODE = 'video.episode';
    const VIDEO_MOVIE = 'video.movie';
    const VIDEO_OTHER = 'video.other';
    const VIDEO_TV_SHOW = 'video.tv_show';
    const WEBSITE = 'website';
}
