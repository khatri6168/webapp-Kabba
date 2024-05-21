<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {

            $table->string('company', 120)->nullable()->after('name');
            $table->string('tax_id', 120)->nullable()->after('company');
            $table->string('phone_2', 60)->after('phone');
            $table->after('address', function ($table) {
                $table->string('zipcode', 60)->nullable();
                $table->string('city', 60)->nullable();
                $table->string('state', 60)->nullable();
                $table->string('country', 60)->nullable();
                $table->string('delivery_name', 120)->nullable();
                $table->string('delivery_address', 120)->nullable();
                $table->string('delivery_zipcode', 60)->nullable();
                $table->string('delivery_city', 60)->nullable();
                $table->string('delivery_state', 60)->nullable();
                $table->string('delivery_country', 60)->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('company');
            $table->dropColumn('tax_id');
            $table->dropColumn('phone_2');
            $table->dropColumn('zipcode');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('country');
            $table->dropColumn('delivery_name');
            $table->dropColumn('delivery_address');
            $table->dropColumn('delivery_zipcode');
            $table->dropColumn('delivery_city');
            $table->dropColumn('delivery_state');
            $table->dropColumn('delivery_country');
        });
    }
};
