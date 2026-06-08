<?php

namespace App\Helpers;

class HashidsHelper
{
    private static $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    private static $offset = 93175; // Offset acak agar ID kecil tidak menghasilkan string yang berurutan atau terlalu pendek

    /**
     * Meng-encode integer ID menjadi string acak pendek (Base62).
     *
     * @param int $id
     * @return string
     */
    public static function encode(int $id): string
    {
        $num = $id + self::$offset;
        $hash = '';
        $base = strlen(self::$alphabet);

        while ($num > 0) {
            $hash = self::$alphabet[$num % $base] . $hash;
            $num = intval($num / $base);
        }

        return $hash;
    }

    /**
     * Men-decode string acak pendek kembali menjadi integer ID asal.
     *
     * @param string $hash
     * @return int|null
     */
    public static function decode(string $hash): ?int
    {
        $base = strlen(self::$alphabet);
        $num = 0;
        $len = strlen($hash);

        for ($i = 0; $i < $len; $i++) {
            $pos = strpos(self::$alphabet, $hash[$i]);
            if ($pos === false) {
                return null;
            }
            $num = $num * $base + $pos;
        }

        $id = $num - self::$offset;
        return $id > 0 ? $id : null;
    }
}
