<?php

use Botble\ACL\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('ec_products', function (Blueprint $table) {
            $table->integer('terms_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ec_products', function (Blueprint $table) {
            $table->dropColumn('terms_id');
        });
    }
};
