<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    
    private $encoder;
   
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    

    public function load(ObjectManager $manager)
    {
        //Appel de Faker
        $faker = Factory::create('fr-FR');  
        //Fixtues utilisateurs
        $users = [];
        $genres = ['male', 'female'];
        for ($i = 0 ; $i <=10 ; $i++){
            $user = new User();
            //Génère un élément aléatoire du tableau genre
            $genre = $faker->randomElement($genres);
            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';

            if($genre == 'male'){
                $picture = $picture . 'men/' . $pictureId;
            }
            else {
                $picture = $picture . 'women/' . $pictureId;
            }

            
            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstname($genre))
                    ->setLastName($faker->lastname)
                    ->setEmail($faker->email)
                    ->setIntroduction($faker->sentence())
                    ->setDescription('<p>'.join('</p><p>', $faker->paragraphs(3)).'</p>')
                    ->setHash($hash)
                    ->setPicture($picture);
            
            $manager->persist($user);
            $users[] = $user;

        }

        //Fixtures annonces
        for ($i = 0 ; $i <=30 ; $i++){
        $ad = new Ad();

        $title = $faker->sentence();   
        $coverImage = $faker->imageUrl(1000,350);
        $introduction = $faker->paragraph(2);

        /* une balise ouvrante + les elem du tableau paragraphe 
        qui sont séparés par une fin de paragraphe et un début de paragraphe */
        //$content = '<p>'.join('</p><p>', $faker->paragraphs(5)).'</p>'; 
        $content = '<p>'.join('</p><p>', $faker->paragraphs(5)).'</p>'; 
        $user = $users[mt_rand(0,count($users) - 1 )];
        //dump($content);


        $ad->setTitle($title)
            ->setCoverImage($coverImage)
            ->setIntroduction($introduction)
            ->setContent($content)
            ->setPrice(mt_rand(40, 200))
            ->setRooms(mt_rand(1,5))
            ->setAuthor($user);

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
