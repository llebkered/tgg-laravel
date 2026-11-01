<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Variation prices were whole dollars in an integer column, so cents were
     * lost. Hold them as cents instead, in a column renamed price_cents. The
     * rename also marks the conversion as done: if price_cents already exists
     * the prices are cents and must not be multiplied again, even if the
     * migrations table has lost track of this migration.
     * The Variation model converts to and from dollars.
     */
    public function up(): void
    {
        if (Schema::hasColumn('variations', 'price_cents')) {
            return;
        }

        DB::table('variations')->update(['price' => DB::raw('price * 100')]);

        Schema::table('variations', function (Blueprint $table) {
            $table->renameColumn('price', 'price_cents');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('variations', 'price')) {
            return;
        }

        Schema::table('variations', function (Blueprint $table) {
            $table->renameColumn('price_cents', 'price');
        });

        DB::table('variations')->update(['price' => DB::raw('ROUND(price / 100)')]);
    }
};
