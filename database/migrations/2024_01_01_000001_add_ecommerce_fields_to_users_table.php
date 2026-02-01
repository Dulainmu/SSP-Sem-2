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
        Schema::table('users', function (Blueprint $table) {
            // Add e-commerce fields (skip role - will use separate roles table or current_team_id)
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 20)->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable();
            }
            if (!Schema::hasColumn('users', 'city')) {
                $table->string('city', 100)->nullable();
            }
            if (!Schema::hasColumn('users', 'state')) {
                $table->string('state', 100)->nullable();
            }
            if (!Schema::hasColumn('users', 'postal_code')) {
                $table->string('postal_code', 20)->nullable();
            }
            if (!Schema::hasColumn('users', 'country')) {
                $table->string('country', 100)->default('USA');
            }
            if (!Schema::hasColumn('users', 'profile_image')) {
                $table->string('profile_image')->nullable();
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status', 50)->default('Active');
            }
            if (!Schema::hasColumn('users', 'user_role')) {
                // Use user_role instead of role to avoid conflicts
                $table->string('user_role', 50)->default('Customer');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'phone',
                'address',
                'city',
                'state',
                'postal_code',
                'country',
                'profile_image',
                'email_verified',
                'status'
            ]);
        });
    }
};
