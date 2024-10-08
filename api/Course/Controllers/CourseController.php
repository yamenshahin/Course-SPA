<?php

namespace Course\Controllers;

use Utils\Database;

class CourseController
{
    /**
     * Retrieves all courses from the database.
     *
     * @return array An array of courses. Each course is an associative array
     *
     * @throws \PDOException If there's a problem with the query
     */
    public function getAll(): array
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            // SQL query to retrieve courses with main category names
            $sql = 'SELECT
                c.id,
                c.name,
                c.description,
                c.preview,
                cc.name AS main_category_name,
                c.created_at,
                c.updated_at
            FROM
                course c
            LEFT JOIN
                category cc ON c.category_id = cc.id;';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            http_response_code(500); // Set appropriate HTTP status code
            return ['message' => 'Internal Server Error' . $e->getMessage()];
        }
    }

    /**
     * Retrieves a course from the database by its ID.
     *
     * @param string $id The ID of the course to retrieve
     *
     * @return array|null The course with the given ID, or null if no such course exists
     *
     * @throws \PDOException If there's a problem with the query
     */
    public function getById(string $id): ?array
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "SELECT * FROM course WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            http_response_code(500); // Set appropriate HTTP status code
            return ['message' => 'Internal Server Error' . $e->getMessage()];
        }
    }
}
