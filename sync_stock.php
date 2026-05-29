<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$branch = \App\Models\Branch::first();
if ($branch) {
    foreach(\App\Models\Product::all() as $p) { 
        \App\Models\BranchStock::updateOrCreate(
            ['branch_id' => $branch->id, 'stockable_id' => $p->id, 'stockable_type' => get_class($p)], 
            ['stock' => $p->stock]
        ); 
    } 
    foreach(\App\Models\ProductVariation::all() as $v) { 
        \App\Models\BranchStock::updateOrCreate(
            ['branch_id' => $branch->id, 'stockable_id' => $v->id, 'stockable_type' => get_class($v)], 
            ['stock' => $v->stock]
        ); 
    } 
    echo 'Stocks synced successfully!';
} else {
    echo 'No branches found!';
}
