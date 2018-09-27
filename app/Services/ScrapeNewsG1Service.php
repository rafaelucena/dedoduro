<?php

namespace App\Services;

class ScrapeNewsG1Service
{
    private $webBaseUrl = 'http://g1.globo.com/busca/?q=:searchFor:&order=recent&species=not%C3%ADcias&page=1';
//    private $webBaseUrl = 'http://g1.globo.com/busca/?q=:searchFor:&order=recent&species=not%C3%ADcias:searchForPage:';

    private $webContent;

    private $webUrls = [];

    private $webSource;

    private $webContentOffset = false;

    /**
     * ScrapeNewsG1Service constructor.
     *
     * @param string $name
     * @param string $pages
     */
    public function __construct(string $name, string $pages)
    {
        $this->webUrls = $this->buildUrls($name, $pages);
    }

    /**
     * @param string $name
     * @param string $pages
     *
     * @return array
     */
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

    /**
     * @param string $name
     *
     * @return string
     */
    private function buildUrlName(string $name)
    {
        $lowerName = strtolower($name);

        return preg_replace('/\s+/', '+', $lowerName);
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
        $this->webContentOffset = $itemCloseTagPos = strpos($this->webContent, $itemCloseTag, $itemOpenTagPos);
        $itemResult = substr($this->webContent, ($itemOpenTagPos), ($itemCloseTagPos - $itemOpenTagPos));
        $itemResult = preg_replace('/\r|\n/', '', $itemResult);

        return $itemResult;
    }

    private function getItemTitle(string $contentItem)
    {
        preg_match('/info__title.*?">(.*?)<\/div/', $contentItem, $matches);

        return trim($matches[1]);
    }

    private function getItemHappenedAt(string $contentItem)
    {
        // Get when
        preg_match('/"widget--info__meta">(.*?)<\/div/', $contentItem, $matches);
        $dateString = $matches[1];

        // @TODO - Read about unicode regex
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}\s+\d{2}h\d{2}$/', $dateString)) {
            return \DateTime::createFromFormat('d/m/Y H\hi', $dateString);
        } elseif (preg_match('/^h\w\s+(\d+)\s+dias?$/u', $dateString, $matches)) {
            return (new \DateTime(date('Y-m-d')))->modify("-{$matches[1]} days");
        } elseif (preg_match('/^h\w\s+(\d+)\s+horas?$/u', $dateString, $matches)) {
            return (new \DateTime())->modify("-{$matches[1]} hours");
        }

        return false;
    }

    private function getItemUrl(string $contentItem)
    {
        preg_match('/<a href=".*?u=(.*?)&key.*?"/', $contentItem, $matches);
        $urlDecoded = urldecode($matches[1]);

        if (strpos($urlDecoded, 'fato-ou-fake') !== false) {
            return false;
        }

        return $urlDecoded;
    }

    private function getItem(string $contentItem)
    {
        $result = [];

        // Get title
        if (($result['title'] = $this->getItemTitle($contentItem)) === false) {
            return false;
        }

        // Get when
        if (($result['happenedAt'] = $this->getItemHappenedAt($contentItem)) === false) {
            return false;
        }

        // Get url
        if (($result['url'] = $this->getItemUrl($contentItem)) === false) {
            return false;
        }

        $result['hashMd5'] = md5($result['url']);

        return $result;
    }

    public function roll()
    {
        $this->setContent($this->webUrls[0]);

        $this->setContentList();

        $contentItem = $this->getContentItem();

        $results = [];
        $continue = true;

        $count = 0;
        $currentLoop = 0;
        $maxLoop = 30;
        while ($this->webContentOffset !== false && $continue) {
            $currentLoop++;
            if ($currentLoop >= $maxLoop) {
                $continue = false;
            }

            $result = $this->getItem($contentItem);
            $contentItem = $this->getContentItem($this->webContentOffset);
            if ($result === false) {
                continue;
            }

            $results[] = $result;

            $count++;
            if ($count > 1) {
                break;
            }
        }

        return $results;
    }
}