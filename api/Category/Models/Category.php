<?php

namespace Category\Models;

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

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getParent()
    {
        return $this->parent;
    }

    // TODO: Add methods for database interaction (CRUD) as needed
}
