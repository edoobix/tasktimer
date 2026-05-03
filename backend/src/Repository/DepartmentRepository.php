<?php

namespace App\Repository;

use App\Admin\Shared\PaginationRequest;
use App\Entity\Department;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Department>
 */
class DepartmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Department::class);
    }

    public function getPaginatedDepartments(PaginationRequest $paginationRequest): Paginator
    {
        $qb = $this->createQueryBuilder('d')
            ->setFirstResult(($paginationRequest->page - 1) * $paginationRequest->limit)
            ->setMaxResults($paginationRequest->limit)
            ->orderBy('d.name', 'ASC')
            ->getQuery()
        ;

        return new Paginator($qb);
    }
}
