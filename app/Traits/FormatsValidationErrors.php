<?php

namespace App\Traits;

trait FormatsValidationErrors
{
    public function formatErrors(array $errors)
    {
        $formattedErrors = [];

        foreach ($errors as $key => $message) {
            $keys = explode('.', $key);
            $lastKey = array_pop($keys);

            $temp = &$formattedErrors;
            foreach ($keys as $innerKey) {
                if (!isset($temp[$innerKey])) {
                    $temp[$innerKey] = [];
                }
                $temp = &$temp[$innerKey];
            }
            $temp[$lastKey] = $message[0];
        }

        return $formattedErrors;
    }
}
