<?php

declare(strict_types=1);

namespace App\Base\Data;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @template TEntity of object
 *
 * @extends ServiceEntityRepository<TEntity>
 */
abstract class AbstractRepository extends ServiceEntityRepository
{
    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @phpstan-param TEntity $entity
     */
    public function save(object $entity): void
    {
        $this->getEntityManager()->persist($entity);
    }

    /**
     * @phpstan-param TEntity[] $entities
     */
    public function saveList(array $entities): void
    {
        foreach ($entities as $entity) {
            $this->save($entity);
        }
    }

    /**
     * @phpstan-param TEntity $entity
     */
    public function delete(object $entity): void
    {
        $this->getEntityManager()->remove($entity);
    }

    /**
     * @phpstan-param TEntity[] $entities
     */
    public function deleteList(array $entities): void
    {
        foreach ($entities as $entity) {
            $this->delete($entity);
        }
    }

    /**
     * @phpstan-return ?TEntity $entity
     */
    public function findOneByIdOrNull(int $id): ?object
    {
        return parent::find($id);
    }

    /**
     * @param array<string,mixed> $criteria
     *
     * @phpstan-return ?TEntity $entity
     */
    public function findOneByCriteriaOrNull(array $criteria): ?object
    {
        return parent::findOneBy($criteria);
    }

    /**
     * @return TEntity[]
     */
    public function findAll(): array
    {
        return parent::findAll();
    }

    /**
     * @return TEntity[]
     */
    public function findListByCriteria(array $criteria): array
    {
        return parent::findBy($criteria);
    }
}
