<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('terms_translations')) {
            Schema::create('terms_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->foreignId('terms_id');
                $table->string('title',255)->nullable();
                $table->text('content')->nullable();
                $table->primary(['lang_code', 'terms_id'], 'terms_translations_primary');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('terms_translations');
    }
};
