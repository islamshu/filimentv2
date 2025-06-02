<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            // نضيف العمود بدلاً من تغييره
            if (!Schema::hasColumn('comments', 'page_or_product')) {
                $table->enum('page_or_product', ['homepage', 'products'])->default('homepage')->after('comment');
            }
        });
    }

    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('page_or_product');
        });
    }
};
