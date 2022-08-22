<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Entity\IngredientEntity;
use App\Model\Ingredient;

class IngredientMapper
{
    public static function mapModelToEntity(Ingredient $model): IngredientEntity
    {
        return new IngredientEntity($model->getName());
    }

    public static function mapEntityToModel(IngredientEntity $entity): Ingredient
    {
        $model = new Ingredient($entity->getName());

        $model->setId($entity->getId());
        $model->setCreatedAt($entity->getCreatedAt());
        $model->setUpdatedAt($entity->getUpdatedAt());

        return $model;
    }

    public static function mapModelToProvidedEntity(Ingredient $model, IngredientEntity $entity): IngredientEntity
    {
        $entity->setName($model->getName());

        return $entity;
    }
}
