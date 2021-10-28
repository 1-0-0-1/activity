<?php

namespace App\Method;

use App\Service\PageService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Required;
use Yoanm\JsonRpcParamsSymfonyValidator\Domain\MethodWithValidatedParamsInterface;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;

class VisitStatistic implements JsonRpcMethodInterface, MethodWithValidatedParamsInterface
{

    private PageService $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function apply(array $paramList = null): array
    {
        $page = $paramList["page"];
        $perPage = $paramList["per_page"];
        return $this->pageService->getStatistic($page, $perPage);
    }

    public function getParamsConstraint(): Constraint
    {
        return new Collection([
            'fields' => [
                'page' => new Required([
                    new NotNull(),
                    new GreaterThanOrEqual(1),
                ]),
                'per_page' => new Required([
                    new NotNull(),
                    new GreaterThanOrEqual(1),
                ]),
            ]
        ]);
    }
}
