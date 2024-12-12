<?php
return [
    'auth_mode' => 'oauth2',
    'authorizationRequestUrl' => 'https://appcenter.intuit.com/connect/oauth2',
    'tokenEndPointUrl' => 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
    'client_id' => env('QUICKBOOKS_CLIENT_ID', 'ABgnSqAj3KSuo3tF7oDt9cvpbJqM2NR5k8Ppy0P5PheADjMKuQ'),
    'client_secret' => env('QUICKBOOKS_CLIENT_SECRET', 'T8Wm34Z6bjNBo9ehQhn8tNWD95m5n1cY4RbMilGU'),
    'oauth_scope' => env('QUICKBOOKS_OAUTH_SCOPE', 'com.intuit.quickbooks.accounting openid profile email phone address'),
    'oauth_redirect_uri' => env('QUICKBOOKS_REDIRECT_URI', 'https://www.strapstudios.com/admin/quickbooks/callback'),
    'base_url' => env('QUICKBOOKS_BASE_URL', 'development'),
    'QUICKBOOKS_config_base_url' => env('QUICKBOOKS_CONFIG_STORE_BASE_URL', 'https://sandbox-quickbooks.api.intuit.com'),
    'realm_id' => env('QUICKBOOKS_REALM_ID','123146222308824'),
    'default_email' => env('QUICKBOOKS_DEFAULT_EMAIL','admin@strapstudios.com'),
    'default_tax_id' => env('QUICKBOOKS_DEFAULT_TAX_ID', '6')
];

