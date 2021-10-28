<?php

namespace App\Entity;

use App\Repository\PageRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 * @ORM\Table(name="pages")
 */
class Page
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $url;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $last_activity = null;

    /**
     * @ORM\OneToMany(targetEntity=PageVisit::class, mappedBy="url")
     */
    private Collection $pageVisits;

    public function __construct()
    {
        $this->pageVisits = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getLastActivity(): ?DateTimeInterface
    {
        return $this->last_activity;
    }

    /**
     * @param DateTimeInterface $last_activity
     * @return Page
     */
    public function setLastActivity(DateTimeInterface $last_activity): Page
    {
        $this->last_activity = $last_activity;
        return $this;
    }

    /**
     * @return Collection|PageVisit[]
     */
    public function getPageVisits(): Collection
    {
        return $this->pageVisits;
    }

    public function addPageVisit(PageVisit $pageVisit): self
    {
        if (!$this->pageVisits->contains($pageVisit)) {
            $this->pageVisits[] = $pageVisit;
            $pageVisit->setUrl($this);
        }

        return $this;
    }

    public function removePageVisit(PageVisit $pageVisit): self
    {
        if ($this->pageVisits->removeElement($pageVisit)) {
            // set the owning side to null (unless already changed)
            if ($pageVisit->getUrl() === $this) {
                $pageVisit->setUrl(null);
            }
        }

        return $this;
    }
}
