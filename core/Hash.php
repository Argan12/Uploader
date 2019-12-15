<?php

/**
 * This class is part of Uploader package.
 * This class make a hash which will be used for rename a file.
 * It can be reused for other projects (for example, generate a token).
 *
 * Author : Argan Piquet
 */

namespace Gwereve\Core;

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