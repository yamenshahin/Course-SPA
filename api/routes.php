<?php

use Api\Controllers\ApiController;

// Set response header
header('Content-Type: application/json');

// Initialize the controller
$apiController = new ApiController();

// Get the request path and method
$path = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$method = $_SERVER['REQUEST_METHOD'];

// Define valid resources
$validPaths = ['categories', 'courses', 'courses_by_category'];

// Validate the requested path
if (!in_array($path[0], $validPaths)) {
    sendResponse(405, 'This route does not exist');
    exit;
}

// Route handling
try {
    switch ($path[0]) {
        case 'categories':
            $apiController->handleCategoryRequest($method, $path);
            break;
        case 'courses':
            $apiController->handleCourseRequest($method, $path);
            break;
        case 'courses_by_category':
            $apiController->handleCoursesByCategoryRequest($method, $path);
            break;
    }
} catch (\Throwable $th) {
    $apiController->sendResponse(500, $th->getMessage());
}
