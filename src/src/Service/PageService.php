<?php

namespace App\Service;

use App\Entity\PageVisit;
use App\Repository\PageRepository;
use App\Repository\PageVisitRepository;
use App\Repository\StatisticRepository;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class PageService
{

    private PageRepository $pageRepository;
    private EntityManagerInterface $entityManager;
    private PageVisitRepository $pageVisitRepository;
    private StatisticRepository $statisticRepository;

    public function __construct(PageRepository $pageRepository, PageVisitRepository $pageVisitRepository, StatisticRepository $statisticRepository, EntityManagerInterface $entityManager)
    {
        $this->pageRepository = $pageRepository;
        $this->entityManager = $entityManager;
        $this->pageVisitRepository = $pageVisitRepository;
        $this->statisticRepository = $statisticRepository;
    }

    public function addVisit(string $url, DateTimeInterface $datetime)
    {
        $this->entityManager->beginTransaction();
        try {
            $page = $this->pageRepository->loadByUrl($url);
            if (empty($page->getLastActivity())) {
                $page->setLastActivity($datetime);
            } elseif ($page->getLastActivity() < $datetime) {
                $page->setLastActivity($datetime);
            }
            $this->pageRepository->update($page);

            $pageVisit = new PageVisit();
            $pageVisit->setUrl($page);
            $pageVisit->setVisitTime($datetime);
            $this->pageVisitRepository->update($pageVisit);

            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollback();
        }
    }

    public function getStatistic(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;
        return [
            'data' => $this->statisticRepository->getStatistic($offset, $perPage),
            'total_rows' => $this->pageRepository->count([]),
        ];
    }
}
