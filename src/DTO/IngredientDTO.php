<?php

declare(strict_types=1);

namespace App\DTO;

use App\DTO\Interfaces\IngredientDTOInterface;
use App\Exception\RequiredFieldNotProvidedException;
use App\Helper\InputBagHelper;
use App\Model\Ingredient;
use Symfony\Component\HttpFoundation\Request;

class IngredientDTO implements IngredientDTOInterface
{
    private string $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    /** @inheritdoc */
    public static function fromRequest(Request $request): self
    {
        $name = InputBagHelper::getParameterOrFail($request->request, 'name');

        return new self($name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    /** @inheritdoc  */
    public function toModel(): Ingredient
    {
        return new Ingredient($this->getName());
    }

}
