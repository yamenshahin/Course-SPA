<?php

namespace Category\Models;

use Utils\Database;

/**
 * This for demontor purposes, as we dont do CRUD oprtion except read.
 */
class Category
{
    private string $id;
    private string $name;
    private string $parent;

    public function __construct(string $id, string $name, string $parent = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->parent = $parent;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParent(): ?string
    {
        return $this->parent;
    }

    /**
     * Inserts the category into the database.
     *
     * @throws PDOException If there's a problem with the query
     */
    public function create(): void
    {
        $db = new Database();
        $conn = $db->getConnection();

        try {
            $sql = "INSERT INTO category (id, name, parent) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$this->id, $this->name, $this->parent]);
        } catch (PDOException $e) {
            // Handle the exception, e.g., log it or throw a custom exception
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Updates the category in the database.
     *
     * @throws PDOException If there's a problem with the query
     */
    public function update(): void
    {
        $db = new Database();
        $conn = $db->getConnection();

        try {
            $sql = "UPDATE category SET name = ?, parent = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$this->name, $this->parent, $this->id]);
        } catch (PDOException $e) {
            // Handle the exception, e.g., log it or throw a custom exception
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Fetches a category from the database and returns it as an associative array.
     * If the category does not exist, returns null.
     *
     * @return array|null
     * @throws PDOException If there's a problem with the query
     */
    public function read(): ?array
    {
        $db = new Database();
        $conn = $db->getConnection();

        try {
            $sql = "SELECT * FROM category WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$this->id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle the exception, e.g., log it or throw a custom exception
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Deletes the category from the database.
     *
     * @throws PDOException If there's a problem with the query
     */
    public function delete(): void
    {
        $db = new Database();
        $conn = $db->getConnection();

        try {
            $sql = "DELETE FROM category WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$this->id]);
        } catch (PDOException $e) {
            // Handle the exception, e.g., log it or throw a custom exception
            echo "Error: " . $e->getMessage();
        }
    }
}
