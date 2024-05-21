<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends Controller
{
    /**
     * Creates a new product entity.
     *
     * @Route("/product/new", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function newProductAction(Request $request)
    {
        if ($request->isMethod('POST')){
            $productName = $request->request->get('productName');
            $productImg = $request->request->get('productImg');
            $categoryId = $request->request->get('productCategory');
    
            if ($productName != null) {
                $em = $this->getDoctrine()->getManager();
                $category = $em->getRepository(Category::class)->find($categoryId);
    
                if (!$category) {
                    return new JsonResponse(['status' => 'error', 'message' => 'Categoría no encontrada'], 400);
                }
    
                $product = new Product();
                $product->setName($productName);
                $product->setImage($productImg);
                $product->setCategory($category);
    
                $em->persist($product);
                $em->flush();
                $newProductId = $product->getId();
    
                $this->addFlash('success', 'Producto registrado correctamente.');
    
                $productHtml = $this->renderView('product/_product.html.twig', ['product' => $product]);
    
                return new JsonResponse(['status' => 'success', 'newProductId' => $newProductId, 'productHtml' => $productHtml], 200);
            } else {
                return new JsonResponse(['status' => 'error', 'message' => 'Faltan datos.'], 400);
            }
        }
    }
    

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/product/{id}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     */
    public function editProductAction(Request $request, $id)
    {
        if ($request->isMethod('POST')){
            $productName = $request->request->get('productName');
            $productImg = $request->request->get('productImg');
            $categoryId = $request->request->get('productCategory');
    
            if ($productName != null) {
                $em = $this->getDoctrine()->getManager();
        
                $product = $em->getRepository(Product::class)->find($id);
                $category = $em->getRepository(Category::class)->find($categoryId);

                if (!$product || !$category) {
                    return new JsonResponse(['status' => 'error', 'message' => 'Producto o Categoría no encontrados'], 400);
                }

                $product->setName($productName);
                $product->setImage($productImg);
                $product->setCategory($category);
        
                $em->flush();
            
                $this->addFlash('success', 'Producto modificado correctamente.');
                return new JsonResponse(['status' => 'success'], 200);
                
            } else {
                return new JsonResponse(['status' => 'error', 'message' => 'Faltan datos.'], 400);
            }
        }
    }

    /**
     * Deletes a product entity.
     *
     * @Route("/product/delete/{id}", name="product_delete")
     * @Method("DELETE")
     */
    public function deleteProductAction(Request $request, Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        return new JsonResponse(['status' => 'success', 'message' => 'Producto eliminado correctamente.']);
    }

    /** 
     * @Route("/product/{id}", name="product_details")
     * @Method("GET")
     */
    public function getProductDetailsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($id);

        if (!$product) {
            return new JsonResponse(['status' => 'error', 'message' => 'Producto no encontrado'], 404);
        }

        return new JsonResponse([
            'status' => 'success', 
            'product' => [
                'name' => $product->getName(), 
                'image' => $product->getImage(),
                'category' => [
                    'id' => $product->getCategory()->getId(),
                    'name' => $product->getCategory()->getName()
                ]
            ]
        ]);
    }
}
