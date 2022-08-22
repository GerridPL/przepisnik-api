<?php

declare(strict_types=1);

namespace App\DataProvider\Interfaces;

use App\Exception\ObjectNotFoundException;
use App\Model\Ingredient;

interface IngredientDataProviderInterface extends BasicDataProviderInterface
{
    public function persist(Ingredient $ingredient): void;

    /** @throws ObjectNotFoundException */
    public function findOneById(int $id): Ingredient;

    /** @throws ObjectNotFoundException */
    public function findOrFail(int $id): Ingredient;

    /** @throws ObjectNotFoundException */
    public function removeById(int $id): void;
}
