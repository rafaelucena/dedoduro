<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Models\Blog;
use App\Http\Models\Persona;
use App\Http\Models\Party;
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

    /**
     * @param Slug $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Slug $slug)
    {
        /* @var Persona $persona */
        $persona = $slug->getPersona();
        /* @var Politician $politician */
        $politician = $persona->getPolitician();
        /* @var PoliticianRole $role */
        $role = $politician->getRole();
        /* @var Party $party */
        $party = $politician->getParty();

        $ninja = new \stdClass();
        $ninja->info = [
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

        return view('guest/politicians/show', [
            'ninja' => $ninja,
            'persona' => $persona,
            'role' => $role,
        ]);
    }
}
