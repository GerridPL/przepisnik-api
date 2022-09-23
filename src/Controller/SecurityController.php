<?php

declare(strict_types=1);

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations\RequestParam;
use OpenApi\Attributes\Tag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes\Response as ApiResponse;

#[Route("/api", name: "Security")]
#[Tag("Security")]
class SecurityController
{
    #[ApiResponse(response: 200, description: "Success")]
    #[ApiResponse(response: 401, description: "Access Denied")]
    #[ApiResponse(response: 400, description: "Data input error")]
    #[RequestParam(name: 'username', default: 'test@test.pl')]
    #[RequestParam(name: 'password', default: 'test')]
    #[Route('/login_check', name: 'login', methods: 'POST')]
    public function index(): Response
    {
        return new Response(null,200, []);
    }
}
