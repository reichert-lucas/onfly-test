<?php

namespace App\Traits;

trait FormRequestCastJsFormData
{
    private function castFormData(array $data, array $boolKeys = [], array $nullKeys = []): array
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $nullKeys, true) && $value === 'null') {
                $data[$key] = null;
            } elseif (in_array($key, $boolKeys, true)) {
                $data[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }
        }

        return $data;
    }
}