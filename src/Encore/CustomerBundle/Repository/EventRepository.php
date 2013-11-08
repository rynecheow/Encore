<?php

namespace Encore\CustomerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Encore\CustomerBundle\Util\QueryHelper;
use Doctrine\ORM\QueryBuilder;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends EntityRepository
{
    /**
     * Gets events.
     *
     * @param array $options
     *     - string[]                   ["select"]    the associated entities to load
     *     - \Doctrine\ORM\Query\Expr\* ["predicate"] the expression for conditional filtering
     *     - array                      ["order_by"]  the fields to order results by
     *     - integer                    ["offset"]    the number of results to skip
     *     - integer                    ["limit"]     the number of results to fetch
     *
     * @return Paginator
     */
    public function getEvents(array $options)
    {
        $select = isset($options['select']) ? $options['select'] : null;
        $predicate = isset($options['predicate']) ? $options['predicate'] : null;
        $orderBy = isset($options['order_by']) ? $options['order_by'] : null;
        $offset = isset($options['offset']) ? $options['offset'] : null;
        $limit = isset($options['limit']) ? $options['limit'] : null;

        if (!$select) {
            // default to the bare necessities
            $select = ['event'];
        }

        $qb = $this->createQueryBuilderWithJoins()
            ->select($select)
            ->distinct();

        if ($predicate) {
            $qb->where($predicate);
        }

        if ($orderBy) {
            QueryHelper::processOrderBy($qb, $orderBy);
        }

        if ($offset) {
            $qb->setFirstResult($offset);
        }

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        return new Paginator($qb, true);
    }

    public function createQueryBuilderWithJoins()
    {
        $qb = $this->createQueryBuilder('event');

        return $qb;

    }
}
