<?php

namespace Encore\CustomerBundle\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr;
use Encore\CustomerBundle\Entity\Event;

class EventManager {

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em){
        $this->em = $em;

        $this->eventRepo = $this->em->getRepository('EncoreCustomerBundle:Event');
//        $this->eventCategoryRepo = $this->em->getRepository('EncoreCustomerBundle:EventCategory');
    }


    private static function createActivePredicate(Expr $expr)
    {
        $predicates = [];

        $predicates[] = $expr->andX(
            $expr->isNotNull('event.createAt')
        );

        return call_user_func_array([$expr, 'andX'], $predicates);
    }

    /**
     * Gets featured events.
     *
     * @param integer|null $limit
     *
     * @return Event[]
     */
    public function getFeaturedEvents($limit = null){
        $expr = $this->em->getExpressionBuilder();

        $predicates = [];
        $predicates[] = $expr->isNotNull('event.featuredAt');
        $predicates[] = self::createActivePredicate($expr);

        $predicate = call_user_func_array([$expr, 'andX'], $predicates);

        $eventPaginator = $this->eventRepo->getEvents([
                'select' => ['event'],
                'predicate' => $predicate,
                'order_by' => ['event.featuredAt' => 'DESC'],
                'limit' => $limit,
            ]);

        return iterator_to_array($eventPaginator);
    }


    /**
     * Gets new events.
     * note: this only sorts events by latest date
     *
     * @param integer|null $limit
     *
     * @return Event[]
     */
    public function getNewEvents($limit = null)
    {
        $expr = $this->em->getExpressionBuilder();

        $predicate = self::createActivePredicate($expr);

        $eventPaginator = $this->eventRepo->getEvents([
                'select' => ['event'],
                'predicate' => $predicate,
                'order_by' => ['event.createAt' => 'DESC'],
                'limit' => $limit,
            ]);

        return iterator_to_array($eventPaginator);
    }
}