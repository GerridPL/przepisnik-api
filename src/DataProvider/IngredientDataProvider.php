<?php

declare(strict_types=1);

namespace App\DataProvider;

use App\DataProvider\Interfaces\IngredientDataProviderInterface;
use App\Entity\IngredientEntity;
use App\Mapper\IngredientMapper;
use App\Model\Ingredient;
use App\Repository\Interfaces\IngredientEntityRepositoryInterface;

class IngredientDataProvider implements IngredientDataProviderInterface
{
    private IngredientEntityRepositoryInterface $ingredientEntityRepository;

    public function __construct(IngredientEntityRepositoryInterface $ingredientEntityRepository)
    {
        $this->ingredientEntityRepository = $ingredientEntityRepository;
    }

    public function flush(): void
    {
        $this->ingredientEntityRepository->flush();
    }

    public function persist(Ingredient $ingredient): void
    {
        $ingredientEntity = IngredientMapper::mapModelToEntity($ingredient);

        $this->ingredientEntityRepository->persist($ingredientEntity);
    }

    /** @inheritdoc  */
    public function findOneById(int $id): Ingredient
    {
        $ingredientEntity = $this->ingredientEntityRepository->findOneById($id);

        return IngredientMapper::mapEntityToModel($ingredientEntity);
    }

    /** @inheritdoc  */
    public function findOrFail(int $id): Ingredient
    {
        $ingredientEntity = $this->ingredientEntityRepository->findOrFail($id);

        return IngredientMapper::mapEntityToModel($ingredientEntity);
    }

    /** @inheritdoc  */
    public function removeById(int $id): void
    {
        $this->ingredientEntityRepository->removeById($id);
    }

    /** @inheritdoc  */
    public function findAll(): array
    {
        $ingredientEntities =  $this->ingredientEntityRepository->findAll();

        return IngredientMapper::mapEntitiesToModels($ingredientEntities);
    }
}
