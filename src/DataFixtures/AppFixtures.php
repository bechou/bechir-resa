<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //Appel de Faker
        $faker = Factory::create('fr-FR');  
        $slugify = new Slugify();

        for ($i = 0 ; $i <=30 ; $i++){
        $ad = new Ad();

        $title = $faker->sentence();   
        $slug = $slugify->slugify($title);
        $coverImage = $faker->imageUrl(1000,350);
        $introduction = $faker->paragraph(2);

        /* une balise ouvrante + les elem du tableau paragraphe 
        qui sont séparés par une fin de paragraphe et un début de paragraphe */
        $content = '<p>'.join('</p><p>', $faker->paragraphs(5)).'</p>'; 
        //var_dump($content);


        $ad->setTitle($title)
            ->setSlug($slug)
            ->setCoverImage($coverImage)
            ->setIntroduction($introduction)
            ->setContent($content)
            ->setPrice(mt_rand(40, 200))
            ->setRooms(mt_rand(1,5));
        $manager->persist($ad); 
        }

        $manager->flush();
    }
}
