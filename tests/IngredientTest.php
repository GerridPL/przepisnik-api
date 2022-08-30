<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\IngredientEntity;
use App\Exception\ObjectNotFoundException;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IngredientTest extends KernelTestCase
{
    private EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        DatabasePrimer::prime($kernel);

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function test_a_ingredient_entity_record_can_be_created_in_database(): void
    {
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

    public function test_a_ingredient_entity_record_can_be_removed_from_database(): void
    {
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
