<?php

return [

    /**
     * The paths relative to the project root to backup
     *
     * Note: Can be a directory OR a file
     */
    'backup' => [
        '.env',
        'laravel-echo-server.json',
        'config',
        'public/files',
        'resources/views/emails'
    ]
];