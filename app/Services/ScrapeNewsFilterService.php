<?php

namespace App\Services;


use App\Http\Models\Source;

class ScrapeNewsFilterService
{
    private $source;

    private $imported = [];

    private $ignored = [];

    private $updated = [];

    private $created = [];

    public function __construct(array $resource)
    {
        $this->setSource($resource['source']);
        $this->filter($resource['news']);
    }

    private function setSource(Source $source)
    {
        $this->source = $source;
    }

    private function filter(array $news)
    {
        $this->imported = $news;
    }

    private function setImported(array $news)
    {
        $this->imported = $news;
    }


}