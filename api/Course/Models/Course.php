<?php

namespace Course\Models;

use Utils\Database;

class Course
{
    private string $id;
    private string $title;
    private string $description;
    private string $imagePreview;
    private string $categoryId;

    public function __construct(string $id, string $title, string $description, string $imagePreview, string $categoryId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->imagePreview = $imagePreview;
        $this->categoryId = $categoryId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImagePreview(): string
    {
        return $this->imagePreview;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function create(): void
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "INSERT INTO courses (id, title, description, image_preview, category_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$this->id, $this->title, $this->description, $this->imagePreview, $this->categoryId]);
        } catch (PDOException $e) {
            // Handle the exception, e.g., log it or throw a custom exception
            echo "Error: " . $e->getMessage();
        }
    }

    public function update(): void
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "UPDATE courses SET title = ?, description = ?, image_preview = ?, category_id = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$this->title, $this->description, $this->imagePreview, $this->categoryId, $this->id]);
        } catch (PDOException $e) {
            // Handle the exception, e.g., log it or throw a custom exception
            echo "Error: " . $e->getMessage();
        }
    }

    public function read(): ?array
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "SELECT * FROM courses WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$this->id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle the exception, e.g., log it or throw a custom exception
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function delete(): void
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "DELETE FROM courses WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$this->id]);
        } catch (PDOException $e) {
            // Handle the exception, e.g., log it or throw a custom exception
            echo "Error: " . $e->getMessage();
        }
    }
}
