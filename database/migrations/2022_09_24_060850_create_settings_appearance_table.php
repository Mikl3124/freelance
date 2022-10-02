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
        Schema::create('settings_appearance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('home_image_id')->nullable();
            $table->string('badge_short_text', 20)->default('New');
            $table->string('badge_long_text', 160)->default('Put your badge long text here');
            $table->string('badge_link', 160)->default('#');
            $table->string('primary_link_text', 60)->default('Join us');
            $table->string('primary_link_target', 160)->default('#');
            $table->string('secondary_link_text', 60)->default('Watch video');
            $table->string('secondary_link_target', 160)->default('#');
            $table->longText('custom_hero_section_html')->nullable();
            $table->boolean('show_featured_categories')->default(1);
            $table->boolean('show_bestsellers')->default(1);

            $table->foreign('home_image_id')->references('id')->on('file_manager');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings_appearance');
    }
};
