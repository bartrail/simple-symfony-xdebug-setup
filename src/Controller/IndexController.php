<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Webmozart\Assert\Assert;

class IndexController extends AbstractController
{
    #[Route('/')]
    public function __invoke(UserRepository $userRepository, Request $request): Response
    {
        $userName = $request->query->get('name') ?? 'world';

        if(is_string($userName) === false) {
            throw new BadRequestHttpException(
                sprintf('name must be a string - [%s] given', get_debug_type($userName))
            );
        }

        $user = $userRepository->getUserByName($userName);

        return $this->render('index.html.twig', [
            'user' => $user,
        ]);
    }
}
