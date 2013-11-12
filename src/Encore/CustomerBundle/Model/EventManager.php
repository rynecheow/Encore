<?php

namespace Encore\CustomerBundle\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr;
use Encore\CustomerBundle\Entity\Event;
use Encore\CustomerBundle\Repository\EventRepository;

class EventManager
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var EventRepository
     */
    private $eventRepo;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;

        $this->eventRepo = $this->em->getRepository('EncoreCustomerBundle:Event');
    }

    /**
     * Gets featured events.
     *
     * @param integer|null $limit
     *
     * @return Event[]
     */
    public function getFeaturedEvents($limit = null)
    {
        $expr = $this->em->getExpressionBuilder();

        $predicates = [];
        $predicates[] = $expr->isNotNull('event.featuredAt');
        $predicates[] = self::createActivePredicate($expr);

        $predicate = call_user_func_array([$expr, 'andX'], $predicates);

        $eventPaginator = $this->eventRepo->getEvents(
            [
                'select' => ['event'],
                'predicate' => $predicate,
                'order_by' => ['event.featuredAt' => 'DESC'],
                'limit' => $limit,
            ]
        );

        return iterator_to_array($eventPaginator);
    }

    private static function createActivePredicate(Expr $expr)
    {
        $predicates = [];

        $predicates[] = $expr->andX(
            $expr->isNotNull('event.createAt'),
            $expr->isNotNull('event.publishedAt')
        );

        return call_user_func_array([$expr, 'andX'], $predicates);
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

        $eventPaginator = $this->eventRepo->getEvents(
            [
                'select' => ['event'],
                'predicate' => $predicate,
                'order_by' => ['event.createAt' => 'DESC'],
                'limit' => $limit,
            ]
        );

        return iterator_to_array($eventPaginator);
    }
}