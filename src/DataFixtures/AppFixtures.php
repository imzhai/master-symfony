<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <30; $i++){
        $product = new Product();
        $product->setName('iPhone Pépère'. " ".$i);
        $product->setDescription('Un smartPhone'. " ".$i);
        $product->setPrice(rand(500, 1500));
        $manager->persist($product);
    }

        $manager->flush();
    }
}
