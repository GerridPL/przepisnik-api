<?php

declare(strict_types=1);

namespace App\Tests\e2e;

use App\DataProvider\IngredientDataProvider;
use App\DTO\IngredientDTO;
use App\Entity\IngredientEntity;
use App\Service\IngredientService;
use App\Tests\DatabaseDependantTestCase;
use Symfony\Component\HttpFoundation\Request;

class IngredientTest extends DatabaseDependantTestCase
{
    /** @test */
    public function a_ingredient_service_return_ingredients(): void
    {
        // Setup
        $ingredientRepository = $this->entityManager->getRepository(IngredientEntity::class);
        $ingredientDataProvider = new IngredientDataProvider($ingredientRepository);
        $ingredientService = new IngredientService($ingredientDataProvider);

        $ingredientEntity = new IngredientEntity('bred');
        $ingredientEntity2 = new IngredientEntity('butter');
        $ingredientEntity3 = new IngredientEntity('water');
        $this->entityManager->persist($ingredientEntity);
        $this->entityManager->persist($ingredientEntity2);
        $this->entityManager->persist($ingredientEntity3);
        $this->entityManager->flush();

        // Do something
        $ingredientModels = $ingredientService->index();

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

    /** @test */
    public function a_ingredient_service_can_store_by_dto(): void
    {
        // Setup
        $ingredientRepository = $this->entityManager->getRepository(IngredientEntity::class);
        $ingredientDataProvider = new IngredientDataProvider($ingredientRepository);
        $ingredientService = new IngredientService($ingredientDataProvider);
        $ingredientDTO = IngredientDTO::fromRequest(new Request([], ['name' => 'pepper']));

        // Do something
        $ingredientService->create($ingredientDTO);
        $ingredientModels = $ingredientService->index();

        // Make assertions
        $this->assertEquals('pepper', $ingredientModels[0]->getName());
        $this->assertEquals('1', $ingredientModels[0]->getId());
        $this->assertNotNull($ingredientModels[0]->getCreatedAt());
        $this->assertNotNull($ingredientModels[0]->getUpdatedAt());
    }

    /** @test */
    public function a_ingredient_service_can_update_by_dto_and_index(): void
    {
        // Setup
        $ingredientRepository = $this->entityManager->getRepository(IngredientEntity::class);
        $ingredientDataProvider = new IngredientDataProvider($ingredientRepository);
        $ingredientService = new IngredientService($ingredientDataProvider);
        $ingredientDTO = IngredientDTO::fromRequest(new Request([], ['name' => 'pepper']));
        $ingredientDTOForUpdate = IngredientDTO::fromRequest(new Request([], ['name' => 'salt']));

        // Do something
        $ingredientService->create($ingredientDTO);
        $ingredientService->update($ingredientDTOForUpdate, 1);
        $ingredientModels = $ingredientService->index();

        // Make assertions
        $this->assertEquals('salt', $ingredientModels[0]->getName());
        $this->assertEquals('1', $ingredientModels[0]->getId());
        $this->assertNotNull($ingredientModels[0]->getCreatedAt());
        $this->assertNotNull($ingredientModels[0]->getUpdatedAt());
    }

    /** @test */
    public function a_ingredient_service_can_remove_by_id(): void
    {
        // Setup
        $ingredientRepository = $this->entityManager->getRepository(IngredientEntity::class);
        $ingredientDataProvider = new IngredientDataProvider($ingredientRepository);
        $ingredientService = new IngredientService($ingredientDataProvider);
        $ingredientDTO = IngredientDTO::fromRequest(new Request([], ['name' => 'pepper']));

        // Do something
        $ingredientService->create($ingredientDTO);
        $ingredientService->delete(1);
        $ingredientModels = $ingredientService->index();

        // Make assertions
        $this->assertEquals([], $ingredientModels);
    }
}
