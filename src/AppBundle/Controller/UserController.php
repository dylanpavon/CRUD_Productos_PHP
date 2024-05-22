<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * User controller.
 *
 * @Route("user")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $username = $request->request->get('username');
            $password = $request->request->get('password');

            $user = new User();
            $user->setEmail($email);
            $user->setUsername($username);
            $user->setPassword($password); // Deberías codificar la contraseña antes de guardarla

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Usuario registrado correctamente.');
            return $this->redirectToRoute('homepage'); // Cambia 'user_list' a la ruta que desees redirigir
        }

        return $this->render('default/index.html.twig');
    }
    /**
     * @Route("/login", name="user_login")
     * @Method({"GET", "POST"})
     */
    public function loginAction(Request $request)
    {
        $username = $request->request->get('usernameL');
        $password = $request->request->get('passwordL');
        $logued = false;

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['username' => $username]);



        if ($user) {
            $storedPassword = stream_get_contents($user->getPassword());
            $storedPassword = password_hash($storedPassword,null);
            
    
            if (password_verify($password, $storedPassword)) {
                $logued = true;
                //$this->addFlash('success', 'Sesión iniciada, bienvenido!');
    
                return new JsonResponse(['status' => 'success', 'logued' => $logued, 'message' => 'Bienvenido!'], 200);
            }
        }
        //$this->addFlash('danger', 'Credenciales inválidas. Inténtelo de nuevo.');
        return new JsonResponse(['status' => 'error', 'logued' => $logued, 'message' => 'Credenciales inválidas. Inténtelo de nuevo.'], 401);

        

    }

}
