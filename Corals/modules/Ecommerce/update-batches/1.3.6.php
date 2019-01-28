<?php

// use rating from Corals Utility module

// move rating permissions from Ecommerce to Utility

$ecommerceRatingPermission = \Corals\User\Models\Permission::query()->where('name', 'Ecommerce::rating.create')->first();
$utilityRatingPermission = \Corals\User\Models\Permission::query()->where(['name' => 'Utility::rating.create'])->first();

if ($ecommerceRatingPermission && $utilityRatingPermission) {
    try {
        \DB::table('role_has_permissions')->where('permission_id', $ecommerceRatingPermission->id)->update([
            'permission_id' => $utilityRatingPermission->id
        ]);

        $ecommerceRatingPermission->delete();
    } catch (\Exception $exception) {

    }

}

// use wishlist from Corals Utility module

// move wishlist permissions from Ecommerce to Utility

$ecommerceWishlistPermission = \Corals\User\Models\Permission::query()->where('name', 'Ecommerce::my_wishlist.access')->first();
$utilityWishlistPermission = \Corals\User\Models\Permission::query()->where(['name' => 'Utility::my_wishlist.access'])->first();

if ($ecommerceWishlistPermission && $utilityWishlistPermission) {
    try {
        \DB::table('role_has_permissions')->where('permission_id', $ecommerceWishlistPermission->id)->update([
            'permission_id' => $utilityWishlistPermission->id
        ]);

        $ecommerceWishlistPermission->delete();
    } catch (\Exception $exception) {

    }
}

if (schemaHasTable('ecommerce_wishlists') && schemaHasTable('wishlists')) {
    $productClass = \Corals\Modules\Ecommerce\Models\Product::class;

    //clean up old ecommerce_wishlists table
    \DB::table('ecommerce_wishlists')
        ->leftJoin('users', 'user_id', '=', 'users.id')
        ->whereNull('users.id')
        ->delete();

    \DB::table('ecommerce_wishlists')
        ->leftJoin('ecommerce_products', 'product_id', '=', 'ecommerce_products.id')
        ->whereNull('ecommerce_products.id')
        ->delete();

    \DB::table('ecommerce_wishlists')->orderBy('created_at')->chunk(100, function ($oldRecords) use ($productClass) {
        $newRecords = [];

        foreach ($oldRecords as $record) {
            $newRecords[] = [
                'user_id' => $record->user_id,
                'wishlistable_id' => $record->product_id,
                'wishlistable_type' => $productClass,
                'created_by' => $record->created_by,
                'updated_by' => $record->updated_by,
                'created_at' => $record->created_at,
                'updated_at' => $record->updated_at
            ];
        }

        \DB::table('utility_wishlists')->insert($newRecords);
    });

    \Schema::dropIfExists('ecommerce_wishlists');
}

\DB::table('ratings')->orderBy('created_at')->chunk(100, function ($oldRecords) {
    $newRecords = [];

    foreach ($oldRecords as $record) {
        $newRecords[] = [
            'rating' => $record->rating,
            'title' => $record->title,
            'body' => $record->body,
            'reviewrateable_id' => $record->reviewrateable_id,
            'reviewrateable_type' => $record->reviewrateable_type,
            'author_id' => $record->author_id,
            'author_type' => $record->author_type,
            'created_at' => $record->created_at,
            'updated_at' => $record->updated_at
        ];
    }

    \DB::table('utility_ratings')->insert($newRecords);
});

\Schema::dropIfExists('ratings');