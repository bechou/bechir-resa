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
        //Appel de Faker
        $faker = Factory::create('fr-FR');  

        for ($i = 0 ; $i <=30 ; $i++){
        $ad = new Ad();

        $title = $faker->sentence();   
        $coverImage = $faker->imageUrl(1000,350);
        $introduction = $faker->paragraph(2);

        /* une balise ouvrante + les elem du tableau paragraphe 
        qui sont séparés par une fin de paragraphe et un début de paragraphe */
        //$content = '<p>'.join('</p><p>', $faker->paragraphs(5)).'</p>'; 
        $content = '<p>'.join('</p><p>', $faker->paragraphs(5)).'</p>'; 
        //dump($content);


        $ad->setTitle($title)
            ->setCoverImage($coverImage)
            ->setIntroduction($introduction)
            ->setContent($content)
            ->setPrice(mt_rand(40, 200))
            ->setRooms(mt_rand(1,5));

        for ($j = 0 ; $j < mt_rand(2,5) ; $j++)
        {
            $image = new Image();

            $image->setUrl($faker->imageUrl())
                ->setCaption($faker->sentence())
                ->setAd($ad); //annonce à laquelle l'image est liée

                $manager->persist($image);
        }
             $manager->persist($ad); 

        }

        $manager->flush();
    }
}
