<?php

declare(strict_types=1);

namespace App\Repository\Interfaces;

use App\Entity\IngredientEntity;
use App\Exception\ObjectNotFoundException;

interface IngredientEntityRepositoryInterface extends BasicEntityRepositoryInterface
{
    public function persist(IngredientEntity $ingredientEntity): void;

    /**
     * @throws ObjectNotFoundException
     */
    public function findOneById(int $id): IngredientEntity;

    /** @throws ObjectNotFoundException */
    public function findOrFail(int $id): IngredientEntity;

    /** @throws ObjectNotFoundException */
    public function removeById(int $id): void;
}
