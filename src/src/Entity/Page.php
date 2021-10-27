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
     * @ORM\Column(type="string", length=32)
     */
    private string $hash;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $url;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $last_activity;

    /**
     * @ORM\OneToMany(targetEntity=PageVisit::class, mappedBy="hash")
     */
    private $pageVisits;

    public function __construct()
    {
        $this->pageVisits = new ArrayCollection();
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

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getLastActivity(): DateTimeInterface
    {
        return $this->last_activity;
    }

    public function setLastActivity(DateTimeInterface $last_activity): self
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
            $pageVisit->setHash($this);
        }

        return $this;
    }

    public function removePageVisit(PageVisit $pageVisit): self
    {
        if ($this->pageVisits->removeElement($pageVisit)) {
            // set the owning side to null (unless already changed)
            if ($pageVisit->getHash() === $this) {
                $pageVisit->setHash(null);
            }
        }

        return $this;
    }
}
