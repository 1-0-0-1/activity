<?php

namespace App\Entity;

use App\Repository\PageVisitRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PageVisitRepository::class)
 * @ORM\Table(name="page_visits")
 */
class PageVisit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $visit_time;

    /**
     * @ORM\ManyToOne(targetEntity=Page::class, inversedBy="pageVisits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $url;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVisitTime(): DateTimeInterface
    {
        return $this->visit_time;
    }

    public function setVisitTime(DateTimeInterface $visit_time): self
    {
        $this->visit_time = $visit_time;

        return $this;
    }

    public function getUrl(): ?Page
    {
        return $this->url;
    }

    public function setUrl(?Page $url): self
    {
        $this->url = $url;

        return $this;
    }
}
