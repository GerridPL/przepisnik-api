<?php

declare(strict_types=1);

namespace App\Tests\feature;

use App\Entity\IngredientEntity;
use App\Exception\FieldLengthException;
use App\Exception\ObjectNotFoundException;
use App\Mapper\IngredientMapper;
use App\Model\Ingredient;
use App\Tests\DatabaseDependantTestCase;

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

    /** @test */
    public function a_ingredient_model_record_have_length_validated_name_field(): void
    {
        $ingredientModel = new Ingredient('Short name.');

        $this->assertEquals('Short name.', $ingredientModel->getName());

        try {
            $ingredientModelWithLongName = new Ingredient(
                'Name longer than 100 characters. Name longer than 100 characters. 
                Name longer than 100 characters. (104)'
            );
        } catch (FieldLengthException $exception)
        {
            $this->assertEquals('Too many characters in the field.', $exception->getMessage());
        }
    }

    /** @test */
    public function a_ingredient_model_can_map_to_ingredient_entity_and_save_to_database(): void
    {
        //Setup
        $ingredientModel = new Ingredient('flour');

        //Do something
        $ingredientEntity = IngredientMapper::mapModelToEntity($ingredientModel);
        $this->entityManager->persist($ingredientEntity);
        $this->entityManager->flush();
        $ingredientRepository = $this->entityManager->getRepository(IngredientEntity::class);
        $storedIngredient = $ingredientRepository->findOneById(1);

        //Make assertions
        $this->assertEquals('flour', $storedIngredient->getName());
        $this->assertEquals('1', $storedIngredient->getId());
        $this->assertNotNull($storedIngredient->getCreatedAt());
        $this->assertNotNull($storedIngredient->getUpdatedAt());
    }

    /** @test */
    public function a_ingredient_entity_can_map_to_ingredient_model(): void
    {
        // Setup
        $ingredientEntity = new IngredientEntity('orange');
        $this->entityManager->persist($ingredientEntity);
        $this->entityManager->flush();
        $ingredientRepository = $this->entityManager->getRepository(IngredientEntity::class);
        $storedIngredient = $ingredientRepository->findOneById(1);

        // Do something
        $ingredientModel = IngredientMapper::mapEntityToModel($storedIngredient);

        // Make assertions
        $this->assertEquals('orange', $ingredientModel->getName());
        $this->assertEquals('1', $ingredientModel->getId());
        $this->assertNotNull($ingredientModel->getCreatedAt());
        $this->assertNotNull($ingredientModel->getUpdatedAt());
    }

    /** @test */
    public function a_ingredient_entities_array_can_map_to_ingredient_models_array(): void
    {
        // Setup
        $ingredientEntity = new IngredientEntity('bred');
        $ingredientEntity2 = new IngredientEntity('butter');
        $ingredientEntity3 = new IngredientEntity('water');
        $this->entityManager->persist($ingredientEntity);
        $this->entityManager->persist($ingredientEntity2);
        $this->entityManager->persist($ingredientEntity3);
        $this->entityManager->flush();

        $ingredientRepository = $this->entityManager->getRepository(IngredientEntity::class);
        $storedIngredients = $ingredientRepository->findAll();

        // Do something
        $ingredientModels = IngredientMapper::mapEntitiesToModels($storedIngredients);

        // Make assertions
        $this->assertEquals('bred', $ingredientModels[0]->getName());
        $this->assertEquals('1', $ingredientModels[0]->getId());
        $this->assertNotNull($ingredientModels[0]->getCreatedAt());
        $this->assertNotNull($ingredientModels[0]->getUpdatedAt());
        $this->assertEquals('butter', $ingredientModels[1]->getName());
        $this->assertEquals('2', $ingredientModels[1]->getId());
        $this->assertNotNull($ingredientModels[1]->getCreatedAt());
        $this->assertNotNull($ingredientModels[1]->getUpdatedAt());
        $this->assertEquals('water', $ingredientModels[2]->getName());
        $this->assertEquals('3', $ingredientModels[2]->getId());
        $this->assertNotNull($ingredientModels[2]->getCreatedAt());
        $this->assertNotNull($ingredientModels[2]->getUpdatedAt());
    }
}
