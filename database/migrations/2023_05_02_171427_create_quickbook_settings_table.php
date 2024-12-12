<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quickbook_settings', function (Blueprint $table) {
            $table->id();
            $table->text('quick_books_config_qbo_realm_id')->nullable();
            $table->text('quick_books_api_refresh_token')->nullable();
            $table->text('quick_books_api_access_token')->nullable();
            $table->integer('income_account_ref')->nullable();
            $table->integer('asset_account_ref')->nullable();
            $table->integer('expense_account_ref')->nullable();
            $table->text('company_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quickbook_settings');
    }
};
