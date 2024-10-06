<?php

namespace Course\Models;

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

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getImagePreview()
    {
        return $this->imagePreview;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }
    
    // TODO: Add methods for database interaction (CRUD) as needed
}
