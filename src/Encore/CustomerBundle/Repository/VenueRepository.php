<?php

namespace Encore\CustomerBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * VenueRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VenueRepository extends EntityRepository
{

    public function findAllLocation()
    {
        return $this->getEntityManager()
            ->createQuery
            (
                "SELECT DISTINCT venue.location FROM EncoreCustomerBundle:Venue venue"
            )
            ->getResult();
    }
}
