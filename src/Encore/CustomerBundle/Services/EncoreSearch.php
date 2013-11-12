<?php
/**
 * Created by PhpStorm.
 * User: rynecheow
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

        if (isset($qparams['keywords'])) {
            $search_results['query'] = $qparams['keywords'];

            if ($search_results['query'] !== '') {
                $events = $this->em->createQuery(
                    <<<SQL
                SELECT DISTINCT e.name, v.location, e.type, ep.imagePath, eh.heldDate
                FROM EncoreCustomerBundle:Event e
                INNER JOIN e.eventHolders eh
                INNER JOIN e.venue v
                INNER JOIN e.photos ep


                WHERE e.publishedAt IS NOT NULL
                AND(e.description LIKE :qkey
                OR e.name LIKE :qkey
                OR v.location LIKE :qkey)
                GROUP BY e.name, v.location
SQL
                )->setParameters(
                        [
                            'qkey' => '%' . $search_results['query'] . "%"
                        ]
                    )->setMaxResults($this->limit)
                    ->getResult();
                $bef_count = microtime(true);

                //Search query time
                $search_time = $bef_count - $bef;

                //Time taken for getting the search results
                $search_results['seconds']['searchq'] = $search_time;
            }

            $search_results['data']['events'] = $events;

            return $search_results;

        }
    }
} 