<?php

declare(strict_types=1);

namespace App\Model;

use App\Traits\IdModelTrait;
use App\Traits\TimestampModelTrait;
use JMS\Serializer\Annotation\Groups;

class Ingredient
{
    use IdModelTrait, TimestampModelTrait;

    /**
     * @Groups({"ingredient"})
     */
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

}
