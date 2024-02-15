<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->smallInteger('level')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletesTz(); //* tambah softdelete
        });
        //* tambah default user
        DB::table('users')->insert([
           [ 'name' => 'administrator',
            'email' => 'admin@gmail.com',
            'level' => 1,
            'password' => Hash::make('123456')],
           [ 'name' => 'petugas',
            'email' => 'petugas@gmail.com',
            'level' => 0,
            'password' => Hash::make('123456')]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
