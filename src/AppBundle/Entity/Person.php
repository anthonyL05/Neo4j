<?php

namespace AppBundle\Entity;

use Neo4jBundle\Annotation\Identifier;
use Neo4jBundle\Annotation\Relation;
use Neo4jBundle\Entity\GlobalEntity;


class Person extends GlobalEntity
{

    /**
      *@Identifier()
      */
    private $id;

    /**
     * @Relation(nameRel="PossedeLivre",nameDb="possede_livre",multiple="true",target="Livre")
     */
    private $livre;

    public function __construct(){
        parent::__construct();

    }                


 }