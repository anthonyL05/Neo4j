<?php

namespace AppBundle\Entity;

use Neo4jBundle\Annotation\Identifier;
use Neo4jBundle\Annotation\Relation;
use Neo4jBundle\Entity\GlobalEntity;
use AppBundle\Relation\Friend;
use Doctrine\Common\Collections\ArrayCollection;



class Person extends GlobalEntity
{

    /**
      *@Identifier()
      */
    private $id;

    /**
     * @Relation(nameRel="Friend",nameDb="friend_with",multiple="true")
     */
    private $friend;


    public function __construct(){
        parent::__construct();
		$this->friend = new ArrayCollection();
    }                
    public function getFriend()
    {
        return $this->friend;
    }                
    public function addFriend(Friend $friend)
    {
        $this->friend->add($friend);
        return $this;
    }                
    public function removeFriend(Friend $friend)
    {
        $this->friend->remove($friend);
        return $this;
    }

 }