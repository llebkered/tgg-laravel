<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Media Library 9+ stores generated conversions in their own column.
     * The original media migration predates it, so add it when missing and
     * move any values still held in custom_properties across.
     */
    public function up(): void
    {
        if (Schema::hasColumn('media', 'generated_conversions')) {
            return;
        }

        Schema::table('media', function (Blueprint $table) {
            $table->json('generated_conversions')->nullable()->after('custom_properties');
        });

        DB::table('media')->orderBy('id')->each(function ($media) {
            $customProperties = json_decode($media->custom_properties, true) ?: [];
            $generatedConversions = $customProperties['generated_conversions'] ?? [];
            unset($customProperties['generated_conversions']);

            DB::table('media')->where('id', $media->id)->update([
                'generated_conversions' => json_encode((object) $generatedConversions),
                'custom_properties' => json_encode((object) $customProperties),
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn('generated_conversions');
        });
    }
};
