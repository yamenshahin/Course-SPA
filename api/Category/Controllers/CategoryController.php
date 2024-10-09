<?php

namespace Category\Controllers;

use Utils\Database;
use Utils\ErrorHandler;

class CategoryController
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
     * Retrieves all categories from the database.
     *
     * @return array An array of categories. Each category is an associative array
     * or a custom error message array in case of failure.
     */
    public function getAll(): array
    {
        try {
            $sql = 'SELECT 
                        c.id AS id,
                        c.name AS name,
                        c.description AS description,
                        c.parent_id AS parent_id,
                        ccc.count_of_courses AS count_of_courses,
                        c.created_at AS created_at,
                        c.updated_at AS updated_at
                    FROM 
                        category c
                    LEFT JOIN 
                        category_course_count ccc ON c.id = ccc.category_id
                    ORDER BY 
                        name;';

            $stmt = $this->getDbConnection()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return ErrorHandler::handleException($e);
        }
    }

    /**
     * Retrieves a category from the database by its ID.
     *
     * @param string $id The ID of the category to retrieve.
     *
     * @return array|null The category with the given ID, a custom error message array,
     * or null if no such category exists.
     */
    public function getById(string $id): ?array
    {
        try {
            $sql = "SELECT * FROM category WHERE id = :id";
            $stmt = $this->getDbConnection()->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
        } catch (\PDOException $e) {
            return ErrorHandler::handleException($e);
        }
    }
}
