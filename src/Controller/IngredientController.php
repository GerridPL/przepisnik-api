<?php

namespace App\Controller;

use App\Helper\JsonHelper;
use App\Service\IngredientService;
use OpenApi\Attributes\Response as ApiResponse;
use OpenApi\Attributes\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/ingredient", name: "ingredient")]
#[Tag("Ingredient")]
class IngredientController extends AbstractController
{
    #[ApiResponse(response: 200, description: "Success")]
    #[Route('/', name: 'ingredient_index', methods: 'GET')]
    public function index(IngredientService $ingredientService): JsonResponse
    {
        $ingredientList = $ingredientService->index();

        $json = JsonHelper::serialize($ingredientList, ['id', 'ingredient']);

        return new JsonResponse($json, 200, [], true);
    }
}
