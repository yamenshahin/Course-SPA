<?php

namespace Course\Controllers;

use Utils\Database;
use Utils\ErrorHandler;

class CourseController
{
    /**
     * Gets a database connection.
     *
     * @return \PDO The database connection.
     *
     * @throws \PDOException If there's a problem obtaining the connection.
     */
    private function getDbConnection(): \PDO
    {
        $db = Database::getInstance();
        return $db->getConnection();
    }

    /**
     * Retrieves all courses from the database.
     *
     * @return array An array of courses. Each course is an associative array,
     * or a custom error message array in case of failure.
     */
    public function getAll(): array
    {
        try {
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

            $stmt = $this->getDbConnection()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return ErrorHandler::handleException($e);
        }
    }

    /**
     * Retrieves a course from the database by its ID.
     *
     * @param string $id The ID of the course to retrieve.
     *
     * @return array|null The course with the given ID, a custom error message array,
     * or null if no such course exists.
     */
    public function getById(string $id): ?array
    {
        try {
            $sql = "SELECT * FROM course WHERE id = :id";
            $stmt = $this->getDbConnection()->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
        } catch (\PDOException $e) {
            return ErrorHandler::handleException($e);
        }
    }

    /**
     * Retrieves all courses from the database that belong to the given category
     * or any of its subcategories.
     *
     * @param string $categoryId The ID of the category to retrieve courses from.
     *
     * @return array An array of courses. Each course is an associative array,
     * or a custom error message array in case of failure.
     */
    public function getAllCoursesByCategoryId(string $categoryId): array
    {
        try {
            $sql = 'WITH RECURSIVE category_hierarchy AS (
                        SELECT id, parent_id
                        FROM category
                        WHERE id = :category_id
                        UNION ALL
                        SELECT c.id, c.parent_id
                        FROM category c
                        JOIN category_hierarchy ch ON c.parent_id = ch.id
                    )
                    SELECT co.id, co.name, co.description, co.preview, co.category_id, co.created_at, co.updated_at
                    FROM course co
                    JOIN category_hierarchy ch ON co.category_id = ch.id;';

            $stmt = $this->getDbConnection()->prepare($sql);
            $stmt->execute(['category_id' => $categoryId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return ErrorHandler::handleException($e);
        }
    }

    /**
     * Handles and logs exceptions, returning a custom message.
     *
     * @param \PDOException $e
     * @return array The custom error message array.
     */
    private function handleException(\PDOException $e): array
    {
        // Log the exception message for debugging purposes.
        error_log($e->getMessage());

        // Return a custom error message without stopping script execution.
        return [
            'error' => true,
            'message' => 'Internal Server Error: A problem occurred while processing your request.'
        ];
    }
}
