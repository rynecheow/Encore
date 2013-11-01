<?php

namespace Encore\CustomerBundle\Model;

use Doctrine\ORM\EntityManager;
use Encore\CustomerBundle\Entity\Event;

class EventManager {

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em){
        $this->em = $em;

        $this->eventRepo = $this->em->getRepository('EncoreCustomerBundle:Event');
        $this->productCategoryRepo = $this->em->getRepository('EncoreCustomerBundle:EventCategory');
    }

    /**
     * Gets featured events.
     *
     * @param integer|null $limit
     *
     * @return Event[]
     */
    public function getFeaturedEvents($limit = null){

    }


}