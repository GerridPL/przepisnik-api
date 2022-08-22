<?php

declare(strict_types=1);

namespace App\Helper;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonHelper
{
    public static function serialize($data, array $groups = []): string
    {

        $context = SerializationContext::create();

        if (count($groups) > 0)
        {
            $context->setGroups($groups);
        }

        return SerializerBuilder::create()->build()->serialize($data, 'json', $context);
    }
}
