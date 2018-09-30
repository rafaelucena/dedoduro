<?php

namespace App\Services;

use App\Http\Models\News;
use App\Http\Models\NewsFlagModel as NewsFlag;
use App\Http\Models\Persona;
use App\Http\Models\PersonaNews;
use App\Http\Models\Source;
use App\Http\Models\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\ScrapeNewsG1Service as ScrapeNewsG1;

class ScrapeNewsService
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    private $sourceFingerprints = [
        'g1_globo',
        'folha_sao_paulo',
        'correio_braziliense',
        'o_globo',
        'congresso_foco',
    ];

    private $sources = [];

    /**
     * @var User
     */
    private $user;

    private $resources = [];

    private $results = [];

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        $this->sources = $this->em->getRepository(Source::class)->findBy([
            'isActive' => 1,
            'isDeleted' => 0,
            'fingerprint' => $this->sourceFingerprints,
        ]);

        $this->user = $this->em->getRepository(User::class)->findOneBy([
            'name' => 'robocop_x9',
        ]);
    }

    public function mapResources(Persona $persona, string $pages)
    {
        /* @var Source $source */
        foreach ($this->sources as $source) {
            switch ($source->fingerprint) {
                case 'g1_globo':
                    $resource['persona'] = $persona;
                    $resource['source'] = $source;
                    $resource['service'] = new ScrapeNewsG1($persona->shortName, $pages);

//                    $this->resources[$source->fingerprint] = new ScrapeNewsG1($name, $pages);
                    $this->resources[$source->fingerprint] = $resource;
                    break;
            }
        }
    }

    public function rock()
    {
        $this->results = [];
        foreach ($this->resources as $sourceFingerprint => $resource) {
            $resource['news'] = $resource['service']->roll();
            unset($resource['service']);
            $this->results[$sourceFingerprint] = $resource;
        }

        foreach ($this->results as $resource) {
            $filteredNews = $this->filterNews($resource['news'], $resource['persona']);
//            $filteredNews = $resource['news'];

            foreach ($filteredNews['create'] as $newsData) {
                $flags = new NewsFlag();
                $flags->isImported = (int) true;
                $flags->setCreatedBy($this->user);
                $this->em->persist($flags);

                $news = new News();
                $news->url = $newsData['url'];
                $news->title = $newsData['title'];
                $news->publishedAt = $newsData['happenedAt'];
                $news->hashMd5 = $newsData['hashMd5'];
                $news->setSource($resource['source']);
                $news->setCreatedBy($this->user);
                $news->setFlags($flags);
                $this->em->persist($news);

                $personaNews = new PersonaNews();
                $personaNews->setNews($news);
                $personaNews->setPersona($resource['persona']);
                $personaNews->setCreatedBy($this->user);
                $this->em->persist($personaNews);
            }

            foreach ($filteredNews['relate'] as $newsData) {
                /* @var News $news */
                $news = $this->em->getRepository(News::class)->findOneBy(['hashMd5' => $newsData['hashMd5']]);

                $personaNews = new PersonaNews();
                $personaNews->setNews($news);
                $personaNews->setPersona($resource['persona']);
                $personaNews->setCreatedBy($this->user);
                $this->em->persist($personaNews);
            }
        }

        $this->em->flush();

        return $this->results;
    }

    private function filterNews(array $news, Persona $persona)
    {
        $result = [
            'create' => [],
            'relate' => [],
        ];
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
                    'persona' => $persona,
                ])
                ->getQuery()
                ->getResult();

            $result['relate'] = array_diff_key($news, $found);
        }

        return $result;
    }
}