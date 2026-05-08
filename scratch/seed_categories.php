<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Article;
use App\Models\Category;

$cats = Article::whereNotNull('category')->distinct()->pluck('category');
foreach($cats as $name) {
    if ($name) {
        Category::firstOrCreate(['name' => $name]);
    }
}
echo "Categories seeded.\n";
