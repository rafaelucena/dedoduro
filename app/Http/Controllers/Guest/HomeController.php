<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Models\Blog;
use App\Http\Models\Contact;
use App\Http\Models\ContactType;
use App\Http\Models\Subscriber;
use App\Http\Models\Persona;
use App\Jobs\SendSubscriptionVerificationEmail;
use App\Listeners\EmailSubscribedListener;
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
        /* @var Persona $persona */
        $persona = $this->em->getRepository(Persona::class)->find(2);
        /* @var Politician $politician */
        $politician = $persona->getPolitician();
        /* @var PoliticianRole $role */
        $role = $politician->getRole();
        /* @var Party $party */
        $party = $politician->getParty();
        /* @var News[] $news */
        $news = $persona->getNews();

        $ninja = new \stdClass();
        $ninja->info = [
            'image' => 'storage/'. $persona->image,
//            'image' => 'assets/images/uploads/avatar/avatar-195x195.png',
            'shortName' => $persona->shortName,
            'longDesc' => $persona->description,
            'roleName' => $role->name,
            'partyName' => $party->shortName,
        ];
        $ninja->details = [
            'Nome' => $persona->firstName,
            'Sobrenome' => $persona->lastName,
            'Partido' => $party->fullName,
        ];
        $ninja->news = [];
        foreach ($news as $eachNews) {
            $ninja->news[] = [
                'Title' => $eachNews->title,
                'Source' => $eachNews->getSource()->name,
                'Url' => $eachNews->url,
                'Published' => $eachNews->publishedAt,
            ];
        }

        return view('guest/home', [
            'ninja' => $ninja,
            'persona' => $persona,
            'role' => $role,
        ]);
//        $blogs = $this->em->getRepository(Blog::class)->findBy(
//            ['isActive' => true],
//            ['createdAt' => 'DESC']
//        );
//        $blogs = Blog::active()->orderBy('created_at', 'desc')
//                            ->simplePaginate(app('global_settings')[2]->settingValue);
//        return view('guest/home', ['blogs' => $blogs]);
    }

    protected function search()
    {
        return view('guest/search', [
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

        return view('guest/contact', [
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
