<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlatformToSavedPasswordsTable extends Migration
{
    public function up()
    {
        Schema::table('saved_passwords', function (Blueprint $table) {
            $table->string('platform')->after('user_id');
            $table->string('account_identifier')->after('platform');
        });
    }

    public function down()
    {
        Schema::table('saved_passwords', function (Blueprint $table) {
            $table->dropColumn(['platform', 'account_identifier']);
        });
    }
}