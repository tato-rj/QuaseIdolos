<?php

namespace Tests\Unit;

use App\Archives\ArchiveCodec;
use PHPUnit\Framework\TestCase;

class ArchiveCodecTest extends TestCase
{
    /** @test */
    public function compression_preserves_every_original_byte_and_nested_field()
    {
        $json = json_encode([
            'id' => 123, 'name' => 'Música 🎵', 'empty' => null,
            'song' => ['lyrics' => str_repeat("Uma canção\n", 1000)],
            'singers' => [['id' => 3, 'name' => 'João'], ['id' => 9, 'name' => 'Ana']],
        ], JSON_UNESCAPED_UNICODE);
        $encoded = ArchiveCodec::encode($json);

        $this->assertTrue(ArchiveCodec::compressed($encoded));
        $this->assertSame($json, ArchiveCodec::decode($encoded));
        $this->assertSame($encoded, ArchiveCodec::encode($encoded));
        $this->assertLessThan(strlen($json) / 4, strlen($encoded));
    }

    /** @test */
    public function legacy_and_small_values_remain_readable_and_unchanged()
    {
        foreach (['', 'null', '{"id":1}', '[1,2,3]', '"legacy string"'] as $value) {
            $this->assertSame($value, ArchiveCodec::encode($value));
            $this->assertSame($value, ArchiveCodec::decode($value));
        }
    }

    /** @test */
    public function damaged_compressed_history_is_reported_instead_of_silently_returning_null()
    {
        $this->expectException(\RuntimeException::class);
        ArchiveCodec::decode(ArchiveCodec::HEADER.'damaged data');
    }

    /** @test */
    public function unknown_future_encodings_are_preserved_and_reported()
    {
        $this->expectException(\RuntimeException::class);
        ArchiveCodec::encode(ArchiveCodec::MAGIC."\x02future data");
    }
}
