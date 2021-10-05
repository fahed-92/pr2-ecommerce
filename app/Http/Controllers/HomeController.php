<?php

namespace App\Http\Controllers;

use App\Jobs\SaveUSers;
use App\Jobs\sendMail;
use App\Jobs\SendMails;
use App\Jobs\UploadVideo;
use App\Models\Data;
use App\Models\MainCategory;
use App\Models\Slider;
use App\Models\SubCategory;
use App\Models\Winner;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //  $this->middleware('auth');
    }

    public function home(){
        $data=[];
        $data['sliders'] = Slider::get(['photo']);
         $data['categories'] = MainCategory::select('id', 'slug' ,'name')->
with(['subCategories'=>function($q){
    $q->select('id','name','category_id','slug')->with(['childrens'=>function($qq){
        $qq->select('id', 'parent_id', 'slug');
        $qq->with(['childrens' => function ($qq) {
            $qq->select('id', 'parent_id', 'slug');
        }]);
    }])->get();
//    $q;
       }])
->get();
        return view('front.home',$data);
    }


    public function sendSMS($to, $message)
    {
        $accountSid = env('TWILIO_ACCOUNT_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_NUMBER');
        try {
            $client = new Client($accountSid, $authToken);
            $client->messages->create(
                $to, [
                    "body" => $message,
                    "from" => $twilioNumber,
                ]
            );
            Log::info('Message sent to ' . $twilioNumber);
        } catch (TwilioException $e) {
            dd($e);
            Log::error(
                'Could not send SMS notification.' .
                ' Twilio replied with: ' . $e
            );
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function sendMails()
    {

        $emails = Data::chunk(50,function($data){
               dispatch(new SendMails($data));
        });


        return 'will send in back ground can do any other things';
    }



    public function createOffer(){

          $users = User::select('id','name')->get();
        return view('createOffer',compact('users'));
    }








    public function saveOffer(Request $request){

        dispatch(new SaveUSers($request -> all()));
        return 'success';
    }




    public function getVideo(){

        return view('createVideo');
    }


    public function upload(Request $request){

        dispatch(new UploadVideo($request -> all()));

        return 'success';
        //Winner::create(['file' => $path]);
    }












}
