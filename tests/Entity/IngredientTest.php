<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\IngredientEntity;
use PHPUnit\Framework\TestCase;

class IngredientTest extends TestCase
{
    public function test_setting_name(): void
    {
        $ingredient = new IngredientEntity('Mąka');

        $name = 'Chleb';
        $ingredient->setName($name);

        $this->assertEquals($name, $ingredient->getName());
    }
}
