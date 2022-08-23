<?php

namespace App\Controller;

use App\DTO\IngredientDTO;
use App\Exception\FieldLengthException;
use App\Exception\ObjectNotFoundException;
use App\Exception\RequiredFieldNotProvidedException;
use App\Helper\JsonHelper;
use App\Service\IngredientService;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use OpenApi\Attributes\Response as ApiResponse;
use OpenApi\Attributes\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/ingredients", name: "ingredients")]
#[Tag("Ingredients")]
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

    #[ApiResponse(response: 204, description: "Success")]
    #[ApiResponse(response: 400, description: "Data input error")]
    #[RequestParam(name: 'name', default: '')]
    #[Route('/', name: 'ingredient_create', methods: 'POST')]
    public function create(Request $request, IngredientService $ingredientService): Response
    {
        try {
            $ingredientService->create(IngredientDTO::fromRequest($request));
        } catch (RequiredFieldNotProvidedException | FieldLengthException $exception)
        {
            throw new BadRequestHttpException($exception->getMessage());
        }

        return new Response("", 204);
    }

    #[ApiResponse(response: 204, description: "Success")]
    #[ApiResponse(response: 400, description: "Data input error")]
    #[ApiResponse(response: 404, description: "Object not found")]
    #[RequestParam(name: 'name', default: '')]
    #[Route('/{id}', name: 'ingredient_update', methods: 'PUT')]
    public function update(Request $request, IngredientService $ingredientService, int $id): Response
    {
        try {
            $ingredientService->update(IngredientDTO::fromRequest($request), $id);
        } catch (RequiredFieldNotProvidedException | FieldLengthException $exception)
        {
            throw new BadRequestHttpException($exception->getMessage());
        } catch (ObjectNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        return new Response("", 204);
    }

    #[ApiResponse(response: 204, description: "Success")]
    #[ApiResponse(response: 404, description: "Object not found")]
    #[Route('/{id}', name: 'ingredient_delete', methods: 'DELETE')]
    public function delete(IngredientService $ingredientService, int $id): Response
    {
        try {
            $ingredientService->delete($id);
        } catch (ObjectNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        return new Response("", 204);
    }

}
