<?php

namespace App\Helpers;

class PostHelpers
{
    public static function formatText(string $text): string
    {
        return preg_replace("/\n+/", "\n\n", $text);
    }
}
