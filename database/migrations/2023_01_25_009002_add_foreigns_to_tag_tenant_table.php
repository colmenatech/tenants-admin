<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tag_tenant', function (Blueprint $table) {
            $table
                ->foreign('tag_id')
                ->references('id')
                ->on('tags');

            $table
                ->foreign('tenant_id')
                ->references('id')
                ->on('tenants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tag_tenant', function (Blueprint $table) {
            $table->dropForeign(['tag_id']);
            $table->dropForeign(['tenant_id']);
        });
    }
};
