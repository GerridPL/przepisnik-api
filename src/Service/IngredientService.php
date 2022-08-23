<?php

declare(strict_types=1);

namespace App\Service;

use App\DataProvider\Interfaces\IngredientDataProviderInterface;
use App\DTO\Interfaces\IngredientDTOInterface;
use App\Exception\FieldLengthException;
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
}
