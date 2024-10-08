<?php

namespace Course\Controllers;

use Utils\Database;

class CourseController
{
    /**
     * Retrieves all courses from the database.
     *
     * @return array An array of courses. Each course is an associative array
     *     with the following keys:
     *     - id
     *     - name
     *     - description
     *     - preview
     *     - main_category_name
     *     - created_at
     *     - updated_at
     *
     * @throws PDOException If there's a problem with the query
     */
    public function getAll(): array
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "SELECT * FROM course";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
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
     * @return array|null The course with the given ID, or null if no such
     *     course exists
     *
     * @throws PDOException If there's a problem with the query
     */
    public function getById(string $id): ?array
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "SELECT * FROM course WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($result) {
                return $result;
            } else {
                return null;
            }
        } catch (\PDOException $e) {
            // Handle the exception, e.g., log it or throw a custom exception
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}
