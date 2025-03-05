<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Greeting extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        // This tells Laravel to resolve the GreetingService from the container
        return 'greeting';
    }
}
