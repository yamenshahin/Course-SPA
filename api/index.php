<?php

require __DIR__ . '/vendor/autoload.php';

$category = new Category\Controllers\Category();
echo $category->get()->message;