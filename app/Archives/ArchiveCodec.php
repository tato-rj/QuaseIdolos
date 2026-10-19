<?php

namespace App\Archives;

use RuntimeException;

class ArchiveCodec
{
    // A raw JSON snapshot cannot start with this binary version marker.
    const HEADER = "\x00QIARCHIVE\x01";
    const MAGIC = "\x00QIARCHIVE";

    public static function compressed($value)
    {
        return strncmp($value, self::MAGIC, strlen(self::MAGIC)) === 0;
    }

    public static function encode($value)
    {
        if (self::compressed($value)) {
            self::decode($value);
            return $value;
        }

        if (strlen($value) < 256 || ! function_exists('gzencode'))
            return $value;

        $compressed = gzencode($value, 6);
        if ($compressed === false)
            throw new RuntimeException('Could not compress an archive snapshot.');

        $encoded = self::HEADER.$compressed;
        if (strlen($encoded) >= strlen($value))
            return $value;

        // Validate the exact bytes before allowing either new writes or compaction.
        if (self::decode($encoded) !== $value)
            throw new RuntimeException('Archive compression verification failed.');

        return $encoded;
    }

    public static function decode($value)
    {
        if (! self::compressed($value))
            return $value;

        if (strncmp($value, self::HEADER, strlen(self::HEADER)) !== 0)
            throw new RuntimeException('Unsupported event archive encoding version. The record was not modified.');

        if (! function_exists('gzdecode'))
            throw new RuntimeException('The zlib extension is required to read compressed event history.');

        $decoded = @gzdecode(substr($value, strlen(self::HEADER)));
        if ($decoded === false)
            throw new RuntimeException('A compressed archive snapshot is damaged; it was not modified.');

        return $decoded;
    }
}
