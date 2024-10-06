<?php

namespace Course\Controllers;

use Course\Models\Course;
use Utils\Database;

class CourseController
{
    /**
     * Retrieves all courses from the database.
     *
     * @return array An array of courses. Each course is an associative array
     *     with the following keys:
     *     - id
     *     - title
     *     - description
     *     - image_preview
     *     - category_id
     *
     * @throws PDOException If there's a problem with the query
     */
    public function getAllCourses(): array
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "SELECT * FROM course";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle the exception, e.g., log it or throw a custom exception
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Retrieves a course from the database by its ID.
     *
     * @param string $id The ID of the course to retrieve
     *
     * @return Course|null The course with the given ID, or null if no such
     *     course exists
     *
     * @throws PDOException If there's a problem with the query
     */
    public function getCourseById(string $id): ?Course
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "SELECT * FROM course WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return new Course(
                    $result['id'],
                    $result['title'],
                    $result['description'],
                    $result['image_preview'],
                    $result['category_id']
                );
            } else {
                return null;
            }
        } catch (PDOException $e) {
            // Handle the exception, e.g., log it or throw a custom exception
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}
