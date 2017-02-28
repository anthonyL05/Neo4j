<?php
namespace AppBundle\Entity;

use Neo4jBundle\Annotation\Identifier;
use Neo4jBundle\Annotation\Relation;
use Neo4jBundle\Entity\GlobalEntity;


class Person extends GlobalEntity
{
    /**
     * @Identifier()
     */
    private $id;


    /**
     * @Relation( nameDb="is_friend" , nameRel="friends")
     */
    private $friend;


    public function __construct()
    {
        parent::__construct();
    }
}