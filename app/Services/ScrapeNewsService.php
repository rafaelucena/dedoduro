<?php

namespace App\Services;

use App\Services\ScrapeNewsG1Service as ScrapeNewsG1;

class ScrapeNewsService
{
    private $sources = ['G1'];

    private $resources = [];

    private $results = [];

    public function __construct(string $name, string $pages)
    {
        foreach ($this->sources as $source) {
            switch ($source) {
                case 'G1':
                        $this->resources[$source] = new ScrapeNewsG1($name, $pages);
                    break;
            }
        }
    }

    public function rock()
    {
        $results = [];
        foreach ($this->resources as $source => $resource) {
            $results[$source] = $resource->roll();
        }

        return $results;
    }
}