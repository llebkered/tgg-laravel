<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Roles for the admin check (AdminAccessMiddleware needs users.role_id and an
 * 'admin' role). The live database already has these from the old Voyager
 * admin, so only what's missing is added.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('display_name');
                $table->timestamps();
            });
        }

        if (! Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('role_id')->nullable()->after('id')->constrained('roles');
            });
        }

        // The same roles Voyager created
        foreach (['admin' => 'Administrator', 'user' => 'Normal User'] as $name => $displayName) {
            if (! DB::table('roles')->where('name', $name)->exists()) {
                DB::table('roles')->insert([
                    'name' => $name,
                    'display_name' => $displayName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        // Left in place: the live database had these before this migration,
        // so dropping them would lose its data.
    }
};
