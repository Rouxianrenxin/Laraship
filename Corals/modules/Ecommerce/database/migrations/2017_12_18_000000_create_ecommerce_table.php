<?php

namespace Corals\Modules\Ecommerce\database\migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEcommerceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecommerce_brands', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->unique();
            $table->string('slug')->unique()->index();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('is_featured')->default(false);

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('ecommerce_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->string('slug')->unique()->index();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active');
            $table->unsignedInteger('brand_id')->nullable()->index();
            $table->text('properties')->nullable();
            $table->text('shipping')->nullable();
            $table->text('caption')->nullable();
            $table->string('code')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->text('external_url')->nullable();
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('brand_id')->references('id')->on('ecommerce_brands')->onDelete('cascade')->onUpdate('cascade');

        });

        Schema::create('ecommerce_sku', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('regular_price');
            $table->decimal('sale_price')->nullable();
            $table->string('code');
            $table->enum('inventory', ['finite', 'bucket', 'infinite'])->default('infinite')->nullable();
            $table->string('inventory_value')->nullable();
            $table->unsignedInteger('product_id')->index();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('shipping')->nullable();
            $table->integer('allowed_quantity')->default(0);

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('ecommerce_products')->onDelete('cascade')->onUpdate('cascade');
        });


        Schema::create('ecommerce_categories', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->unique();
            $table->string('slug')->unique()->index();
            $table->text('description')->nullable();
            $table->unsignedInteger('parent_id')->nullable()->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('is_featured')->default(false);
            $table->string('external_id')->nullable();
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('ecommerce_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('label');
            $table->integer('display_order')->default(0);
            $table->boolean('use_as_filter')->default(false);
            $table->boolean('required')->default(false);

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('ecommerce_product_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('attribute_id')->index();
            $table->unsignedInteger('product_id')->index();
            $table->boolean('sku_level')->default(false);
            $table->foreign('attribute_id')->references('id')->on('ecommerce_attributes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('ecommerce_products')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('ecommerce_attribute_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attribute_id')->unsigned()->index();
            $table->integer('option_order');
            $table->string('option_value');
            $table->string('option_display');
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->softDeletes();

            $table->foreign('attribute_id')->references('id')->on('ecommerce_attributes')->onUpdate('cascade')->onDelete('cascade');

        });

        Schema::create('ecommerce_sku_options', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sku_id')->index();
            $table->integer('attribute_id')->unsigned()->index()->nullable();

            $table->unsignedInteger('attribute_option_id')->nullable()->index();

            $table->string('string_value', 255)->nullable();
            $table->double('number_value')->nullable();
            $table->text('text_value')->nullable();
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->foreign('attribute_id')->references('id')->on('ecommerce_attributes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('attribute_option_id')->references('id')->on('ecommerce_attribute_options')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sku_id')->references('id')->on('ecommerce_sku')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('ecommerce_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('slug')->unique()->index();
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('ecommerce_category_product', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('ecommerce_products')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('id')->on('ecommerce_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['product_id', 'category_id']);
        });

        Schema::create('ecommerce_product_tag', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('ecommerce_products')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('tag_id');
            $table->foreign('tag_id')->references('id')->on('ecommerce_tags')->onDelete('cascade')->onUpdate('cascade');

            $table->unique(['product_id', 'tag_id']);
        });


        //Coupons

        Schema::create('ecommerce_coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique('code');
            $table->enum('type', ['fixed', 'percentage'])->default('fixed');
            $table->integer('uses')->nullable();
            $table->decimal('min_cart_total')->nullable();
            $table->decimal('max_discount_value')->nullable();
            $table->string('value');
            $table->dateTime('start')->nullable();
            $table->dateTime('expiry')->nullable();
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->timestamps();
        });

        //Shipping
        Schema::create('ecommerce_shippings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('priority');
            $table->string('shipping_method');
            $table->decimal('rate')->default(0.0);
            $table->decimal('min_order_total')->default(0.0);
            $table->boolean('exclusive')->default(false);
            $table->string('country')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('ecommerce_coupon_product', function (Blueprint $table) {
            $table->integer('coupon_id')->unsigned()->index();
            $table->integer('product_id')->unsigned()->index();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('ecommerce_products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('coupon_id')->references('id')->on('ecommerce_coupons')->onUpdate('cascade')->onDelete('cascade');
        });


        Schema::create('ecommerce_coupon_user', function (Blueprint $table) {
            $table->integer('coupon_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('coupon_id')->references('id')->on('ecommerce_coupons')->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecommerce_coupon_product');
        Schema::dropIfExists('ecommerce_coupon_user');
        Schema::dropIfExists('ecommerce_coupons');
        Schema::dropIfExists('ecommerce_shippings');
        Schema::dropIfExists('ecommerce_product_tag');
        Schema::dropIfExists('ecommerce_category_product');
        Schema::dropIfExists('ecommerce_tags');
        Schema::dropIfExists('ecommerce_categories');
        Schema::dropIfExists('ecommerce_sku_options');
        Schema::dropIfExists('ecommerce_sku');
        Schema::dropIfExists('ecommerce_attribute_options');
        Schema::dropIfExists('ecommerce_product_attributes');
        Schema::dropIfExists('ecommerce_attributes');
        Schema::dropIfExists('ecommerce_wishlists');
        Schema::dropIfExists('ecommerce_products');
        Schema::dropIfExists('ecommerce_brands');
    }
}
