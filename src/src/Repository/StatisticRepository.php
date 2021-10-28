<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\DBAL\ParameterType;
use Doctrine\Persistence\ManagerRegistry;

class StatisticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return array
     * @throws Exception
     * @throws DBALException
     */
    public function getStatistic(int $offset, int $limit): array
    {
        $sql = "
            SELECT
              pages.url,
              pages.last_activity,
              COUNT(page_visits.id) AS visit_count
            FROM
              pages
              LEFT JOIN page_visits
                ON pages.id = page_visits.url_id
            GROUP BY page_visits.url_id
            LIMIT :offset, :limit
        ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindValue("offset", $offset, ParameterType::INTEGER);
        $stmt->bindValue("limit", $limit, ParameterType::INTEGER);
        return $stmt->executeQuery()->fetchAllAssociative();
    }
}
