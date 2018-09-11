<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Models\Blog;
use App\Http\Models\Contact;
use App\Http\Models\ContactType;
use App\Http\Models\News;
use App\Http\Models\PersonaNews;
use App\Http\Models\PersonaSlug;
use App\Http\Models\Politician;
use App\Http\Models\PoliticianRole;
use App\Http\Models\Slug;
use App\Http\Models\Source;
use App\Http\Models\Subscriber;
use App\Http\Models\Persona;
use App\Http\Models\Party;
use App\Jobs\SendSubscriptionVerificationEmail;
use App\Listeners\EmailSubscribedListener;
use app\models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Show the Blogs Homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maxPublishedDates = $this->em->createQueryBuilder()
            ->select([
                'CONCAT(identity(pn.persona),\'-\',max(ne.publishedAt)) as publishedAt',
            ])
            ->from(News::class, 'ne')
            ->innerJoin(PersonaNews::class, 'pn', 'WITH', 'pn.news = ne')
            ->groupBy('pn.persona')
            ->getQuery()
            ->getResult();

        $recentNewsPoliticians = $this->em->createQueryBuilder()
            ->select([
                'pe.firstName AS personFirst',
                'pe.lastName AS personLast',
                'pe.shortName AS personShort',
                'sl.slug AS personUrn',
                'pe.image AS personImage',
                'pr.name AS roleName',
                'po.isRoleStill AS isRoleStill',
                'pa.shortName AS partyShort',
                'ne.publishedAt AS newsPublishedAt',
                'ne.title AS newsTitle',
                'ne.url as newsUrl',
                'so.name AS sourceName',
            ])
            ->from(Persona::class, 'pe')
            ->innerJoin(PersonaSlug::class, 'ps', 'WITH', 'ps.persona = pe')
            ->innerJoin(Slug::class, 'sl', 'WITH', 'sl = ps.slug')
            ->innerJoin(Politician::class, 'po', 'WITH', 'po.persona = pe')
            ->innerJoin(PoliticianRole::class, 'pr', 'WITH', 'pr = po.role')
            ->innerJoin(Party::class, 'pa', 'WITH', 'pa = po.party')
            ->innerJoin(PersonaNews::class, 'pn', 'WITH', 'pn.persona = pe')
            ->innerJoin(News::class, 'ne', 'WITH', 'ne = pn.news')
            ->innerJoin(Source::class, 'so', 'WITH', 'so = ne.source')
            ->where('CONCAT(pe.id,\'-\',ne.publishedAt) IN (:publishedDates)')
            ->andWhere('sl.isCanonical = 1')
            ->setParameters([
                'publishedDates' => $maxPublishedDates,
            ])
            ->getQuery()
            ->getMaxResults(5);

        $ninja = new \stdClass();

        return view('guest/home/home', [
            'recentNewsPoliticians' => $recentNewsPoliticians,
        ]);
    }

    protected function search($query = null)
    {
        $visible = false;
        $results = [];

        if ($query !== null) {
            $visible = true;

            $maxPublishedDates = $this->em->createQueryBuilder()
                ->select([
                    'CONCAT(identity(pn.persona),\'-\',max(ne.publishedAt)) as publishedAt',
                ])
                ->from(News::class, 'ne')
                ->innerJoin(PersonaNews::class, 'pn', 'WITH', 'pn.news = ne')
                ->groupBy('pn.persona')
                ->getQuery()
                ->getResult();

            $results = $this->em->createQueryBuilder()
                ->select([
                    'pe.firstName AS personFirst',
                    'pe.lastName AS personLast',
                    'pe.shortName AS personShort',
                    'sl.slug AS personUrn',
                    'pe.image AS personImage',
                    'pr.name AS roleName',
                    'po.isRoleStill AS isRoleStill',
                    'pa.shortName AS partyShort',
                    'ne.publishedAt AS newsPublishedAt',
                    'ne.title AS newsTitle',
                    'ne.url as newsUrl',
                    'so.name AS sourceName',
                ])
                ->from(Persona::class, 'pe')
                ->innerJoin(PersonaSlug::class, 'ps', 'WITH', 'ps.persona = pe')
                ->innerJoin(Slug::class, 'sl', 'WITH', 'sl = ps.slug')
                ->innerJoin(Politician::class, 'po', 'WITH', 'po.persona = pe')
                ->innerJoin(PoliticianRole::class, 'pr', 'WITH', 'pr = po.role')
                ->innerJoin(Party::class, 'pa', 'WITH', 'pa = po.party')
                ->innerJoin(PersonaNews::class, 'pn', 'WITH', 'pn.persona = pe')
                ->innerJoin(News::class, 'ne', 'WITH', 'ne = pn.news')
                ->innerJoin(Source::class, 'so', 'WITH', 'so = ne.source')
                ->where('CONCAT(pe.id,\'-\',ne.publishedAt) IN (:publishedDates)')
                ->andWhere('sl.isCanonical = 1')
                ->andWhere('pe.firstName LIKE :query OR pe.lastName LIKE :query OR CONCAT(pe.firstName,\' \',pe.lastName) LIKE :query')
                ->setParameters([
                    'publishedDates' => $maxPublishedDates,
                    'query' => '%' . $query . '%',
                ])
                ->getQuery()
                ->getResult();
        }
        $countResults = count($results);

        $sideList = $this->em->createQueryBuilder()
            ->select([
                'CONCAT(pe.firstName, \' \', pe.lastName) AS personName',
                'pe.shortName AS personShort',
                'pe.image AS personImage',
                'sl.slug AS personUrn',
            ])
            ->from(Persona::class, 'pe')
            ->innerJoin(PersonaSlug::class, 'ps', 'WITH', 'ps.persona = pe')
            ->innerJoin(Slug::class, 'sl', 'WITH', 'sl = ps.slug')
            ->innerJoin(Politician::class, 'po', 'WITH', 'po.persona = pe')
            ->where('sl.isCanonical = 1')
            ->orderBy('pe.firstName, pe.lastName')
            ->getQuery()
            ->getResult();

        $ninja = new \stdClass();
        $ninja->action = route('search.redirect');
        $ninja->searchBy = [
            'visible' => $visible,
            'query' => $query,
        ];
        $ninja->results = [
            'count' => $countResults,
            'list' => $results,
        ];
        $ninja->sideList = $sideList;

        return view('guest/home/search', [
            'ninja' => $ninja,
        ]);
    }

    protected function contact()
    {
        $contactTypes = $this->em->getRepository(ContactType::class)->findBy([
            'isActive' => (int) true,
            'isDeleted' => (int) false,
        ]);

        $ninja = new \stdClass();
        $ninja->method = 'POST';
        $ninja->action = route('contact.store');
        $ninja->info = [
            'title' => 'Quer dizer alguma coisa?',
            'subtitle' => 'Escreva pra gente!',
            'list' => 'Duvidas, sugestoes, reclamacoes, conteudo, informacoes, anuncios...',
        ];
        $ninja->form = [
            'type' => $contactTypes,
        ];

        return view('guest/home/contact', [
            'ninja' => $ninja,
//            'persona' => $persona,
//            'role' => $role,
        ]);
    }

    public function contactStore(Request $request)
    {
        $validatedData = $request->validate([
            'author' => 'bail|required|max:150',
            'email' => 'required|email',
            'message' => 'required|max:600',
        ]);

        if ($validatedData) {
            $contact = new Contact();
            $contact->author = ucwords(strtolower($request->author));
            $contact->email = strtolower($request->email);
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->contactType = $this->em->getRepository(ContactType::class)->find($request->type);

            $this->em->persist($contact);
            $this->em->flush();

            return back()->with('custom_success', 'Your comment added successfully');
        }

        return back()->with('custom_success', 'Unable to add comment.');
    }

    /**
     * Show the Blogs Homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request)
    {
        // Validate data
        $validatedData = $request->validate([
            'email' => 'required|email|unique:App\Http\Models\Subscriber'
        ]);

        if ($validatedData) {
            // Save Subscriber
            $subscriber = new Subscriber;
            $subscriber->email = $request->email;
            $subscriber->confirmationToken = md5(uniqid($request->email, true));
            $subscriber->isActive = (int) false;

            $this->em->persist($subscriber);
            $this->em->flush();

//            $subscriber->save();
            // Automatic Send Email for confirmation
            event(new EmailSubscribedListener($subscriber));
            SendSubscriptionVerificationEmail::dispatch($subscriber);
            // Return Success Message
            return response()->json('Check Your Email Inbox for confirmation', 200);
        }
        // return error
        return response()->json('Unable to Subscribe', 422);
    }

    public function subscribeVerify($token)
    {
        $subscriber = $this->em->getRepository(Subscriber::class)->findOneBy(['confirmationToken' => $token]);
//        $subscriber = Subscriber::where('confirmation_token', $token)->first();
        $subscriber->isActive = 1;

        $this->em->persist($subscriber);
        $this->em->flush();

//        if ($subscriber->save()) {
            return view('guest.subscribe-confirmation', ['subscriber' => $subscriber]);
//        }
    }
}
