<?php

/**
 * Created by PhpStorm.
 * User: antho
 * Date: 26/02/2017
 * Time: 19:36
 */


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Neo4jBundle\Annotation\Core;

/**
 * Class CoreApp
 * Class Exemple CoreApp for the base entity
 */
class CoreApp
{
    /**
     * @Core(collection="true" , name="Person")
     */
    private $person;

    /**
     * CoreApp constructor.
     */
    public function __construct()
    {
        $this->person = new ArrayCollection();
    }





}