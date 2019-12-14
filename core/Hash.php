<?php

namespace App\Core;

/**
 * Class Hash
 * @package App\Core
 */
class Hash
{
    /**
     * This method generates a hash.
     * @param $length
     * @return bool|string
     */
    public static function generate($length)
    {
        $alphabet = '0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN';
        return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
    }
}