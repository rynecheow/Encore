<?php
/**
 * Created by PhpStorm.
 * User: rynecheow
 * Date: 11/1/13
 * Time: 11:30 PM
 */

namespace Encore\CustomerBundle\Util;

use Doctrine\ORM\QueryBuilder;

class QueryHelper
{

    public static function processOrderBy(QueryBuilder $qb, array $orderBy = [])
    {
        $alias = current($qb->getDQLPart('from'))->getAlias();

        foreach ($orderBy as $sort => $order) {
            if (false === strpos($sort, '.')) {
                $sort = "{$alias}.{$sort}";
            }
            $qb->addOrderBy($sort, $order);
        }
    }

    /**
     * Adds a date between where statement to QueryBuilder.
     *
     * @param QueryBuilder $qb
     * @param string|array $dateBetween
     *
     * @return array $parameters
     * @throws \Exception
     */
    public static function whereDateBetween(QueryBuilder $qb, $dateBetween)
    {
        $startDate = $qb->expr()->gte("o.sendAt", ":startDate");
        $endDate = $qb->expr()->lte("o.sendAt", ":endDate");

        if (is_string($dateBetween)) {
            switch ($dateBetween) {
                case 'today':
                    $parameters = [
                        'startDate' => new \DateTime('midnight'),
                        'endDate' => new \DateTime('tomorrow')
                    ];
                    break;
                case 'tomorrow':
                    $parameters = [
                        'startDate' => new \DateTime('yesterday'),
                        'endDate' => new \DateTime('today')
                    ];
                    break;
                case 'this week':
                    $parameters = [
                        'startDate' => new \DateTime('this week last sunday'),
                        'endDate' => new \DateTime('this week next saturday')
                    ];
                    break;
                default:
                    throw new \Exception('Date not found, try to specify your own date.');
            }
        } elseif (is_array($dateBetween)) {
            if ((isset($dateBetween[0]) && is_a($dateBetween[0], 'DateTime')) && (isset($dateBetween[1]) && is_a(
                        $dateBetween[1],
                        'DateTime'
                    ))
            ) {
                $parameters = [
                    'startDate' => $dateBetween[0],
                    'endDate' => $dateBetween[1]
                ];
            } else {
                throw new \Exception('$dateBetween is not an instances of DateTime object.');
            }
        } else {
            throw new \Exception('$dateBetween is neither string or array.');
        }

        $qb->andWhere($qb->expr()->andX($startDate, $endDate))
            ->setParameter('startDate', $parameters['startDate'])
            ->setParameter('endDate', $parameters['endDate']);
    }
}
