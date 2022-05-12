<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ConferenceRepository;
use Twig\Environment;
use App\Entity\Conference;
use App\Repository\CommentRepository;


class ConferenceController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(Environment $twig, ConferenceRepository $conferenceRepository): Response
    {
        return new Response($twig->render('conference/index.html.twig',[
            'conferences' => $conferenceRepository->findAll()
        ]));
    }

    #[Route('/conference/{id}', name: 'conference')]
    public function show(Request $request, Environment $twig, Conference $conference, CommentRepository $commentRepository): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($conference, $offset);

        return new Response($this->render('conference/show.html.twig',[
            'conference' => $conference,
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE)
        ]));
    }

    #[Route('/hello', name: 'hello')]
    public function hello(string $greet = ""): Response
    {
        return new Response(<<<EOF
<html>
    <body>
        $greet
        <img src="/images/under-construction.gif" />
    </body>
</html>
EOF
    );
    }

    #[Route('/hello_there', name: 'hello there')]
    public function hello_there(Request $request): Response
    {
        $greet = '';
        $name = $request->query->get('name');
        if ($name) {
            $greet = sprintf('<h1>Hello there, %s</h1>', htmlspecialchars($name));
        }
        return $this->hello($greet);
    }

    #[Route('/hello_here/{name}', name: 'hello')]
    public function hello_here(string $name = ''): Response
    {
        $greet = '';
        if ($name) {
            $greet = sprintf('<h1>Hello, %s</h1>', htmlspecialchars($name));
        }
        return $this->hello($greet);
    }
}

