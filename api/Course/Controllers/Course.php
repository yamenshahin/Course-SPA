<?php

namespace Course\Controllers;

use Course\Models\Course;
use Utils\Database;

class CourseController
{
    public function getAllCourses(): array
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "SELECT * FROM courses";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle the exception, e.g., log it or throw a custom exception
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getCourseById(string $id): ?Course
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        try {
            $sql = "SELECT * FROM courses WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return new Course(
                    $result['id'],
                    $result['title'],
                    $result['description'],
                    $result['image_preview'],
                    $result['category_id']
                );
            } else {
                return null;
            }
        } catch (PDOException $e) {
            // Handle the exception, e.g., log it or throw a custom exception
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}