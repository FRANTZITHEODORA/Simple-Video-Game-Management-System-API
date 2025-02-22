<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            // Προσθήκη της στήλης 'user_id' αν δεν υπάρχει
            if (!Schema::hasColumn('games', 'user_id')) {
                $table->unsignedBigInteger('user_id');  // Προσθήκη user_id
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');  // Σύνδεση με τον πίνακα 'users'
            }

            // Προσθήκη της στήλης 'title' αν δεν υπάρχει
            if (!Schema::hasColumn('games', 'title')) {
                $table->string('title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropForeign(['user_id']);  // Αφαίρεση του foreign key για το user_id
            $table->dropColumn('user_id');  // Αφαίρεση της στήλης user_id
            $table->dropColumn('title');  // Αφαίρεση της στήλης title
        });
    }
};