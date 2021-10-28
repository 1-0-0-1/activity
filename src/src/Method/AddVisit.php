<?php

namespace App\Method;

use App\Service\PageService;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Required;
use Yoanm\JsonRpcParamsSymfonyValidator\Domain\MethodWithValidatedParamsInterface;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;

class AddVisit implements JsonRpcMethodInterface, MethodWithValidatedParamsInterface
{

    private PageService $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function apply(array $paramList = null): bool
    {
        $url = filter_var($paramList["url"], FILTER_SANITIZE_STRING);
        $date = new DateTimeImmutable($paramList["date"]);
        $this->pageService->addVisit($url, $date);
        return true;
    }

    public function getParamsConstraint(): Constraint
    {
        return new Collection([
            'fields' => [
                'url' => new Required([
                    new NotNull(),
                ]),
                'date' => new Required([
                    new NotNull(),
                    new DateTime()
                ]),
            ]
        ]);
    }
}
