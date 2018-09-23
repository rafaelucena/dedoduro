<?php

namespace App\Console\Commands;

use App\Console\Commands\Command;
use App\Http\Models\Persona;

class CollectNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:collect {slug*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $webContent;

    private $webSource = '';

    private $webContinueFrom = false;

    private function setContent(string $url)
    {
        // Correio
//    https://www.correiobraziliense.com.br/busca/jair+bolsonaro?secao=Politica&offset=10
        // G1
//    http://g1.globo.com/busca/?q=jair+bolsonaro&order=recent&species=not%C3%ADcias&page=1
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
        switch ($this->webSource) {
            case 'G1':
                $listOpenTag = '<ul class="results__list">';
                $listOpenTagPos = strpos($this->webContent, $listOpenTag);
                $listCloseTag = '</ul>';
                $listCloseTagPos = strpos($this->webContent, $listCloseTag, $listOpenTagPos);
                $this->webContent = substr($this->webContent, ($listOpenTagPos), ($listCloseTagPos - $listOpenTagPos));
                break;
            default:
                $this->webContent = '';
                break;
        }

        return true;
    }

    private function getContentItem(int $offset = 0)
    {
        switch ($this->webSource) {
            case 'G1':
                $itemOpenTag = '<li class="widget widget--card widget--info" data-position="';
                $itemOpenTagPos = strpos($this->webContent, $itemOpenTag, $offset);
                $itemCloseTag = '</li>';
                $this->webContinueFrom = $itemCloseTagPos = strpos($this->webContent, $itemCloseTag, $itemOpenTagPos);
                $itemResult = substr($this->webContent, ($itemOpenTagPos), ($itemCloseTagPos - $itemOpenTagPos));
                $itemResult = preg_replace('/\r|\n/', '', $itemResult);
                break;
            default:
                $itemResult = '';
                break;
        }

        return $itemResult;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Input
//        echo '<pre>';
//        print_r($this->argument('slug'));
//        die;
        //
//        echo $this->argument('slug');
        // Correio
//    https://www.correiobraziliense.com.br/busca/jair+bolsonaro?secao=Politica&offset=10
        // G1
//    http://g1.globo.com/busca/?q=jair+bolsonaro&order=recent&species=not%C3%ADcias&page=1
        $this->setContent('http://g1.globo.com/busca/?q=jair+bolsonaro&order=recent&species=not%C3%ADcias&page=1');

        $this->webSource = 'G1';

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
            if ($count > 3) {
                $continue = false;
            }

            $contentItem = $this->getContentItem($this->webContinueFrom);
        }

//    echo $html;
//    $DOM = new DOMDocument();
//    $DOM->loadHTML($html);
//    $xpath = new DomXpath($DOM);
//    $titulo = $xpath->query('//input[@name="materia_titulo"]/@value')->item(0);
//    $letra = $xpath->query('//div[@id="materia-letra"]')->item(0);
//    echo "Titulo da matéria: ". $titulo->nodeValue . "<p>" . "Conteúdo da matéria: "   .$letra->nodeValue;
//    $feed = simplexml_load_file($feedLink, 'SimpleXMLElement', LIBXML_NOCDATA);
//
//    foreach($feed->channel->item AS $item){
//        if($count == $limit){
//            break;
//        }
//        echo $item->link . '<br />';
//        echo $item->title . '<br />';
//        echo $item->description . '<br />';
//        echo $item->pubDate . '<br />';
//        echo '<br />------------------<br /><br />';
//        $count++;
//    }

        echo '<pre>';
        print_r($result);
    }
}
