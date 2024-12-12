<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Carbon\Carbon;
use Auth;
use DateTime;
use DB;
use URL;

class GoogleCalendarController extends Controller
{
    public function googleApiClient(Request $request)
    {
        $credentialsPath = storage_path('credentials.json');
        $client = new Google_Client();
        $client->setApplicationName('Strapstudios');
        $client->setScopes(array(Google_Service_Calendar::CALENDAR));
        $client->setAuthConfig($credentialsPath);
        $client->setAccessType('offline');
        $client->getAccessToken();
        $client->getRefreshToken(); 

        $service = new Google_Service_Calendar($client);

        $event   = new Google_Service_Calendar_Event(array(
            'summary' => 'new testing',
            'location' => '800 Howard St., San Francisco, CA 94103',
            'description' => 'A chance to hear more about Google\'s developer products.',
            'start' => array(
            'dateTime' => '2023-06-28T09:00:00-07:00',
            'timeZone' => 'Asia/Kolkata',
            ),
            'end' => array(
            'dateTime' => '2023-06-28T17:00:00-07:00',
            'timeZone' => 'Asia/Kolkata',
            ),
            'recurrence' => array(
                'RRULE:FREQ=DAILY;COUNT=2'
            ),
            'attendees' => array(),  
            'reminders' => array(
            'useDefault' => FALSE,
            'overrides' => array(
                array('method' => 'email', 'minutes' => 24 * 60),
                array('method' => 'popup', 'minutes' => 10),
            ),
            ),
        ));
        
        $calendarId = 'vg13elo7m6o55vn4e085ubsb1k@group.calendar.google.com';
        //$calendarId = 'c2d04e524443f464bc8113b1d4627fa9691ff92e60bc03d8b02f8edceab83bb0@group.calendar.google.com';
        $event      = $service->events->insert($calendarId, $event);

        return $event->htmlLink;

        // Initialise the client.
        // $client = new Google_Client();
        // // Set the application name, this is included in the User-Agent HTTP header.
        // $client->setApplicationName('Strapstudios');
        // // Set the authentication credentials we downloaded from Google.
        // $credentialsPath = storage_path('credentials.json');
        // $client->setAuthConfig($credentialsPath);
        // // Setting offline here means we can pull data from the venue's calendar when they are not actively using the site.
        // $client->setAccessType("offline");
        // // This will include any other scopes (Google APIs) previously granted by the venue
        // $client->setIncludeGrantedScopes(true);
        // // Set this to force to consent form to display.
        // $client->setApprovalPrompt('force');
        // // Add the Google Calendar scope to the request.
        // $client->addScope(Google_Service_Calendar::CALENDAR);
        // // Set the redirect URL back to the site to handle the OAuth2 response. This handles both the success and failure journeys.
        // $client->setRedirectUri(URL::to('/') . '/oauth2callback');
    }

    public function createEvent(Request $request)
    {
        // Load the API credentials
        $credentialsPath = storage_path('client_id.json');
        $client = new Google_Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope(Google_Service_Calendar::CALENDAR);

        // Authorize and get access token
        $client->setAccessToken($request->session()->get('access_token'));
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            $request->session()->put('access_token', $client->getAccessToken());
        }

        // Create a new Google Calendar event
        $calendarService = new Google_Service_Calendar($client);
        $event = new Google_Service_Calendar_Event([
            'summary' => 'Testimonial',
            'start' => [
                'dateTime' => Carbon\Carbon::now(),
                'timeZone' => 'Asia/Dubai', // Replace with your desired time zone
            ],
            'end' => [
                'dateTime' => Carbon\Carbon::now()->addHour(),
                'timeZone' => 'Asia/Dubai', // Replace with your desired time zone
            ],
        ]);

        $calendarService->events->insert('primary', $event);

        return response()->json(['message' => 'Event created successfully.']);
    }
}
