<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickBookSetting extends Model
{
    public $table = 'quickbook_settings';

    public $fillable = [
        'quick_books_config_qbo_realm_id',
        'quick_books_api_refresh_token',
        'quick_books_api_access_token',
        'income_account_ref',
        'asset_account_ref',
        'expense_account_ref',
        'company_name',
    ];
}
