<?php

namespace App\Services;

class ScrapeNewsG1Service
{
    private $webBaseUrl = 'http://g1.globo.com/busca/?q=:searchFor:&order=recent&species=not%C3%ADcias&page=1';
//    private $webBaseUrl = 'http://g1.globo.com/busca/?q=:searchFor:&order=recent&species=not%C3%ADcias:searchForPage:';

    private $webContent;

    private $webSource = '';

    private $webContinueFrom = false;

    public function __construct(string $name, string $pages)
    {
        $urls = $this->buildUrls($name, $pages);

        $this->setContent($urls[0]);
    }

    private function buildUrls(string $name, string $pages)
    {
        $name = $this->buildUrlName($name);

        $result = [];
        $result[] = str_replace(
            [':searchFor:'],
            [$name],
            $this->webBaseUrl
        );

        return $result;
    }

    private function buildUrlName(string $name)
    {
        $lowerName = strtolower($name);
        $parsedName = preg_replace('/\s+/', '+', $lowerName);

        return $parsedName;
    }

    /*private function getBaseUrl()
    {
        return 'http://g1.globo.com/busca/?q=:searchFor:&order=recent&species=not%C3%ADcias&page=1';
//        return 'http://g1.globo.com/busca/?q=:searchFor:&order=recent&species=not%C3%ADcias:searchForPage:';
    }*/

    private function setContent(string $url)
    {
        // Correio
//    https://www.correiobraziliense.com.br/busca/jair+bolsonaro?secao=Politica&offset=10
        $curlObj = curl_init();
        curl_setopt($curlObj, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_REFERER, "http://g1.globo.com");
        $User_Agent = 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31';
        curl_setopt($curlObj, CURLOPT_USERAGENT, $User_Agent);
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlObj, CURLOPT_HEADER, true);
        $this->webContent = curl_exec($curlObj);

        curl_close($curlObj);

        return true;
    }

    private function setContentList()
    {
        $listOpenTag = '<ul class="results__list">';
        $listOpenTagPos = strpos($this->webContent, $listOpenTag);
        $listCloseTag = '</ul>';
        $listCloseTagPos = strpos($this->webContent, $listCloseTag, $listOpenTagPos);
        $this->webContent = substr($this->webContent, ($listOpenTagPos), ($listCloseTagPos - $listOpenTagPos));

        return true;
    }

    private function getContentItem(int $offset = 0)
    {
        $itemOpenTag = '<li class="widget widget--card widget--info" data-position="';
        $itemOpenTagPos = strpos($this->webContent, $itemOpenTag, $offset);
        $itemCloseTag = '</li>';
        $this->webContinueFrom = $itemCloseTagPos = strpos($this->webContent, $itemCloseTag, $itemOpenTagPos);
        $itemResult = substr($this->webContent, ($itemOpenTagPos), ($itemCloseTagPos - $itemOpenTagPos));
        $itemResult = preg_replace('/\r|\n/', '', $itemResult);

        return $itemResult;
    }

    public function run()
    {
        $this->setContentList();

        $contentItem = $this->getContentItem();

        $result = [];
        $continue = true;

        $count = 0;
        while ($this->webContinueFrom !== false && $continue) {
            $count++;
            $teste = [];

            // Get title
            preg_match('/info__title.*?">(.*?)<\/div/', $contentItem, $matches);
            $teste['title'] = trim($matches[1]);

            // Get when
            preg_match('/"widget--info__meta">(.*?)<\/div/', $contentItem, $matches);
            $teste['happenedAt'] = $matches[1];

            // Get url
            preg_match('/<a href=".*?u=(.*?)&key.*?"/', $contentItem, $matches);
            $teste['url'] = urldecode($matches[1]);

            $result[] = $teste;
            if ($count > 5) {
                $continue = false;
            }

            $contentItem = $this->getContentItem($this->webContinueFrom);
        }

        return $result;
    }
}