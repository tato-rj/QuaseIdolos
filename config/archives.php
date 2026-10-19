<?php

return [
    // Keep the decoder enabled even when disabling compression for a rollback.
    'compress' => env('ARCHIVE_COMPRESSION', true),
];
