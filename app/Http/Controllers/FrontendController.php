<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ContactForm;
use App\Models\Settings;
use App\Models\Workshops;
use App\Models\Portfolios;
use App\Models\PortfolioVideos;
use App\Models\Services;
use App\Models\ServicePackages;
use App\Models\ServicePackageOptions;
use App\Models\ServicePackageAddons;
use App\Models\StudioRentals;
use App\Models\Order;
use App\Models\OrderItem;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use URL;
use Illuminate\Support\Facades\Notification;
use SMSGlobal\Resource\Sms;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class FrontendController extends Controller
{
    public $settingdetails;
    public function __construct()
    {
        $settings = Settings::pluck('value', 'key');
        $this->settingdetails = $settings;
        \View::share(['settings' => $settings]);
    }

    public function smsTest()
    {

        try {
            $sms = app('smsglobal');
            $response = $sms->sendToOne('971501544994', 'This is a test message.', 'STRAPSTUDIO');
            print_r($response['messages']);
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
            echo "Code: " . $e->getCode() . "\n";
        }
    }

    public function index()
    {
        $services = Services::limit(6)->get();
        $workshops = Workshops::limit(6)->get();
        $portfolios = Portfolios::limit(6)->get();

        $apiKey = 'AIzaSyDitGtorEewE1g-sRpmuS7cA6PkZvnnMuw';
        $placeId = 'ChIJwy050AlmXj4RXWn9-Tu6iFQ';

        $client = new Client();

        $reviews = [];

        do {
            // Make a request to the Google Places API
            $response = $client->get("https://maps.googleapis.com/maps/api/place/details/json", [
                'query' => [
                    'place_id' => $placeId,
                    'key' => $apiKey,
                    'fields' => 'reviews',
                    'sort' => 'newest',
                    'page_token' => isset($nextPageToken) ? $nextPageToken : null, // Use the next page token, if available
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['result']['reviews'])) {
                $reviews = array_merge($reviews, $data['result']['reviews']);
            }

            // Check if there are more pages of reviews
            $nextPageToken = isset($data['next_page_token']) ? $data['next_page_token'] : null;

            // Wait for a short time to avoid OVER_QUERY_LIMIT if needed (optional)
            sleep(2);
        } while ($nextPageToken);

        return view('frontend.index', compact('services','workshops','portfolios','reviews'));
    }

    public function listReviews()
    {
        return view('frontend.googlereviews');
    }

    public function getReviews($option) {
      if ( file_exists('reviews.json') && (filemtime('reviews.json') > strtotime('-'.$option['cache_data_xdays_local'].' days')) ) {
        $result = file_get_contents('reviews.json');
      } else {
        $url = 'https://maps.googleapis.com/maps/api/place/details/json?place_id='.$option['google_maps_review_cid'].'&reviews_sort='.$option['google_reviews_sorting'].'&key='.$option['googlemaps_free_apikey'];
        if (function_exists('curl_version')) {
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          if ( isset($option['your_language_for_tran']) and !empty($option['your_language_for_tran']) ) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Language: '.$option['your_language_for_tran']));
          }
          curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36');
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $result = curl_exec($ch);
          curl_close($ch);
        } else {
          $arrContextOptions=array(
            'ssl' => array(
              'verify_peer' => false,
              'verify_peer_name' => false,
            ),
            'http' => array(
              'method' => 'GET',
              'header' => 'Accept-language: '.$option['your_language_for_tran']."\r\n" .
              "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36\r\n"
            )
          );
          $result = file_get_contents($url, false, stream_context_create($arrContextOptions));
        }
        $fp = fopen('reviews.json', 'w');
        fwrite($fp, $result);
        fclose($fp);
      }
      $data  = json_decode($result, true);
      #echo'<pre>';var_dump($data);echo'</pre>'; // DEV & DEBUG
      $reviews = $data['result']['reviews'];
      $html = '';
      if (!empty($reviews)) {
        if ( isset($option['sort_reviews_by_a_data']) and $option['sort_reviews_by_a_data'] == 'rating' ) {
          array_multisort(array_map(function($element) { return $element['rating']; }, $reviews), SORT_DESC, $reviews);
        } else if ( isset($option['sort_reviews_by_a_data']) and $option['sort_reviews_by_a_data'] == 'time' ) {
          array_multisort(array_map(function($element) { return $element['time']; }, $reviews), SORT_DESC, $reviews);
        }
        $html .= '<div class="review">';
        if (isset($option['show_cname_as_headline']) and $option['show_cname_as_headline'] == true) {
          $html .= '<strong>'.$data['result']['name'].' ';
          if (isset($option['show_stars_in_headline']) and $option['show_stars_in_headline'] == true) {
            for ($i=1; $i <= $data['result']['rating']; ++$i) $html .= '⭐';
            if (isset($option['show_blank_star_till_5']) and $option['show_blank_star_till_5'] == true) for ($i=1; $i <= 5-floor($data['result']['rating']); ++$i) $html .= '☆';
          }
          $html .= '</strong><br>';
        }
        if (isset($option['add_schemaorg_metadata']) and $option['add_schemaorg_metadata'] == true) {
          $html .= '<itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating"><meta itemprop="worstRating" content="1"/><meta itemprop="bestRating" content="5"/>';
          $html .= '<meta itemprop="ratingValue" content="'.$data['result']['rating'].'"/>';
        }
        if (isset($option['show_rule_after_review']) and $option['show_rule_after_review'] == true) $html .= '<hr size="1">';
        foreach ($reviews as $key => $review) {
          if (isset($option['show_not_more_than_max']) and $option['show_not_more_than_max'] > 0 and $key >= $option['show_not_more_than_max']) continue;
          if (isset($option['show_only_if_with_text']) and $option['show_only_if_with_text'] == true and empty($review['text'])) continue;
          if (isset($option['show_only_if_greater_x']) and $review['rating'] <= $option['show_only_if_greater_x']) continue;
          if (isset($option['show_author_of_reviews']) and $option['show_author_of_reviews'] == true and
              isset($option['show_author_avatar_img']) and $option['show_author_avatar_img'] == true) $html .= '<img class="avatar" src="'.$review['profile_photo_url'].'">';
          for ($i=1; $i <= $review['rating']; ++$i) $html .= '⭐';
          if (isset($option['show_blank_star_till_5']) and $option['show_blank_star_till_5'] == true) for ($i=1; $i <= 5-$review['rating']; ++$i) $html .= '☆';
          $html .= '<br>';
          if (isset($option['show_txt_of_the_review']) and $option['show_txt_of_the_review'] == true) $html .= str_replace(array("\r\n", "\r", "\n"), ' ', $review['text']).'<br>';
          if (isset($option['show_author_of_reviews']) and $option['show_author_of_reviews'] == true) $html .= '<small>'.$review['author_name'].' </small>';
          if (isset($option['show_age_of_the_review']) and $option['show_age_of_the_review'] == true) $html .= '<small> '.date($option['dateformat_for_the_age'], $review['time']).'  &mdash; '.$review['relative_time_description'].' </small>';
          if (isset($option['show_rule_after_review']) and $option['show_rule_after_review'] == true) $html .= '<hr style="clear:both" size="1">';
        }
        $html .= '</div>';
      }
      return $html;
    }

    public function verifyemail()
    {
        $user = User::find(Auth::user()->id);

        $token = Str::random(64);

        UserVerify::create([
              'user_id' => $user->id,
              'token' => $token
            ]);

        $verificationUrl = route('user.verify', $token);
        $userName = $user->username;
        $userType = $user->type;

        Mail::to($user->email)->send(new VerifyEmail($verificationUrl,$userName,$userType));

        auth()->logout();

        return view('frontend.verifyemail');
    }

    public function services()
    {
        $services = Services::get();
        return view('frontend.services', compact('services'));
    }

    /*public function checkDate(Request $request) {

        $selecteddate = OrderItem::where('booked_stime',$request->seltime)->first();
        if ($selecteddate) {

            return response()->json(array(
                'exists' => true
            ));

        }else{
            return response()->json(array(
                'exists' => false
            ));
        }

    }*/

    public function servicePackage($slug)
    {
        $service = Services::where('slug',$slug)->first();
        $selectedDates = OrderItem::whereNotNull('booked_stime')->pluck('booked_stime');
        return view('frontend.service_package',compact('service','selectedDates'));
    }

    public function studiorentals()
    {
        $studiorentals = StudioRentals::get();
        return view('frontend.studiorentals', compact('studiorentals'));
    }

    public function workshops()
    {

        return view('frontend.workshops');
    }

    public function workshopDetail($slug)
    {
        $workshop = Workshops::where('slug',$slug)->first();
        return view('frontend.workshop_detail',compact('workshop'));
    }

    public function portfolio()
    {

        return view('frontend.portfolio');
    }

    public function portfolioDetail($slug)
    {
        $portfolio = Portfolios::where('slug',$slug)->first();
        return view('frontend.portfolio_detail',compact('portfolio'));
    }

    public function videos()
    {
        $videos = PortfolioVideos::get();
        return view('frontend.video_detail',compact('videos'));
        //return view('frontend.videos');
    }

    public function videoDetail($slug)
    {
        $video = Portfolios::where('slug',$slug)->first();
        return view('frontend.video_detail',compact('video'));
    }

    public function about()
    {
        $apiKey = 'AIzaSyDitGtorEewE1g-sRpmuS7cA6PkZvnnMuw';
        $placeId = 'ChIJwy050AlmXj4RXWn9-Tu6iFQ';

        $client = new Client();

        $reviews = [];

        do {
        // Make a request to the Google Places API
        $response = $client->get("https://maps.googleapis.com/maps/api/place/details/json", [
            'query' => [
                'place_id' => $placeId,
                'key' => $apiKey,
                'fields' => 'reviews',
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        if (isset($data['result']['reviews'])) {
                $reviews = array_merge($reviews, $data['result']['reviews']);
            }

            // Get the next page token
            $nextPageToken = $data['result']['next_page_token'] ?? null;

            // Wait for a moment to ensure the next page token becomes valid
            if ($nextPageToken) {
                usleep(2000000); // 2 seconds
            }
        } while ($nextPageToken);

        $portfolios = Portfolios::limit(3)->get();
        return view('frontend.about',compact('portfolios','reviews'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function privacypolicy()
    {
        return view('frontend.privacypolicy');
    }

    public function termsofuse()
    {
        return view('frontend.termsofuse');
    }


    public function submitContact(Request $request) {
        $admin_email = (isset($this->settingdetails['contact_form_email']) && $this->settingdetails['contact_form_email'] != '') ? $this->settingdetails['contact_form_email'] : env('ADMIN_EMAIL','info@strapstudios.com');
        // Form validation
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'contact_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'message' => 'required',
         ]);


        ContactForm::create($request->all());


        Mail::send('emails.mail', array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'contact_number' => $request->get('contact_number'),
            'bodymessage' => $request->get('message'),
        ), function($message) use ($request,$admin_email){
            $message->from($request->email);
            //$message->bcc('vinod.rajan@doodletech.ae', 'Strapstudios');
            $message->to($admin_email, 'Admin')->subject($request->get('name'));
        });
        return back()->with('success', 'Thank you for your message, we will get back to you the soonest.');
        //return Redirect::route('thankyou')->with('thankyoumsg', 'Thank you for your message, we will get back to you the soonest.');

    }

    protected function uploadImages($file)
    {
        //$year = Carbon::now()->year;
        $imagePath = "/upload/images/";
        $filename = time().rand(1,50).$file->getClientOriginalName();

        $file = $file->move(public_path($imagePath) , $filename);

        // $sizes = ["300" , "600" , "900"];
        // $url['images'] = $this->resize($file->getRealPath() , $sizes , $imagePath , $filename);
        // $url['thumb'] = $url['images'][$sizes[0]];

        return $filename;
    }

    private function resize($path , $sizes , $imagePath , $filename)
    {
        $images['original'] = $imagePath . $filename;
        foreach ($sizes as $size) {
            $images[$size] = $imagePath . "{$size}_" . $filename;

            Image::make($path)->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($images[$size]));
        }

        return $images;
    }
}
