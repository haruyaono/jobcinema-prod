<?php

return [
    'default_disk' => 'public',

    'ffmpeg' => [
        'binaries' => '/usr/bin/ffmpeg',
        'threads' => 12,
    ],

    'ffprobe' => [
        'binaries' => '/usr/bin/ffprobe',
    ],

    'timeout' => 3600,
];
