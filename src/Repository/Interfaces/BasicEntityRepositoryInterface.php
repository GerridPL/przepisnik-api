<?php

declare(strict_types=1);

namespace App\Repository\Interfaces;

interface BasicEntityRepositoryInterface
{
    public function flush(): void;
}
