<?php

declare(strict_types=1);

namespace App\Helper;

use App\Exception\RequiredFieldNotProvidedException;
use Symfony\Component\HttpFoundation\InputBag;

class InputBagHelper
{
    /** @throws RequiredFieldNotProvidedException */
    public static function getParameterOrFail(InputBag $data, string $key): string
    {
        if (!$data->has($key)) {
            throw new RequiredFieldNotProvidedException("$key field is required");
        }

        return (string)($data->get($key));
    }
}
