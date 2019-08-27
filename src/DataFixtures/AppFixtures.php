<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // Créer utilisateur
        $users = []; // Le tableau vas nous aider à stocker les instances des user
        for($i =0; $i<10; $i++){
            $user = new User();
            $user->setUsername('Username '.$i);
            $manager->persist($user);
            $users[] = $user;
        }

        // Créer les catégory
        $categories = []; // Le tableau vas nous aider à stocker les instances des user
        for($i =0; $i<10; $i++){
            $category = new Category();
            $category->setName('Caterory '.$i);
            $manager->persist($category);
            $categories[] = $category; // On met l'instance de côté
        }

        // Créer produit
        for($i = 0; $i <30; $i++){
            $product = new Product();
            $product->setName('iPhone Pépère'. " ".$i);
            $product->setDescription('Un smartPhone'. " ".$i);
            $product->setPrice(rand(500, 1500));
            // On associe le produit à une instance de user ($user correspond au dernier user créé)
            $product->setUser($users[rand(0, 9)]);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
