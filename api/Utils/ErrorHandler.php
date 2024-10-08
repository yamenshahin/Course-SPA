<?php

namespace Utils;

class ErrorHandler
{
    /**
     * Handles and logs exceptions, returning a custom message for securtiy.
     *
     * @param \PDOException $e
     * 
     * @return array The custom error message array.
     */
    public function handleException(\PDOException $e): array
    {
        // Log the exception message for debugging purposes.
        error_log($e->getMessage());

        return [ 'message' => 'Internal Server Error: A problem occurred while processing your request.' ];
    }
}
