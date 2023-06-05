<?php

namespace App\Output\Factory;

use App\Entity\Url;
use App\Output\UrlOutput;

class UrlOutputFactory
{
    public function create(Url $url): UrlOutput
    {
        $output = new UrlOutput();

        $output->url = $url->getUrl();
        $output->createdDate = $url->getCreatedDate();

        return $output;
    }
}
