<?php

namespace Api\Controllers;

use Category\Controllers\CategoryController;
use Course\Controllers\CourseController;

class ApiController
{
    /**
     * Handle category requests.
     *
     * @param string $method
     * @param array $path
     */
    public function handleCategoryRequest($method, $path)
    {
        $controller = new CategoryController();
        switch ($method) {
            case 'GET':
                $response = !empty($path[1]) ? $controller->getById($path[1]) : $controller->getAll();
                if ($response === null && !empty($path[1])) {
                    $this->sendResponse(404, 'Category not found');
                }
                $this->sendResponse(200, $response);
                break;
            default:
                $this->sendResponse(405, 'Method not allowed');
        }
    }

    /**
     * Handle course requests.
     *
     * @param string $method
     * @param array $path
     */
    public function handleCourseRequest($method, $path)
    {
        $controller = new CourseController();
        switch ($method) {
            case 'GET':
                $response = !empty($path[1]) ? $controller->getById($path[1]) : $controller->getAll();
                if ($response === null && !empty($path[1])) {
                    $this->sendResponse(404, 'Course not found');
                }
                $this->sendResponse(200, $response);
                break;
            default:
                $this->sendResponse(405, 'Method not allowed');
        }
    }

    /**
     * Handle courses by category requests.
     *
     * @param string $method
     * @param array $path
     */
    public function handleCoursesByCategoryRequest($method, $path)
    {
        if (empty($path[1])) {
            $this->sendResponse(400, 'Category ID is required');
        }

        $controller = new CourseController();
        switch ($method) {
            case 'GET':
                $response = $controller->getAllCoursesByCategoryId($path[1]);
                $this->sendResponse(200, $response);
                break;
            default:
                $this->sendResponse(405, 'Method not allowed');
        }
    }

    /**
     * Send HTTP response.
     *
     * @param int $statusCode
     * @param mixed $message
     */
    public function sendResponse($statusCode, $message)
    {
        http_response_code($statusCode);
        echo json_encode(is_array($message) ? $message : ['message' => $message]);
        exit;
    }
}
