<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('clicks', function (Blueprint $table) {
            $table->string('source')->nullable()->default('direct')->after('affiliate_link_id');
        });
    }

    public function down()
    {
        Schema::table('clicks', function (Blueprint $table) {
            $table->dropColumn('source');
        });
    }
};
