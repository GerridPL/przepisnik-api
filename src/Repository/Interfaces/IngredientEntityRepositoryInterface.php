<?php

declare(strict_types=1);

namespace App\Repository\Interfaces;

use App\Entity\IngredientEntity;
use App\Exception\ObjectNotFoundException;
use Doctrine\ORM\NonUniqueResultException;

interface IngredientEntityRepositoryInterface extends BasicEntityRepositoryInterface
{
    public function persist(IngredientEntity $ingredientEntity): void;

    /**
     * @throws NonUniqueResultException
     * @throws ObjectNotFoundException
     */
    public function findOneById(int $id): IngredientEntity;

    /** @throws ObjectNotFoundException */
    public function findOrFail(int $id): IngredientEntity;

    /** @throws ObjectNotFoundException */
    public function removeById(int $id): void;
}
