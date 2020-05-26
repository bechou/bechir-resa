<?php

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;

class PaginationService {
    private $entityClass;
    private $limit = 10;
    private $currentPage = 1;
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }


    public function getData()
    {
        $offset = $this->currentPage * $this->limit - $this->limit;
         
        $repo = $this->manager->getRepository($this->entityClass);
        $data = $repo->findBy([], [], $this->limit, $offset);

        return $data;
    
    }

    //Nombre de pages
    public function getPages()
    {
        $repo = $this->manager->getRepository($this->entityClass);
        $total = count($repo->findAll());

        $pages= ceil($total / $this->limit);

        return $pages;
    }

    public function getEntityClass()
    {
        return $this->entityClass;
    }

    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setlimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    //Page actuel
    public function getPage()
    {
        return $this->currentPage;
    }

    public function setPage($page)
    {
        $this->currentPage = $page;

        return $this;
    }



}
