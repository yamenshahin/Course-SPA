<?php

namespace Category\Controllers;

use Utils\Database;

class CategoryController
{
    /**
     * Retrieves all categories from the database.
     *
     * @return array An array of categories. Each category is an associative array
     *
     * @throws \PDOException If there's a problem with the query
     */
    public function getAll(): array
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = 'SELECT c.id AS id,
                c.name AS name,
                c.description AS description,
                c.parent_id AS parent_id,
                ccc.count_of_courses AS count_of_courses,
                c.created_at AS created_at,
                c.updated_at AS updated_at
                FROM category c
                LEFT JOIN category_course_count ccc ON c.id = ccc.category_id
                ORDER BY name;';
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            http_response_code(500); // Set appropriate HTTP status code
            return ['message' => 'Internal Server Error' . $e->getMessage()];
        }
    }

    /**
     * Retrieves a category from the database by its ID.
     *
     * @param string $id The ID of the category to retrieve
     *
     * @return array|null The category with the given ID, or null if no such category exists
     *
     * @throws \PDOException If there's a problem with the query
     */
    public function getById(string $id): ?array
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "SELECT * FROM category WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            http_response_code(500); // Set appropriate HTTP status code
            return ['message' => 'Internal Server Error' . $e->getMessage()];
        }
    }
}
