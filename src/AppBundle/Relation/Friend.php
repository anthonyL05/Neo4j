<?php

namespace AppBundle\Relation ;

use Neo4jBundle\Entity\GlobalRelation;
use Neo4jBundle\Annotation\RelationClass;

/**
 *@RelationClass(name = "friend_with ")
 */
class Friend extends GlobalRelation
{
    public function __construct(){
        parent::__construct();
    }
}