<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
            // Verificar si el usuario está autenticado
    $isLogged = $this->getUser() !== null;

    // Puedes pasar $isLogged a tu plantilla Twig para utilizarlo allí
    return $this->render('default/index.html.twig', [
        'isLogged' => $isLogged
    ]);
    }

}
