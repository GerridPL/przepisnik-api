<?php

namespace App\Controller;

use OpenApi\Annotations as OA;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Response as ApiResponse;
use OpenApi\Attributes\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/ingredient", name: "ingredient")]
class IngredientController extends AbstractController
{
    #[ApiResponse(response: 204, description: "Success")]
    #[ApiResponse(response: 400, description: "Data input error")]
    #[Get(path: '/ingredient', description: 'Show all ingredients.')]
    #[Route('/', name: 'ingredient_index', methods: 'GET')]
    public function index(): Response
    {
        return new Response('Ingredients list');
    }
}
