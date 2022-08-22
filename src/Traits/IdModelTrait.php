<?php

declare(strict_types=1);

namespace App\Traits;

use App\Exception\FieldNotSetException;

trait IdModelTrait
{
    /**
     * @JMS\Serializer\Annotation\Groups({"id"})
     */
    private ?int $id;

    public function hasId(): bool
    {
        return !is_null($this->id);
    }

    public function getId(): ?int
    {
        if (!$this->hasId()) {
            throw new FieldNotSetException("Field id is null and can't be obtained");
        }

        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
