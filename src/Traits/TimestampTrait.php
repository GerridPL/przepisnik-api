<?php

declare(strict_types=1);

namespace App\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
trait TimestampTrait
{
    #[ORM\Column]
    private DateTime $createdAt;

    #[ORM\Column]
    private DateTime $updatedAt;

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    public function timestampPrePersist(): void
    {
        $this->createdAt = new DateTime;
        $this->updatedAt = $this->createdAt;
    }

    #[ORM\PreUpdate]
    public function timestampPreUpdate(): void
    {
        $this->updatedAt = new DateTime;
    }
}
