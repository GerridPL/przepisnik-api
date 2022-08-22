<?php

declare(strict_types=1);

namespace App\Controller;

use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SwaggerController extends AbstractController
{
    /**
     * @OA\Info(title="przepisnik", version="2.0")
     */
    #[Route('/swagger', name: 'swagger')]
    public function index(): Response
    {
        return $this->render('Swagger/index.html.twig');
    }
}
