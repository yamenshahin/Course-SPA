<?php

use Category\Controllers\CategoryController;
use Course\Controllers\CourseController;

// Set response header
header('Content-Type: application/json');

// Get the request path and method
$path = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$method = $_SERVER['REQUEST_METHOD'];

if ($path[1] != 'categories' && $path[1] != 'courses' && $path[1] != 'courses_by_category') {
    http_response_code(405);
    echo json_encode(['message' => 'This route does not exist']);
    exit;
}

switch ($path[1]) {
    case 'categories':
        if ($method === 'GET') {
            if (!empty($path[2])) { // get category by id
                try {
                    $controller = new CategoryController();
                    $category = $controller->getById($path[2]);

                    if ($category === null) {
                        http_response_code(404);
                        echo json_encode(['message' => 'Category not found']);
                    } else {
                        echo json_encode($category);
                    }
                } catch (\Throwable $th) {
                    // Extract the error message from the returned data
                    $error_message = $th->getMessage();
                    echo json_encode(['message' => $error_message]); // Handle the error gracefully
                }
            } else { // get all categories since there is no id
                try {
                    $controller = new CategoryController();
                    $categories = $controller->getAll();
                    echo json_encode($categories); // Success case
                } catch (\Throwable $th) {
                    // Extract the error message from the returned data
                    $error_message = $th->getMessage();
                    echo json_encode(['message' => $error_message]); // Handle the error gracefully
                }
            }
        } else { // method not allowed
            http_response_code(405);
            echo json_encode(['message' => 'Method not allowed']);
        }
        break;
    case 'courses':
        if ($method === 'GET') {
            if (!empty($path[2])) { // get course by id
                try {
                    $controller = new CourseController();
                    $course = $controller->getById($path[2]);

                    if ($course == null) { // course not found
                        http_response_code(404);
                        echo json_encode(['message' => 'Course not found']);
                    } else {
                        echo json_encode($course);
                    }
                } catch (\Throwable $th) {
                    // Extract the error message from the returned data
                    $error_message = $th->getMessage();
                    echo json_encode(['message' => $error_message]); // Handle the error gracefully
                }
            } else { // get all courses since there is no id
                try {
                    $controller = new CourseController();
                    $courses = $controller->getAll();
                    echo json_encode($courses);
                } catch (\Throwable $th) {
                    // Extract the error message from the returned data
                    $error_message = $th->getMessage();
                    echo json_encode(['message' => $error_message]); // Handle the error gracefully
                }
            }
        } else { // method not allowed
            http_response_code(405);
            echo json_encode(['message' => 'Method not allowed']);
        }
        break;
    case 'courses_by_category':
        if ($method === 'GET') {
            if (!empty($path[2])) { // get all courses since there is no id
                try {
                    $controller = new CourseController();
                    $courses = $controller->getAll();
                    echo json_encode($courses);
                } catch (\Throwable $th) {
                    // Extract the error message from the returned data
                    $error_message = $th->getMessage();
                    echo json_encode(['message' => $error_message]); // Handle the error gracefully
                }
            } else { // get all courses by category id
                try {
                    $controller = new CourseController();
                    $courses = $controller->getAllCoursesByCategoryId($path[2]);
                    echo json_encode($courses);
                } catch (\Throwable $th) {
                    // Extract the error message from the returned data
                    $error_message = $th->getMessage();
                    echo json_encode(['message' => $error_message]); // Handle the error gracefully
                }
            }
        } else { // method not allowed
            http_response_code(405);
            echo json_encode(['message' => 'Method not allowed']);
        }
        break;
    default:
        http_response_code(500);
        echo json_encode(['message' => 'Internal server error']);
        break;
}
