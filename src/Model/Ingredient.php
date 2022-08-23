<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\FieldLengthException;
use App\Traits\IdModelTrait;
use App\Traits\TimestampModelTrait;
use App\Validator\StringValidator;
use JMS\Serializer\Annotation\Groups;

class Ingredient
{
    use IdModelTrait, TimestampModelTrait;

    /**
     * @Groups({"ingredient"})
     */
    private string $name;

    private const MAX_NAME_LENGTH = 100;

    /** @throws FieldLengthException */
    public function __construct(string $name)
    {
        $this->setName($name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    /** @throws FieldLengthException */
    public function setName(string $name): void
    {
        StringValidator::length($name, self::MAX_NAME_LENGTH);
        $this->name = $name;
    }

}
