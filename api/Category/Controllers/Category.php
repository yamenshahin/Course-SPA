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
     * @throws PDOException If there's a problem with the query
     */
    public function getAllCategories(): array
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "SELECT * FROM categories";
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
     * Retrieves a category from the database by its ID.
     *
     * @param string $id The ID of the category to retrieve
     *
     * @return Category|null The category with the given ID, or null if no such
     *     category exists
     *
     * @throws PDOException If there's a problem with the query
     */
    public function getCategoryById(string $id): ?Category
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "SELECT * FROM categories WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return new Category($result['id'], $result['name'], $result['parent']);
            } else {
                return null;
            }
        } catch (PDOException $e) {
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
            $sql = "SELECT * FROM courses WHERE category_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$categoryId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle the exception, e.g., log it or throw a custom exception
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}
