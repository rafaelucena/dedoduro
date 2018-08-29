<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Models\Blog;
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

    public function show(Slug $slug)
    {
        die((string)__line__);
    }
}
