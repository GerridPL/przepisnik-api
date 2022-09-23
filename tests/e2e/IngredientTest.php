<?php

declare(strict_types=1);

namespace App\Tests\e2e;

use App\Controller\IngredientController;
use App\DataProvider\IngredientDataProvider;
use App\DTO\IngredientDTO;
use App\Entity\IngredientEntity;
use App\Service\IngredientService;
use App\Tests\DatabaseDependantTestCase;
use Symfony\Component\HttpFoundation\Request;

class IngredientTest extends DatabaseDependantTestCase
{
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

    /** @test */
    public function a_ingredient_controller_can_create(): void
    {
        // Setup
        $ingredientRepository = $this->entityManager->getRepository(IngredientEntity::class);
        $ingredientDataProvider = new IngredientDataProvider($ingredientRepository);
        $ingredientService = new IngredientService($ingredientDataProvider);
        $ingredientController = new IngredientController();

        $request = new Request([], ['name' => 'pepper']);

        // Do something
        $response = $ingredientController->create($request, $ingredientService);

        $ingredientRepository = $this->entityManager->getRepository(IngredientEntity::class);
        $storedIngredient = $ingredientRepository->findOneById(1);

        // Make assertions
        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEquals('pepper', $storedIngredient->getName());
    }

    /** @test */
    public function a_ingredient_controller_can_show(): void
    {
        // Setup
        $ingredientRepository = $this->entityManager->getRepository(IngredientEntity::class);
        $ingredientDataProvider = new IngredientDataProvider($ingredientRepository);
        $ingredientService = new IngredientService($ingredientDataProvider);
        $ingredientController = new IngredientController();

        $request1 = new Request([], ['name' => 'bread']);
        $request2 = new Request([], ['name' => 'butter']);
        $request3 = new Request([], ['name' => 'water']);

        $ingredientController->create($request1, $ingredientService);
        $ingredientController->create($request2, $ingredientService);
        $ingredientController->create($request3, $ingredientService);

        // Do something
        $jsonResponse = $ingredientController->index($ingredientService);

        // Make assertions
        $this->assertEquals(200, $jsonResponse->getStatusCode());

        $expectedJson = '[{"name":"bread","id":1},{"name":"butter","id":2},{"name":"water","id":3}]';
        $this->assertJsonStringEqualsJsonString($expectedJson, $jsonResponse->getContent());
    }

    /** @test */
    public function a_ingredient_controller_can_update(): void
    {
        // Setup
        $ingredientRepository = $this->entityManager->getRepository(IngredientEntity::class);
        $ingredientDataProvider = new IngredientDataProvider($ingredientRepository);
        $ingredientService = new IngredientService($ingredientDataProvider);
        $ingredientController = new IngredientController();

        $requestForCreate = new Request([], ['name' => 'pepper']);
        $ingredientController->create($requestForCreate, $ingredientService);

        // Do something
        $requestForUpdate = new Request([], ['name' => 'tomato']);
        $responseFromUpdate = $ingredientController->update($requestForUpdate, $ingredientService, 1);

        $ingredientRepository = $this->entityManager->getRepository(IngredientEntity::class);
        $storedIngredient = $ingredientRepository->findOneById(1);

        // Make assertions
        $this->assertEquals(204, $responseFromUpdate->getStatusCode());
        $this->assertEquals('tomato', $storedIngredient->getName());
    }

    /** @test */
    public function a_ingredient_controller_can_delete(): void
    {
        // Setup
        $ingredientRepository = $this->entityManager->getRepository(IngredientEntity::class);
        $ingredientDataProvider = new IngredientDataProvider($ingredientRepository);
        $ingredientService = new IngredientService($ingredientDataProvider);
        $ingredientController = new IngredientController();

        $requestForCreate = new Request([], ['name' => 'pepper']);
        $ingredientController->create($requestForCreate, $ingredientService);

        // Do something
        $responseFromDelete = $ingredientController->delete($ingredientService, 1);
        $responseFromIndex = $ingredientController->index($ingredientService);

        // Make assertions
        $this->assertEquals(204, $responseFromDelete->getStatusCode());
        $this->assertJsonStringEqualsJsonString('[]', $responseFromIndex->getContent());
    }
}
