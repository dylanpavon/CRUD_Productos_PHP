<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Category controller.
 *
 * @Route("category")
 */
class CategoryController extends Controller
{
    /**
     * Lists all category entities.
     *
     * @Route("/", name="category_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Category')->findAll();

        $categoryData = [];
        foreach ($categories as $category) {
            $categoryData[] = [
                'id' => $category->getId(),
                'name' => $category->getName(),
            ];
        }

        return new JsonResponse(['status' => 'success', 'categories' => $categoryData]);
    }

    /**
     * Creates a new category entity.
     *
     * @Route("/new", name="category_new")
     * @Method({"GET", "POST"})
     */
    public function newCategoryAction(Request $request)
    {
        

        if ($request->isMethod('POST')){
            $categoryName = $request->request->get('categoryName');
            $categoryIcon = $request->request->get('categoryIcon');
    
            if ($categoryName != null) {
                $category = new Category();
                $category->setName($categoryName);
                $category->setIcon($categoryIcon);
            
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();

                $this->addFlash('success', 'Categoría registrada correctamente.');
                return new JsonResponse(['status' => 'success', 'message' => 'Categoría creada correctamente.'], 200);
            }
        }
        
        else {
            $this->addFlash('danger', 'Ocurrió un error. Inténtelo de nuevo.');
            return new JsonResponse(['status' => 'error', 'message' => 'Faltan datos.'], 400);}


    }

    /**
     * Finds and displays a category entity.
     *
     * @Route("/{id}", name="category_show")
     * @Method("GET")
     */
    public function listCategoriesAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
    
        return $this->render('default/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * Displays a form to edit an existing category entity.
     *
     * @Route("/{id}/edit", name="category_edit")
     * @Method({"GET", "POST"})
     */
    public function editCategoryAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $category = $em->getRepository(Category::class)->find($id);
        
        $category->setName($request->request->get('categoryName'));
        $category->setIcon($request->request->get('categoryIcon'));
        
        $em->flush();

    }

    /**
     * Deletes a category entity.
     *
     * @Route("/{id}", name="category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Category $category)
    {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('category_index');
    }

    /**
     * Creates a form to delete a category entity.
     *
     * @param Category $category The category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
