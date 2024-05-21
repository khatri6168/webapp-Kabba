<?php

use Botble\ACL\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('ec_orders', function (Blueprint $table) {
            $table->string('authorize_customer_id', 50)->nullable()->after('customer_signature');
            $table->string('authorize_customer_payment_id', 50)->nullable()->after('authorize_customer_id');
        });
    }

    public function down(): void
    {
        Schema::table('ec_orders', function (Blueprint $table) {
            $table->dropColumn('authorize_customer_id');
            $table->dropColumn('authorize_customer_payment_id');
        });
    }
};
