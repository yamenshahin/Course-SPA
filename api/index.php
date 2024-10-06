<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$categories = new Category\Controllers\CategoryController();
echo json_encode($categories->getAllCategories());