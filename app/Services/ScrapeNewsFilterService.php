<?php

namespace App\Services;


use App\Http\Models\News;
use App\Http\Models\Persona;
use App\Http\Models\PersonaNews;
use App\Http\Models\Source;
use Doctrine\ORM\EntityManagerInterface;

class ScrapeNewsFilterService
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    private $source;

    private $persona;

    private $imported = [];

    private $ignore = [];

    private $update = [];

    private $create = [];

    public function __construct(EntityManagerInterface $em)
    {
    }

    public function filterNews(array $resource)
    {
        $this->setSource($resource['source']);
        $this->setPersona($resource['persona']);
        $this->mapNews($resource['news']);
    }

    private function setSource(Source $source)
    {
        $this->source = $source;
    }

    private function setPersona(Persona $persona)
    {
        $this->persona = $persona;
    }

    private function mapNews(array $news)
    {
        $this->imported = $news;
        $hashes = array_column($news, 'hashMd5');

        $found = $this->em->createQueryBuilder()
            ->select([
                'ne.hashMd5',
            ])
            ->from(News::class, 'ne', 'ne.hashMd5')
            ->where('ne.hashMd5 IN (:hashes)')
            ->setParameters([
                'hashes' => $hashes,
            ])
            ->getQuery()
            ->getResult();

        $result['create'] = array_diff_key($news, $found);

        if (count($result['create']) != count($news)) {
            $found = $this->em->createQueryBuilder()
                ->select([
                    'ne.hashMd5',
                ])
                ->from(News::class, 'ne', 'ne.hashMd5')
                ->innerJoin(PersonaNews::class, 'pn', 'WITH', 'pn.news = ne')
                ->where('ne.hashMd5 IN (:hashes)')
                ->andWhere('pn.persona = :persona')
                ->setParameters([
                    'hashes' => $hashes,
                    'persona' => $this->persona,
                ])
                ->getQuery()
                ->getResult();

            $result['relate'] = array_diff_key($news, $found);
        }
    }

    private function setImported(array $news)
    {
        $this->imported = $news;
    }


}