<?php

use Botble\ACL\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('ec_option_value', function (Blueprint $table) {
            $table->longText('comment')->nullable()->after('affect_type');
            $table->integer('value_type')->default(0)->nullable()->after('affect_type');
        });
    }

    public function down(): void
    {
        Schema::table('ec_option_value', function (Blueprint $table) {
            $table->dropColumn('comment');
            $table->dropColumn('value_type');
        });
    }
};
