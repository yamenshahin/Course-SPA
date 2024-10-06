<?php

namespace Category\Controllers;

use Category\Models\Category;
use Utils\Database;

class CategoryController
{
    /**
     * Retrieves all categories from the database.
     *
     * @return array An array of categories. Each category is an associative array
     *     with the following keys:
     *     - id
     *     - name
     *     - parent
     *
     * @throws \PDOException If there's a problem with the query
     */
    public function getAll(): array
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "SELECT * FROM category";
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
     *     category exists
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
