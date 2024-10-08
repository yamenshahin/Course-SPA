<?php

namespace Course\Models;

use Utils\Database;

/**
 * This for demontor purposes, as we dont do CURD oprtion except read.
 */
class Course
{
    private string $id;
    private string $name;
    private string $description;
    private string $preview;
    private string $categoryId;

    public function __construct(string $id, string $name, string $description, string $preview, string $categoryId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->preview = $preview;
        $this->categoryId = $categoryId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getname(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getpreview(): string
    {
        return $this->preview;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    /**
     * Inserts the course into the database.
     *
     * @throws PDOException If there's a problem with the query
     */
    public function create(): void
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "INSERT INTO course (id, name, description, image_preview, category_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$this->id, $this->name, $this->description, $this->preview, $this->categoryId]);
        } catch (PDOException $e) {
            // Handle the exception, e.g., log it or throw a custom exception
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Updates the course in the database.
     *
     * @throws PDOException If there's a problem with the query
     */
    public function update(): void
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "UPDATE course SET name = ?, description = ?, image_preview = ?, category_id = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$this->name, $this->description, $this->preview, $this->categoryId, $this->id]);
        } catch (PDOException $e) {
            // Handle the exception, e.g., log it or throw a custom exception
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Fetches a course from the database and returns it as an associative array.
     * If the course does not exist, returns null.
     *
     * @return array|null
     * @throws PDOException If there's a problem with the query
     */
    public function read(): ?array
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "SELECT * FROM course WHERE id = ?";
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
     * Deletes the course from the database.
     *
     * @throws PDOException If there's a problem with the query
     */
    public function delete(): void
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "DELETE FROM course WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$this->id]);
        } catch (PDOException $e) {
            // Handle the exception, e.g., log it or throw a custom exception
            echo "Error: " . $e->getMessage();
        }
    }
}
