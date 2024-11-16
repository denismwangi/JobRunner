<?php

namespace App\Console;

use Illuminate\Support\Facades\Log;

class BackgroundJobRunner
{
    public static function execute(string $className, string $method, array $parameters = [])
    {
        try {
            if (!class_exists($className)) {
                throw new \Exception("Class {$className} does not exist.");
            }

            // Instantiate the class with the parameters
            $class = new $className(...$parameters);

            if (!method_exists($class, $method)) {
                throw new \Exception("Method {$method} does not exist in class {$className}.");
            }

            // Call the method and capture its result
            $result = call_user_func([$class, $method]);

            // Log success with the result
            Log::info("Background Job Success: {$className}@{$method}", [
                'parameters' => $parameters,
                'result' => $result,
            ]);

            return $result; // Return the result if needed elsewhere
        } catch (\Exception $e) {
            Log::error("Background Job Failed: {$className}@{$method}", [
                'parameters' => $parameters,
                'error' => $e->getMessage(),
            ]);

            throw $e; // Rethrow the exception to handle it upstream
        }
    }
}
