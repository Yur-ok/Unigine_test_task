<?php

namespace App\Entity;

use App\Repository\UrlRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UrlRepository::class)
 */
class Url
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $url;

    /**
     * @ORM\Column(type="string", length=14)
     */
    private ?string $hash;

    /**
     * @ORM\Column(name="created_date", type="datetime_immutable")
     */
    private ?\DateTimeImmutable $createdDate;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $ttl;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isExpired;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isSendToEndpoint;

    public function __construct()
    {
        $date = new \DateTimeImmutable();
        $this->setCreatedDate($date);
        $this->setHash($date->format('YmdHis'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
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

    public function getCreatedDate(): ?\DateTimeImmutable
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeImmutable $createdDate): self
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getTtl(): ?int
    {
        return $this->ttl;
    }

    public function setTtl(int $ttl): self
    {
        $this->ttl = $ttl;

        return $this;
    }

    public function getIsExpired(): ?bool
    {
        return $this->isExpired;
    }

    public function setIsExpired(bool $isExpired): self
    {
        $this->isExpired = $isExpired;

        return $this;
    }

    public function getIsSendToEndpoint(): ?bool
    {
        return $this->isSendToEndpoint;
    }

    public function setIsSendToEndpoint(bool $isSendToEndpoint): self
    {
        $this->isSendToEndpoint = $isSendToEndpoint;

        return $this;
    }
}
