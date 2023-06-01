<?php

namespace App\Service\Url;

class UrlHelper
{
    public const HTTP = 'http://';

    public function addScheme(string $url): string
    {
        if (!str_starts_with(self::HTTP, $url)) {
            return self::HTTP . $url;
        }
    }
}
