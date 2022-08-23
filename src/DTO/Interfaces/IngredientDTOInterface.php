<?php

declare(strict_types=1);

namespace App\DTO\Interfaces;

use App\Exception\FieldLengthException;
use App\Exception\RequiredFieldNotProvidedException;
use App\Model\Ingredient;
use Symfony\Component\HttpFoundation\Request;

interface IngredientDTOInterface
{
    /** @throws RequiredFieldNotProvidedException */
    public static function fromRequest(Request $request): self;

    public function getName(): string;

    /** @throws FieldLengthException */
    public function toModel(): Ingredient;

}
