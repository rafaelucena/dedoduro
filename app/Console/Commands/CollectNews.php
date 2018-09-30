<?php

namespace App\Console\Commands;

use App\Console\Commands\Command as BaseCommand;
use App\Http\Models\Persona;
use App\Services\ScrapeNewsService as Scrape;

class CollectNews extends BaseCommand
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
        $personas = $this->em->getRepository(Persona::class)->findBy(['isActive' => 1, 'isDeleted' => 0]);
//        $personas = $this->em->createQueryBuilder()
//            ->select('pe')
//            ->from(Persona::class, 'pe')
//            ->where('pe.isActive = 1 AND pe.isDeleted = 0')
//            ->andWhere('pe.id IN (:ids)')
//            ->setParameters(['ids' => ['1','2']])
//            ->getQuery()
//            ->getResult();

        /* @var Persona $persona */
        foreach ($personas as $persona) {
            $scrapeObj = new Scrape($this->em);
            $scrapeObj->mapResources($persona, '1');
            $result[$persona->shortName] = $scrapeObj->rock();
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
        dump($result);
    }
}
