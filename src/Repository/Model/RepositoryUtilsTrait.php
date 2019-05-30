<?php

declare(strict_types=1);

namespace App\Repository\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Generator;

/**
 * @method QueryBuilder  createQueryBuilder($alias)
 * @method EntityManager getEntityManager()
 *
 * @property EntityManager $_em
 */
trait RepositoryUtilsTrait
{
    /** @var QueryBuilder */
    private $qb;

    public function getEm(): EntityManager
    {
        return $this->_em;
    }

    public function getQb(Generator ...$generators): QueryBuilder
    {
        $this->qb = $this->createQueryBuilder('o');
        $this->runGenerators($generators);

        return $this->qb();
    }

    public function getResultsFromQb(QueryBuilder $qb, Generator ...$generators): array
    {
        $this->qb = $qb;
        $this->runGenerators($generators);

        return $qb->getQuery()->getResult();
    }

    public function findOneResult(Generator ...$generators)
    {
        $this->qb = $this->createQueryBuilder('o');
        $this->runGenerators($generators);

        return $this->qb()->getQuery()->getOneOrNullResult();
    }

    public function getResults(Generator ...$generators): array
    {
        $this->qb = $this->createQueryBuilder('o');
        $this->runGenerators($generators);

        return $this->qb()->getQuery()->getResult();
    }

    public function whereId(string $id): Generator
    {
        yield $this->qb()->andWhere('o.id = :id')->setParameter('id', $id);
    }

    public function setMaxResults(int $maxResults): Generator
    {
        yield $this->qb()->setMaxResults($maxResults);
    }

    public function orderBy(string $column, bool $isAsc = true): Generator
    {
        yield $this->qb()->orderBy($column, $isAsc ? 'ASC' : 'DESC');
    }

    public function removeByCondition(Generator ...$generators): void
    {
        $results = $this->getResults(...$generators);
        $this->remove($results);
    }

    public function remove($entity, bool $flush = false): void
    {
        if (!$entity) {
            return;
        }
        $em = $this->getEntityManager();
        if (!is_iterable($entity)) {
            $em->remove($entity);
        } else {
            foreach ($entity as $item) {
                $em->remove($item);
            }
        }

        if ($flush) {
            $em->flush();
        }
    }

    public function save($entity): void
    {
        $this->persist($entity);
        $this->flush($entity);
    }

    public function persist($entity): void
    {
        $this->getEntityManager()->persist($entity);
    }

    public function flush($entity = null): void
    {
        $this->getEntityManager()->flush($entity);
    }

    protected function applyConfig(array $filters, array $config): Generator
    {
        /** @var callable $callable */
        foreach ($config as $filterName => $callable) {
            if (!empty($filters[$filterName])) {
                yield from $callable($filters[$filterName]);
            }
        }
    }

    protected function qb(): QueryBuilder
    {
        return $this->qb;
    }

    protected function whereIdIsNull(): Generator
    {
        yield $this->qb()->andWhere('o.id IS NULL');
    }

    private function runGenerators(array $generators): void
    {
        foreach ($generators as $generator) {
            iterator_to_array($generator, false);
        }
    }
}
