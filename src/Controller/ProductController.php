<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/create", name="product_create")
     */
    public function create(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product); 

        $form->handleRequest($request);

        // Quand le formulaire est valide
        if ($form->isSubmitted() && $form->isValid())
        {
        // On récupère Doctrine pour gérer la BDD
        $entityManager = $this->getDoctrine()->getManager();
        // On met en attente l'objet dans Doctrine
        $entityManager->persist($product);
        // Execute la requête (INSERT...)
        $entityManager->flush();
        }
                
        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
