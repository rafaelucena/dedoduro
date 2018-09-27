<?php

namespace App\Console\Commands;

use App\Console\Commands\Command;
use App\Http\Models\Persona;
use App\Services\ScrapeNewsService as Scrape;

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

    protected $hidden = false;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $personas = $this->em->createQueryBuilder()
            ->select([
                'pe.id AS personaId',
                'pe.shortName AS personaShortName',
            ])
            ->from(Persona::class, 'pe')
            ->where('pe.id IN (:ids)')
            ->setParameters(['ids' => ['1','2']])
            ->getQuery()
            ->getResult();

        foreach ($personas as $persona) {
            $short = $persona['personaShortName'];
            $scrapeObj = new Scrape($short, '1');
            $result[$short] = $scrapeObj->rock();
        }
        // Input
//        echo '<pre>';
//        print_r($this->argument('slug'));
//        die;
        //
//        echo $this->argument('slug');
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
