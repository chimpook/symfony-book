<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(string $greet = ""): Response
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

