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
                $logued = true;
                $newCategoryId = $category->getId(); 
                $this->addFlash('success', 'Categoría registrada correctamente.');
                return new JsonResponse(['status' => 'success', 'logued' => $logued, 'newCategoryId' => $newCategoryId], 200);
                
            }
        }
        
        else {
            $this->addFlash('danger', 'Ocurrió un error. Inténtelo de nuevo.');
            return new JsonResponse(['status' => 'error', 'message' => 'Faltan datos.'], 400);}


    }

    /**
     * Displays a form to edit an existing category entity.
     *
     * @Route("/{id}/edit", name="category_edit")
     * @Method({"GET", "POST"})
     */
    public function editCategoryAction(Request $request, $id)
    {
        if ($request->isMethod('POST')){
            $categoryName = $request->request->get('categoryName');
            $categoryIcon = $request->request->get('categoryIcon');
            $categoryID = $request->request->get('categoryID');
    
            if ($categoryName != null) {

                $em = $this->getDoctrine()->getManager();
        
                $category = $em->getRepository(Category::class)->find($categoryID);
        
                $category->setName($categoryName);
                $category->setIcon($categoryIcon);
        
                $em->flush();
            
                $logued = true;
                $this->addFlash('success', 'Categoría modificada correctamente.');
                return new JsonResponse(['status' => 'success', 'logued' => $logued], 200);
                
            }
        }
        
        else {
            $this->addFlash('danger', 'Ocurrió un error. Inténtelo de nuevo.');
            return new JsonResponse(['status' => 'error', 'message' => 'Faltan datos.'], 400);}

        

    }

     /**
     * Deletes a category entity.
     *
     * @Route("/delete/{id}", name="delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Category $category)
    {
      
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        return new JsonResponse(['status' => 'success', 'message' => 'Categoría eliminada correctamente.']);
    }

 /** 
 * @Route("/category/{id}", name="category_details")
 * @Method("GET")
 */
public function getCategoryDetailsAction($id)
{
    $em = $this->getDoctrine()->getManager();
    $category = $em->getRepository(Category::class)->find($id);

    if (!$category) {
        return new JsonResponse(['status' => 'error', 'message' => 'Categoría no encontrada'], 404);
    }

    return new JsonResponse(['status' => 'success', 'category' => ['name' => $category->getName(), 'icon' => $category->getIcon()]]);
}

}
