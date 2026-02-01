<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if user exists to avoid duplicates
        if (!DB::table('users')->where('email', 'superadmin@cellario.com')->exists()) {
            DB::table('users')->insert([
                'name' => 'Super Admin',
                'email' => 'superadmin@cellario.com',
                'password' => Hash::make('password123'),
                'role' => 'Admin',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->where('email', 'superadmin@cellario.com')->delete();
    }
};
