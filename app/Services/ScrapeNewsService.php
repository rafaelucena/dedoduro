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
use App\Services\ScrapeNewsFilterService;

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

    private $info;

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
        //deleteme
        $news = json_decode('{"c76b20dae4da97f9fda71d7e5c9ae1be":{"title":"Ap\u00f3s decis\u00e3o do STF, defesa de Lula pede \u00e0 Justi\u00e7a que solte o ex-presidente","happenedAt":null,"url":"https:\/\/g1.globo.com\/pr\/parana\/noticia\/2018\/12\/19\/apos-decisao-do-stf-defesa-de-lula-pede-a-justica-que-solte-o-ex-presidente.ghtml","valid":false,"hashMd5":"c76b20dae4da97f9fda71d7e5c9ae1be"},"735aa2a3c26181a44306cae92e05d824":{"title":"Presidente da OAB diz que STF precisa dar decis\u00e3o definitiva sobre pris\u00e3o ap\u00f3s 2\u00aa inst\u00e2ncia","happenedAt":null,"url":"https:\/\/g1.globo.com\/rr\/roraima\/noticia\/2018\/12\/19\/presidente-da-oab-diz-que-stf-precisa-dar-decisao-definitiva-sobre-prisao-apos-2a-instancia.ghtml","valid":false,"hashMd5":"735aa2a3c26181a44306cae92e05d824"}}', true);

        $this->results = [];
        foreach ($this->resources as $sourceFingerprint => $resource) {
//            $resource['news'] = $resource['service']->roll();
            $resource['news'] = $news;
            unset($resource['service']);
            $this->results[$sourceFingerprint] = $resource;
        }

        foreach ($this->results as $resource) {
            $filter = new ScrapeNewsFilterService($resource);
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