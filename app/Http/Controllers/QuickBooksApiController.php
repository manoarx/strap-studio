<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Invoice;
use QuickBooksOnline\API\Data\IPPCustomer;
use QuickBooksOnline\API\Data\IPPInvoiceLine;
use QuickBooksOnline\API\Data\IPPLine;
use QuickBooksOnline\API\Core\OAuth\OAuth2\OAuth2AccessToken;
use QuickBooksOnline\API\Core\OAuth\OAuth2\OAuth2LoginHelper;
use Illuminate\Support\Facades\DB;

class QuickBooksApiController extends Controller
{
    private $client_id;
    private $client_secret;
    private $redirect_uri;
    private $client;
    private $dataService;
    private $accessToken;
    private $refreshToken;

    public function __construct()
    {
        $this->client_id = env('QUICKBOOKS_CLIENT_ID');
        $this->client_secret = env('QUICKBOOKS_CLIENT_SECRET');
        $this->redirect_uri = env('QUICKBOOKS_REDIRECT_URI');

        $this->client = DataService::Configure([
            'auth_mode' => 'oauth2',
            'ClientID' => $this->client_id,
            'ClientSecret' => $this->client_secret,
            'RedirectURI' => $this->redirect_uri,
            'scope' => "com.intuit.quickbooks.accounting",
            'baseUrl' => env('QUICKBOOKS_BASE_URL')
        ]);

        $this->dataService = new DataService($this->client);

        $this->accessToken = $this->getAccessToken();
        $this->refreshToken = $this->getRefreshToken();
    }

    public function handleQuickBooksOAuth(Request $request)
    {
        $code = $request->query('code');
        $realmId = $request->query('realmId');

        $helper = new OAuth2LoginHelper(
            $this->client_id,
            $this->client_secret,
            $this->redirect_uri
        );

        $token = $helper->exchangeAuthorizationCodeForToken(
            $code,
            $realmId
        );

        $this->updateAccessToken($token);

        return redirect()->route('quickbooks.invoices');
    }

    private function getAccessToken()
    {
        $token = DB::table('quickbooks_tokens')->where('id', 1)->first();
        if (!$token) {
            return null;
        }

        $accessToken = new OAuth2AccessToken(
            $token->access_token,
            $token->token_type,
            $token->refresh_token,
            $token->expires_in
        );

        if ($this->isAccessTokenExpired($accessToken)) {
            $accessToken = $this->refreshAccessToken($accessToken);
            $this->updateAccessToken($accessToken);
        }

        return $accessToken;
    }

    private function isAccessTokenExpired($accessToken)
    {
        $expiration = $accessToken->getAccessTokenExpiration();
        return !$expiration || $expiration <= time();
    }

    private function refreshAccessToken($accessToken)
    {
        $helper = new OAuth2LoginHelper(
            $this->client_id,
            $this->client_secret,
            $this->redirect_uri
        );

        $newToken = $helper->refreshTokenWithRefreshToken($accessToken->getRefreshToken());

        return $newToken;
    }

    private function updateAccessToken($accessToken)
    {
        $helper = $this->getOAuth2LoginHelper();
        $oauth2AccessToken = $helper->refreshTokenWithRefreshToken($refresh_token);
        $accessTokenValue = $oauth2AccessToken->getAccessToken();
        $refreshTokenValue = $oauth2AccessToken->getRefreshToken();

        $accessTokenExpiresAt = time() + $oauth2AccessToken->getAccessTokenExpiration();
        $refreshTokenExpiresAt = time() + $oauth2AccessToken->getRefreshTokenExpiration();

        $token = QuickBooksToken::first();
        $token->access_token = $accessTokenValue;
        $token->refresh_token = $refreshTokenValue;
        $token->access_token_expires_at = $accessTokenExpiresAt;
        $token->refresh_token_expires_at = $refreshTokenExpiresAt;
        $token->save();

        return $oauth2AccessToken;
    }
           
}