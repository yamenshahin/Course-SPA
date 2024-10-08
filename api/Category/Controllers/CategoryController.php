<?php

namespace Category\Controllers;

use Utils\Database;

class CategoryController
{
    /**
     * Retrieves all categories from the database.
     *
     * @return array An array of categories. Each category is an associative array
     *               with the following keys:
     *               - id
     *               - name
     *               - description
     *               - parent_id
     *               - count_of_courses
     *               - created_at
     *               - updated_at
     *
     * @throws \PDOException If there's a problem with the query
     */
    public function getAll(): array
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "SELECT c.id AS id,
                    c.name AS name,
                    c.description AS description,
                    c.parent_id AS parent_id,
                    ccc.count_of_courses AS count_of_courses,
                    c.created_at AS created_at,
                    c.updated_at AS updated_at
                   FROM category c
                   LEFT JOIN category_course_count ccc ON c.id = ccc.category_id
                   ORDER BY name;";
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
     * Retrieves a category from the database by its ID.
     *
     * @param string $id The ID of the category to retrieve
     *
     * @return array|null The category with the given ID, or null if no such
     *                    category exists
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

    public function getAllCoursesByCategoryId(string $categoryId): array
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "SELECT * FROM course WHERE category_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$categoryId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Handle the exception, e.g., log it or throw a custom exception
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}
