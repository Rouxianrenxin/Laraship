<?php

$filesystem = new \Illuminate\Filesystem\Filesystem();

if ($filesystem->exists(public_path('/assets/themes/admin/images/default_product_image.png'))
    && !$filesystem->exists(public_path('/assets/corals/images/default_product_image.png'))) {
    $filesystem->move(public_path('/assets/themes/admin/images/default_product_image.png'), public_path('/assets/corals/images/default_product_image.png'));
}