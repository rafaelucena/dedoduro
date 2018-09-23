<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Models\Blog;
use App\Http\Models\News;
use App\Http\Models\Persona;
use App\Http\Models\Party;
use App\Http\Models\PersonaAction;
use App\Http\Models\PersonaSlug;
use App\Http\Models\Politician;
use App\Http\Models\PoliticianRole;
use App\Http\Models\Slug;
use App\Http\Models\Subscriber;
use App\Jobs\SendSubscriptionVerificationEmail;
use App\Listeners\EmailSubscribedListener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PoliticiansController extends Controller
{
    /**
     * Show the Blogs Homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = $this->em->getRepository(Blog::class)->findBy(
            ['isActive' => true],
            ['createdAt' => 'DESC']
        );
//        $blogs = Blog::active()->orderBy('created_at', 'desc')
//                            ->simplePaginate(app('global_settings')[2]->settingValue);
        return view('guest/test/test', ['blogs' => $blogs]);
    }

//    /**
//     * Show the Blogs Homepage.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function subscribe(Request $request)
//    {
//        // Validate data
//        $validatedData = $request->validate([
//            'email' => 'required|email|unique:App\Http\Models\Subscriber'
//        ]);
//
//        if ($validatedData) {
//            // Save Subscriber
//            $subscriber = new Subscriber;
//            $subscriber->email = $request->email;
//            $subscriber->confirmationToken = md5(uniqid($request->email, true));
//            $subscriber->isActive = (int) false;
//
//            $this->em->persist($subscriber);
//            $this->em->flush();
//
////            $subscriber->save();
//            // Automatic Send Email for confirmation
//            event(new EmailSubscribedListener($subscriber));
//            SendSubscriptionVerificationEmail::dispatch($subscriber);
//            // Return Success Message
//            return response()->json('Check Your Email Inbox for confirmation', 200);
//        }
//        // return error
//        return response()->json('Unable to Subscribe', 422);
//    }
//
//    public function subscribeVerify($token)
//    {
//        $subscriber = $this->em->getRepository(Subscriber::class)->findOneBy(['confirmationToken' => $token]);
////        $subscriber = Subscriber::where('confirmation_token', $token)->first();
//        $subscriber->isActive = 1;
//
//        $this->em->persist($subscriber);
//        $this->em->flush();
//
////        if ($subscriber->save()) {
//            return view('guest.subscribe-confirmation', ['subscriber' => $subscriber]);
////        }
//    }

    protected function inspect(Slug $slug)
    {
        if ($slug->isCanonical) {
            return $this->show($slug);
        }

        $canonicalSlug = $this->em->createQueryBuilder()
            ->select([
                'sl'
            ])
            ->from(Slug::class, 'sl')
            ->innerJoin(PersonaSlug::class, 'ps', 'WITH', 'ps.slug = sl')
            ->innerJoin(PersonaSlug::class, 'ps2',' WITH', 'ps2.persona = ps.persona')
            ->where('ps2.slug = :slug')
            ->andWhere('sl.isCanonical = 1')
            ->setParameters([
                'slug' => $slug
            ])
            ->getQuery()
            ->getOneOrNullResult();

        return redirect()->route('politician.show', ['slug' => $canonicalSlug->slug]);
    }

    /**
     * @param Slug $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function show(Slug $slug)
    {
        $this->continueOrAbort($slug);

        /* @var Persona $persona */
        $persona = $slug->getPersona();
        /* @var Politician $politician */
        $politician = $persona->getPolitician();
        /* @var PoliticianRole $role */
        $role = $politician->getRole();
        /* @var Party $party */
        $party = $politician->getParty();
        /* @var News[] $news */
        $news = $persona->getNews();
        /* @var PersonaAction[] $personaActions */
        $personaActions = $persona->getPersonaActions();

        $ninja = new \stdClass();
        $ninja->info = [
            'image' => 'storage/'. $persona->image,
//            'image' => 'assets/images/uploads/avatar/avatar-195x195.png',
            'shortName' => $persona->shortName,
            'longDesc' => $persona->description,
            'roleName' => ($politician->isRoleStill ? '' : 'Ex-') . $role->name,
            'partyName' => $party->shortName,
        ];
        $ninja->details = [
            'Nome' => $persona->firstName,
            'Sobrenome' => $persona->lastName,
            'Partido' => $party->fullName,
        ];

        if ($politician->getRoleWish()->id !== null) {
            $ninja->details = array_merge($ninja->details, ['Candidato a...' => $politician->getRoleWish()->name]);
        }

        $ninja->news = [];
        foreach ($news as $eachNews) {
            $ninja->news[] = [
                'Title' => $eachNews->title,
                'Source' => $eachNews->getSource()->name,
                'Url' => $eachNews->url,
                'Published' => $eachNews->publishedAt,
            ];
        }

        $ninja->actions = [];
        foreach ($personaActions as $personaAction) {
            $action = $personaAction->getAction();
            $personaActionType = $personaAction->getPersonaActionType();

            $performed = [];
            switch ($personaActionType->id) {
                case 1:
                    $performed['logo'] = 'logo-danger';
                    $performed['text'] = '<i class="far fa-times-circle fa-2x fa-2x-realign"></i> Votou <strong>CONTRA</strong>';
                    break;
                case 2:
                    $performed['logo'] = 'logo-success';
                    $performed['text'] = '<i class="far fa-check-circle fa-2x fa-2x-realign"></i> Votou <strong>A FAVOR</strong>';
                    break;
                case 3:
                    $performed['logo'] = 'logo-warning';
                    $performed['text'] = '<i class="fas fa-comment-slash fa-2x fa-2x-realign"></i> Se <strong>absteve</strong>';
                    break;
                case 4:
                    $performed['logo'] = 'logo-info';
                    $performed['text'] = '<i class="fas fa-gavel fa-2x fa-2x-realign"></i> <strong>Presidiu</strong>';
                    break;
                case 5:
                    $performed['logo'] = 'logo-normal';
                    $performed['text'] = '<!--<i class="fas fa-gavel fa-2x fa-2x-realign"></i> --><strong>Faltou</strong>';
                    break;
            }
            $ninja->actions[] = [
                'url' => $action->url,
                'title' => $action->title,
                'subtitle' => $action->subtitle,
                'happenedAt' => $action->happenedAt,
                'description' => $action->description,
                'personaAction' => $performed,
            ];
        }

        return view('guest/politicians/show', [
            'ninja' => $ninja,
            'persona' => $persona,
            'role' => $role,
        ]);
    }

    /**
     * @param Slug $slug
     * @return bool
     */
    private function continueOrAbort(Slug $slug)
    {
        /* @var Persona $persona */
        $persona = $slug->getPersona();
        if ($persona->isActive === (int) false) {
            abort(501);
        }

        /* @var Politician $politician */
        $politician = $persona->getPolitician();
        if ($politician->isActive === (int) false)
        {
            abort(501);
        }

        return true;
    }
}
