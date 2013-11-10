<?php
/**
 * Created by PhpStorm.
 * User: sysadm
 * Date: 11/9/13
 * Time: 7:19 PM
 */

namespace Encore\CustomerBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class EncoreSearch
{

    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var int
     */
    private $limit;

    public function __construct(EntityManager $em, Request $req)
    {
        $this->em = $em;
        $this->request = $req;
        $this->limit = 100;
    }

    public function performFullSearch($qparams = [])
    {
        $bef = microtime(true);
        $events = [];
        $search_results = [];
        $user_id = $qparams['user_id'];

        if (isset($qparams['q'])) {
            $search_results['query'] = $qparams['q'];

            // Default type is 'events'
            if (isset($qparams['type'])) {
                $type = $qparams['type'];
            } else {
                $type = "events";
            }

            if (isset($qparams['limit'])) {
                $limit = $qparams['limit'];
            } else {
                $limit = 16;
            }

            $bef_count = microtime(true);

            if (strpos($search_results['query'], "@") > 0) {
                $search_results = $this->em->createQuery(
                    <<<SQL
                                    SELECT *
                FROM EncoreCustomerBundle:Event event ,
                EncoreCustomerBundle:EventHolder event_holder,
                EncoreCustomerBundle:Venue venue
                JOIN event.venue venue
                JOIN event.eventHolders event_holders

                WHERE event.name = :qname
                AND event.venue = :qvenue
                AND event.heldDates BETWEEN :qfromdate AND :qtodate
SQL
                )->setParameters(
                        [
                            'qname' => $qparams["event-name"],
                            'qvenue' => $qparams["event-venue"],
                            'qfromdate' => $qparams["event-from"],
                            'qtodate' => $qparams["event-to"]
                        ]
                    )
                    ->setMaxResults(1)
                    ->getResult();
            }


        }
    }
} 