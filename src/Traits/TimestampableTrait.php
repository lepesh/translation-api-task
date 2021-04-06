<?php
declare(strict_types=1);

namespace App\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Adds created at and updated at timestamps to entities.
 * Entities using this must have HasLifecycleCallbacks annotation.
 */
trait TimestampableTrait
{
    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    protected DateTime $createdAt;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    protected DateTime $updatedAt;

    /**
     * @ORM\PrePersist
     * @return void
     */
    public function onPrePersist(): void
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    /**
     * @ORM\PreUpdate
     * @return void
     */
    public function onPreUpdate(): void
    {
        $this->updatedAt = new DateTime();
    }

    /**
     * @param DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }
}
