<?php

namespace App\Utilities;

use Illuminate\Support\Facades\DB;

class TokenUtil {
    
    public static function unique($table, $col, $size, $withSpecialCharacters = false)
    {
        do {
            $token = self::random($size, $withSpecialCharacters);

            $exists = DB::table($table)->where($col, $token)->exists();
        } while ($exists);

        return $token;
    }

    public static function random($size, $withSpecialCharacters = false)
    {
        $code = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $code .= "abcdefghijklmnopqrstuvwxyz";
        $code .= "0123456789";

        $token = self::generate($code, $size, $withSpecialCharacters);

        return $token;
    }

    private static function generate($characters, $size, $withSpecialCharacters = false)
    {
        if ($withSpecialCharacters) {
            $characters .= '!@#$%^&*()';
        }

        $token = '';
        $max = strlen($characters);
        for ($i = 0; $i < $size; $i++) {
            $token .= $characters[random_int(0, $max - 1)];
        }

        return $token;
    }
}
