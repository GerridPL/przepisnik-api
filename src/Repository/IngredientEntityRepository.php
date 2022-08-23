<?php

namespace App\Repository;

use App\Entity\IngredientEntity;
use App\Exception\ObjectNotFoundException;
use App\Repository\Interfaces\IngredientEntityRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IngredientEntity>
 *
 * @method IngredientEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method IngredientEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method IngredientEntity[]    findAll()
 * @method IngredientEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientEntityRepository extends ServiceEntityRepository implements IngredientEntityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IngredientEntity::class);
    }

    public function flush(): void
    {
        $this->_em->flush();
    }

    public function persist(IngredientEntity $ingredientEntity): void
    {
        $this->_em->persist($ingredientEntity);
    }

    /** @inheritdoc */
    public function findOneById(int $id): IngredientEntity
    {
        $qb = $this->createQueryBuilder('ingredient_entity');
        $qb->andWhere($qb->expr()->eq('ingredient_entity.id', ':id'));
        $qb->setParameter('id', $id);

        $entity = $qb->getQuery()->getOneOrNullResult();

        if (is_null($entity))
        {
            throw new ObjectNotFoundException("Not found Ingredient with id: $id.");
        }

        return $entity;
    }

    /** @inheritdoc */
    public function findOrFail(int $id): IngredientEntity
    {
        $ingredientEntity = $this->find($id);

        if (is_null($ingredientEntity))
        {
            throw new ObjectNotFoundException("Not found Ingredient with id: $id.");
        }

        return $ingredientEntity;
    }

    /** @inheritdoc */
    public function removeById(int $id): void
    {
        $ingredientEntity = $this->findOneById($id);

        $this->_em->remove($ingredientEntity);
    }

}
