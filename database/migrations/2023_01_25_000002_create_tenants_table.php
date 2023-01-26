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
        Schema::create('tenants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('status');
            $table->string('name')->unique();
            $table->string('domain')->unique();
            $table->string('database')->unique();
            $table->string('image')->nullable();
            $table->json('system_settings')->nullable();
            $table->json('settings')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->uuid('subscription_id');
            $table->uuid('tenant_request_id')->nullable();

            $table->index('name');
            $table->index('domain');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenants');
    }
};
