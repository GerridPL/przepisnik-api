<?php

declare(strict_types=1);

namespace App\Validator;

use App\Exception\FieldLengthException;

class StringValidator
{
    /**
     * @throws FieldLengthException
     */
    public static function length(string $fieldToValidate, int $length): void
    {
        if (strlen($fieldToValidate) > $length)
        {
            throw new FieldLengthException("Too many characters in the field.");
        }
    }
}
