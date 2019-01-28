<?php

namespace Corals\Modules\Directory\database\migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectoryListingsClaimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directory_listings_claim', function (Blueprint $table) {
            $table->increments('id');
            $table->text('brief_desctiption')->nullable();
            $table->enum('status', ['pending', 'approved', 'declined'])->default('pending');
            $table->unsignedInteger('listing_id')->index();
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('listing_id')->references('id')->on('directory_listings')->onDelete('cascade')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directory_listings_claim');
    }
}
