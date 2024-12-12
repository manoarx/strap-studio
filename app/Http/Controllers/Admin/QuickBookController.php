<?php

namespace App\Http\Controllers\Admin;

use App\Http\Traits\QuickBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use QuickBooksOnline\API\DataService\DataService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class QuickBookController extends Controller
{
    use QuickBook;


    public function login(Request $request)
    {

        $tokenCheck =  $this->setNewAccessToken();
        if (!$tokenCheck) {
            $quickBookConfig = self::getConfig();

            $dataService = DataService::Configure(array(
                'auth_mode'     => $quickBookConfig['quick_books_config_auth_mode'],
                'ClientID'      => $quickBookConfig['quick_books_config_client_id'],
                'ClientSecret'  => $quickBookConfig['quick_books_config_client_secret'],
                'RedirectURI'   => $quickBookConfig['quick_books_config_redirect_uri'],
                'scope'         => $quickBookConfig['quick_books_config_scope'],
                'baseUrl'       => $quickBookConfig['quick_books_config_base_url'],
            ));

            $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            $authorizationCodeUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();
            header('Location: ' . $authorizationCodeUrl);
            exit();
        }

        $message = $this->createOrCheckdefaultAccountIds($request->type);
        echo $message;
    }

    public function callback(Request $request)
    {
        try {
            $quickBookConfig = self::getConfig();

            $dataService = DataService::Configure(array(
                'auth_mode'     => $quickBookConfig['quick_books_config_auth_mode'],
                'ClientID'      => $quickBookConfig['quick_books_config_client_id'],
                'ClientSecret'  => $quickBookConfig['quick_books_config_client_secret'],
                'RedirectURI'   => $quickBookConfig['quick_books_config_redirect_uri'],
                'scope'         => $quickBookConfig['quick_books_config_scope'],
                'baseUrl'       => $quickBookConfig['quick_books_config_base_url'],
                'state'         => ''
            ));

            $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            $code = $request->code;
            $realmId = $request->realmId;
            $accessTokenObj = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($code, $realmId);
            $this->setSessionData($accessTokenObj);
            $this->syncToDefaultAccountIds($realmId);
            echo '<script> window.close();</script>';
            die();
        } catch (\Throwable $exception) {
            $errorLog = array(
                'message' => $exception->getMessage(),
                'action'  => 'Quick book API callback',
                'file'    => __FILE__,
                'method'    => __METHOD__,
                'line'    => __LINE__,
            );
            Log::error(json_encode($errorLog));
        }
    }
}
