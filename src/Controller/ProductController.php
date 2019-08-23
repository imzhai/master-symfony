<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

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

    /** 
     * @Route("/product/demo", name="product_demo")
    */
    public function demo()
    {
        // Récupérer le repository de l'entité Product
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        // Récupérer tous les produits 
        $products = $productRepository->findAll();
        // dump($products);

        // Récupérer le produit avec l'id 3
        $product2 = $productRepository->find(3);

        // Récupérer le produit qui se nomme iPhone X

        // $productRepository->findOneByName('iPhone X');
        $product3 = $productRepository->findOneBy(['name' => 'iPhone X']);

        // Récupérer tous les produits qui coutent 1500 euros exacement
        $products1500 = $productRepository->findByPrice(1500);


        return $this->render('product/demo.html.twig', [
            'products' => $products,
            'product2' => $product2,
            'product3' => $product3,
            'products1500' => $products1500



        ]);


    }

}
