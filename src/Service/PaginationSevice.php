<?php
namespace App\Service;

use Twig\Environment;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;


class PaginationSevice{


    private $entityClass;
    
    private $limit;

    private $currentPage=1;

    private $manager;
    private $twig;

    private $route;

    private $templatePath;

    public function __construct(ObjectManager $manager,Environment $twig,RequestStack
    $request ,$templatePath){

        $this->manager=$manager;
        $this->twig=$twig;

        $this->route=$request->getCurrentRequest()->attributes->get('_route');

        $this->templatePath=$templatePath;
    }

    public function setTemplatePath($templatePath){

         $this->templatePath=$templatePath;

         return $this;
    }
    
    public function getTemplatePath($templatePath){

       return  $this->templatePath;

        
   }

    public function display(){

        $this->twig->display($this->templatePath,[

            'page'=>$this->currentPage,
            'pages'=>$this->getPages(),
            'route'=>$this->route
        ]);
    }

    public function getPages(){

        $repo=$this->manager->getRepository($this->entityClass);

        $total=count($repo->findAll());

        $pages=ceil($total/$this->limit);

        return $pages;
    }

    public function getData(){

        //calculer l'offset
        $offset=$this->currentPage* $this->limit-$this->limit;
        //demande au repo
        $repo=$this->manager->getRepository($this->entityClass);
        $data=$repo->findBy([],[],$this->limit, $offset);
        //envoyer les element

        return $data;
    }
    public function setPage($currentPage){

        $this->currentPage=$currentPage;
        return $this;
    }

    public function getPage(){

        return $this->currentPage;
    }

    public function setLimit($limit){

        $this->limit=$limit;

        return $this;
    }

    public function getLimit(){

        return $this->limit;
    }

    public function setEntityClass($entityClass){

        $this->entityClass=$entityClass;

        return $this;
    }

    public function getEntityClass(){

        return $this->entityClass;

    }

}

