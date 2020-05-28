<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(ObjectManager $manager)
    {

        $users = $manager->createQuery('SELECT count(u) FROM App\Entity\User u')->getSingleScalarResult();
        $ads = $manager->createQuery('SELECT count(a) FROM App\Entity\Ad a')->getSingleScalarResult();
        $bookings = $manager->createQuery('SELECT count(b) FROM App\Entity\Booking b')->getSingleScalarResult();
        $comments = $manager->createQuery('SELECT count(c) FROM App\Entity\Comment c')->getSingleScalarResult();

        $bestAds = $manager->createQuery(
            'SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture
             FROM App\Entity\Comment c 
             JOIN c.ad a
             JOIN a.author u
             GROUP BY a
             ORDER BY note DESC'
             )->setMaxResults(5)
             ->getResult();

        $worstAds = $manager->createQuery(
            'SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture
            FROM App\Entity\Comment c 
            JOIN c.ad a
            JOIN a.author u
            GROUP BY a
             ORDER BY note ASC'
            )->setMaxResults(5)
             ->getResult();         

        //compact() : permet de créer un tab automatiquement en nommant les clés. Elles auront les mêmes noms que les variables
        return $this->render('admin/dashboard/index.html.twig', [
            'stats' => compact('users', 'ads', 'bookings', 'comments'),
            'bestAds' => $bestAds,
            'worstAds' => $worstAds
            
        ]);
    }
}
