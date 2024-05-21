<?php

use Botble\ACL\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('ec_orders', function (Blueprint $table) {
            $table->longText('signed_terms_html')->nullable()->comment('full html when customer signed terms')->after('terms_signed');
            $table->longText('global_terms')->nullable()->comment('backup version of terms at the time of customer signature')->after('signed_terms_html');
            $table->longText('signature_block')->nullable()->comment('backup version of terms at the time of customer signature')->after('global_terms');
            $table->longText('product_terms')->nullable()->comment('backup version of terms at the time of customer signature')->after('signature_block');
        });
    }

    public function down(): void
    {
        Schema::table('ec_orders', function (Blueprint $table) {
            $table->dropColumn('signed_terms_html');
            $table->dropColumn('global_terms');
            $table->dropColumn('signature_block');
            $table->dropColumn('product_terms');
        });
    }
};
