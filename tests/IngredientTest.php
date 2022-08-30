<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\IngredientEntity;
use App\Exception\ObjectNotFoundException;

class IngredientTest extends DatabaseDependantTestCase
{
    /** @test */
    public function a_ingredient_entity_record_can_be_created_in_database(): void
    {
        // Setup
        $ingredientEntity = new IngredientEntity('Milk');
        $ingredientEntity->setName('Water');
        $this->entityManager->persist($ingredientEntity);

        // Do something
        $this->entityManager->flush();

        $ingredientRepository = $this->entityManager->getRepository(IngredientEntity::class);
        $storedIngredient = $ingredientRepository->findOneById(1);

        // Make assertions
        $this->assertEquals('Water', $storedIngredient->getName());
        $this->assertEquals('1', $storedIngredient->getId());
        $this->assertNotNull($storedIngredient->getCreatedAt());
        $this->assertNotNull($storedIngredient->getUpdatedAt());
    }

    /** @test */
    public function a_ingredient_entity_record_can_be_removed_from_database(): void
    {
        // Setup
        $ingredientEntity = new IngredientEntity('Milk');
        $this->entityManager->persist($ingredientEntity);

        // Do something
        $this->entityManager->flush();

        $ingredientRepository = $this->entityManager->getRepository(IngredientEntity::class);

        $ingredientRepository->removeById(1);
        $this->entityManager->flush();

        try {
            $storedIngredient = $ingredientRepository->findOneById(1);
        } catch (ObjectNotFoundException $e)
        {
            $storedIngredient = null;
        }

        // Make assertions
        $this->assertNull($storedIngredient);
    }
}
