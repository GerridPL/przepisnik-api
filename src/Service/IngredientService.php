<?php

declare(strict_types=1);

namespace App\Service;

use App\DataProvider\Interfaces\IngredientDataProviderInterface;
use App\DTO\Interfaces\IngredientDTOInterface;
use App\Exception\FieldLengthException;
use App\Exception\ObjectNotFoundException;
use App\Model\Ingredient;

class IngredientService
{
    private IngredientDataProviderInterface $ingredientDataProvider;

    public function __construct(IngredientDataProviderInterface $ingredientDataProvider)
    {
        $this->ingredientDataProvider = $ingredientDataProvider;
    }

    /** @return Ingredient[] */
    public function index(): array
    {
        return $this->ingredientDataProvider->findAll();
    }

    /** @throws FieldLengthException */
    public function create(IngredientDTOInterface $ingredientDTO): void
    {
        $ingredient = $ingredientDTO->toModel();

        $this->ingredientDataProvider->persist($ingredient);
        $this->ingredientDataProvider->flush();
    }

    /**
     * @throws FieldLengthException
     * @throws ObjectNotFoundException
     */
    public function update(IngredientDTOInterface $ingredientDTO, int $id): void
    {
        $ingredient = $ingredientDTO->toModel();

        $this->ingredientDataProvider->update($ingredient, $id);
        $this->ingredientDataProvider->flush();
    }

    /** @throws ObjectNotFoundException */
    public function delete(int $id): void
    {
        $this->ingredientDataProvider->removeById($id);
        $this->ingredientDataProvider->flush();
    }
}
