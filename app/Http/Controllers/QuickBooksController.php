<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use GuzzleHttp\Client;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Core\OAuth\OAuth2\OAuth2AccessToken;
use QuickBooksOnline\API\Exception\SdkException;
use QuickBooksOnline\API\Facades\OAuth2;
use QuickBooksOnline\API\Data\IPPCustomer;
use QuickBooksOnline\API\Data\IPPInvoice;
use QuickBooksOnline\API\Data\IPPLine;
use QuickBooksOnline\API\Data\IPPItem;
use Illuminate\Support\Facades\Session;

class QuickBooksController extends Controller
{

    public function qbauthorize()
    {
        if (session()->has('accessTokenKey')) {
            $accessTokenKey = session('accessTokenKey');
            $refreshTokenKey = session('refreshTokenKey');
            return $refreshTokenKey;
        } else {
            $dataService = DataService::Configure([
                'auth_mode' => 'oauth2',
                'ClientID' => 'ABgnSqAj3KSuo3tF7oDt9cvpbJqM2NR5k8Ppy0P5PheADjMKuQ',
                'ClientSecret' => 'T8Wm34Z6bjNBo9ehQhn8tNWD95m5n1cY4RbMilGU',
                'RedirectURI' => 'https://www.strapstudios.com/admin/quickbooks/callback',
                'scope' => 'com.intuit.quickbooks.accounting',
                'baseUrl' => 'production', // or 'production'
            ]);

            $authorizationUrl = $dataService->getOAuth2LoginHelper()->getAuthorizationCodeURL();

            return redirect($authorizationUrl);
        }
    }

    public function callback(Request $request)
    {
        $dataService = DataService::Configure([
            'auth_mode' => 'oauth2',
            'ClientID' => 'ABgnSqAj3KSuo3tF7oDt9cvpbJqM2NR5k8Ppy0P5PheADjMKuQ',
            'ClientSecret' => 'T8Wm34Z6bjNBo9ehQhn8tNWD95m5n1cY4RbMilGU',
            'RedirectURI' => 'https://www.strapstudios.com/admin/quickbooks/callback',
            'scope' => 'com.intuit.quickbooks.accounting',
            'baseUrl' => 'development', // or 'production'
        ]);

        $authorizationCode = $request->query('code');
        $realmId = $request->query('realmId');

        try {
            $accessToken = $dataService->getOAuth2LoginHelper()->exchangeAuthorizationCodeForToken($authorizationCode, $realmId);

            $accessTokenKey = $accessToken->getAccessToken();
            $refreshTokenKey = $accessToken->getRefreshToken();

            // Save the tokens to the session
            session(['accessTokenKey' => $accessTokenKey, 'refreshTokenKey' => $refreshTokenKey]);

            return $accessTokenKey;
        } catch (OAuthException $e) {
            // Handle authorization errors
            // ...
        }
    }

}
