public function getAllReviews() {

        $apiKey = 'AIzaSyDitGtorEewE1g-sRpmuS7cA6PkZvnnMuw';


        $accountId = '';
        $client_id = '756379138996-mcms7lqvp0l3ou86atc2hhjgt61f3ssl.apps.googleusercontent.com';
        $client_secret = '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';
        $refresh_token = 'your_refresh_token'; // Optional if you want to refresh the token
        $locationId = 'ChIJwy050AlmXj4RXWn9-Tu6iFQ';
        $credentialsPath = storage_path('googlereviewservice.json');

        $client = new GoogleClient();
        $client->setAuthConfig($credentialsPath);  // Path to your downloaded JSON key file
        $client->setAccessType('offline');

        // Set the scopes needed for the Google My Business API
        $client->addScope('https://www.googleapis.com/auth/business.manage');

        // Obtain an access token
        $accessToken = $client->fetchAccessTokenWithAssertion();

        $accessToken = $accessToken['access_token'];

        //

        //Get Account ID Start

        /**/
        /*$aclient = new Client();

        $url = 'https://mybusinessaccountmanagement.googleapis.com/v1/accounts';

        try {
            $response = $aclient->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/json',
                ],
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode == 200) {
                return $accounts = json_decode($response->getBody(), true);
                // Extract the accountId from the response as needed
                $accountId = $accounts['accounts'][0]['name'];
                return response()->json(['accountId' => $accountId]);
            } else {
                return response()->json(['error' => 'Unexpected response: ' . $statusCode], $statusCode);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }*/

        //Get Account ID End

        $accountId = '115991126876754164969';


        //Get Location ID

        $client = new Client();

        $url = "https://mybusinessbusinessinformation.googleapis.com/v1/accounts/-/locations?readMask=photo";

        try {
            $response = $client->getHttpClient()->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/json',
                ],
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode == 200) {
                return $locations = json_decode($response->getBody(), true);

                // Extract and return location IDs
                $locationIds = array_column($locations['locations'], 'name');
                return response()->json(['location_ids' => $locationIds]);
            } else {
                return $errorResponse = json_decode($response->getBody(), true);
                return response()->json(['error' => 'Unexpected response: ' . $statusCode], $statusCode);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        //Get Location ID End



        

        /*$url = "https://mybusiness.googleapis.com/v4/accounts/{$accountId}/locations/{$locationId}/reviews";


        try {
            $response = $client->getHttpClient()->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/json',
                ],
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode == 200) {
                $reviews = json_decode($response->getBody(), true);
                // Handle the reviews data as needed
                return response()->json($reviews);
            } else {
                return $errorResponse = json_decode($response->getBody(), true);
                return response()->json(['error' => 'Unexpected response: ' . $statusCode], $statusCode);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }*/







        $url = "https://mybusiness.googleapis.com/v4/accounts/{$accountId}/locations/{$locationId}/reviews";

        try {
            $response = $client->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);

            $reviews = json_decode($response->getBody(), true);

            // Handle the reviews data as needed
            return response()->json($reviews);
        } catch (\Exception $e) {
            // Handle any errors that occur during the API request
            return response()->json(['error' => $e->getMessage()], 500);
        }

















        $url = 'https://mybusiness.googleapis.com/v4/accounts';

        // Create a new Guzzle client
        $gclient = new Client();

        try {
            // Make the GET request with the access token
            $response = $gclient->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/json',
                ],
            ]);


            $statusCode = $response->getStatusCode();

            if ($statusCode == 200) {
                $body = $response->getBody()->getContents();
                $data = json_decode($body, true);
                return response()->json($data);
            } else {
                return response()->json(['error' => "Unexpected status code: $statusCode"], $statusCode);
            }
        } catch (\Exception $e) {
            // Handle exceptions, e.g., connection errors or API errors
            return response()->json(['error' => $e->getMessage()], 500);
        }


        $url = "https://mybusiness.googleapis.com/v4/accounts/{$accountId}/locations/{$locationId}/reviews";

        // Create a new Guzzle client
        $client = new Client();

        try {
            // Make the GET request
            $response = $client->get($url);

            // Get the response body as a string
            $body = $response->getBody()->getContents();

            // Parse the JSON response
            $data = json_decode($body, true);

            // Now $data contains the response data
            // You can do further processing here

            // Return the data or do something with it
            return response()->json($data);
        } catch (\Exception $e) {
            // Handle exceptions, e.g., connection errors
            return response()->json(['error' => $e->getMessage()], 500);
        }

        // Handle the reviews as needed
        dd($reviews);

    }