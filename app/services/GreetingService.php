<?php

namespace App\Services;

class GreetingService
{
    /**
     * Return a greeting message
     *
     * @param string $name
     * @return string
     */
    public function greet($name)
    {
        return "Hello, {$name}!";
    }
}







