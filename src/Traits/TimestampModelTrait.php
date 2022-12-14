<?php

declare(strict_types=1);

namespace App\Traits;

use DateTime;

trait TimestampModelTrait
{
    /**
     * @JMS\Serializer\Annotation\Groups({"timestamp"})
     */
    private DateTime $createdAt;

    /**
     * @JMS\Serializer\Annotation\Groups({"timestamp"})
     */
    private DateTime $updatedAt;

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
