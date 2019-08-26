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
     * @Route ("/", name="accueil" ) 
     */
    public function accueil()
    {
        // On récupère les produits les plus chers
        $products = $this->getDoctrine()->getRepository(Product::class)->findMoreExpensive(8);

        return $this->render('product/home.html.twig', [
            'products' => $products,
        ]);
    }  


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

        $this->addFlash('success', 'le produit a été créé !');

        return $this->redirectToRoute('products');

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
        $product2 = $productRepository->find(255);

        // Récupérer le produit qui se nomme iPhone X

        // $productRepository->findOneByName('iPhone X');
        $product3 = $productRepository->findOneBy(['name' => 'Un produit de Dinguo']);

        // Récupérer tous les produits qui coutent 1500 euros exacement
        $products1500 = $productRepository->findByPrice(1209);

        // Récupérer le produit le plus cher
        $productExpensive = $productRepository->findOneGreaterThanPrice(1400);


        return $this->render('product/demo.html.twig', [
            'products' => $products,
            'product2' => $product2,
            'product3' => $product3,
            'products1500' => $products1500,
            'product_expensive' => $productExpensive,
        ]);
    }

    /**
     * @Route ("/product", name="products")
     */
    public function list()
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findAll();

        return $this->render('product/product.html.twig', [
            'products' => $products,
        ]);
    }

    /** 
     * @Route ("/product/{id}", name="product_show")
     */
    public function show(Product $product) // Dans la version commentée, on mettra le paramètre $id
    {
        // $product = $this->getDoctrine()
        //     ->getRepository(Product::class)
        //     ->find($id);

        // // Si le produit n'existe pas
        // if(!$product){
        //     throw $this->createNotFoundException();
        // }


        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }


    /** 
     * @Route("/product/edit/{id}", name="product_edit") 
     */
    public function edit(Request $request,Product $product)
    {
        //Sert juste à créer le template dans la vue
        $form = $this->createForm(ProductType::class, $product); 

        $form->handleRequest($request);

        // Quand le formulaire est valide
        if ($form->isSubmitted() && $form->isValid())
        {
        // On récupère Doctrine pour gérer la BDD
        $entityManager = $this->getDoctrine()->getManager();
        // Execute la requête (INSERT...)
        $entityManager->flush();

        $this->addFlash('success', 'le produit a été modifié');

        return $this->redirectToRoute('products');

        }
        


        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),

        ]);

    }

    /** 
     * @Route ("/product/delete/{id}", name="product_delete") 
     */
    public function delete(Product $product)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($product);
        // On execute la requête DELETE
        $entityManager->flush();

        $this->addFlash('success', 'le produit a été supprimé');
        //redirection vers la liste
        return $this->redirectToRoute('product_list');
    }






}

