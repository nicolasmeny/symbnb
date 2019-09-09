<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');

        for($i = 1; $i <= 30; $i++ ){
            $ad = new Ad();

            $paragraph = join('</p><p>',$faker->paragraphs(mt_rand(3,5)));
            $title = $faker->sentence();

            $ad->setTitle($title)
               ->setCoverImage($faker->imageUrl(1000,350))
               ->setIntroduction($faker->paragraph(2))
               ->setContent("<p>$paragraph</p>")
               ->setPrice(mt_rand(40,200))
               ->setRooms(mt_rand(1,5));

               for ($j=0; $j < mt_rand(2,5); $j++) { 
                    $image = new Image();

                    $image->setUrl($faker->imageUrl())
                          ->setCaption($faker->sentence())
                          ->setaD($ad);
                    $manager->persist($image);
               }
    
            $manager->persist($ad);
        }
        $manager->flush();
    }
}
