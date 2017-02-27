<?php

/**
 * Created by PhpStorm.
 * User: antho
 * Date: 27/02/2017
 * Time: 14:58
 */
namespace Neo4jBundle\Entity ;


class GlobalEntity
{

    /** @var  \Doctrine\Common\Collections\ArrayCollection $class */
    private $class;

    /** @var  \Doctrine\Common\Collections\ArrayCollection $classPossible */
    private $classPossible;

    /** @var  \Doctrine\Common\Collections\ArrayCollection $relation */
    private $relation;

    /** @var  \Doctrine\Common\Collections\ArrayCollection $relationPossible */
    private $relationPossible;

    /**
     * generalEntity constructor.
     */
    public function __construct()
    {
        $class = new \Doctrine\Common\Collections\ArrayCollection();
        $relation = new \Doctrine\Common\Collections\ArrayCollection();
        $relation = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addClassPossible($nom)
    {
        $this->classPossible->add($nom);
    }


}