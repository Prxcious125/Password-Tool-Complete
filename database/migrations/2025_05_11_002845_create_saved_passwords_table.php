<?php


// database/migrations/2025_05_11_002845_create_saved_passwords_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('saved_passwords', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('platform');
    $table->string('account_identifier');
    $table->string('password');
    $table->string('purpose')->nullable();
    $table->integer('strength')->default(0);
    $table->timestamps();
});
    }

    public function down()
    {
        Schema::dropIfExists('saved_passwords');
    }
};