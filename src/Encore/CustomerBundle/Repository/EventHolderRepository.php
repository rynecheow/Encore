<?php
namespace Encore\CustomerBundle\Repository;
use Doctrine\ORM\EntityRepository;
/**
 * EventHolderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventHolderRepository extends EntityRepository
{
    public function findAllEventHolderByEventIdAndHeldDate($eventId, $heldDate)
    {
        return $this->getEntityManager()
            ->createQuery
            (
                <<<SQL
                SELECT eventHolder FROM EncoreCustomerBundle:EventHolder eventHolder
                WHERE eventHolder.eventId = :eventId AND eventHolder.heldDate = :heldDate
SQL
            )
            ->setParameter($eventId, $heldDate)
            ->getResult();
    }
    public function findEventHolderIdByEventIdAndEventDateTime($id, $selectedDateTime)
    {
        $query = $this->getEntityManager()
            ->createQuery
            (
                <<<SQL
                SELECT eh FROM EncoreCustomerBundle:EventHolder eh
                JOIN eh.event e
                WHERE e.id = :eventId AND eh.heldDate = :heldDate
SQL
            );
        $query = $query->setParameters(
            [
                "eventId" => $id,
                "heldDate" => $selectedDateTime,
            ]
        );
        return $query->getResult();
    }
    public function findAllEventVenueSectionsByEventHolderId($eventHolder)
    {
        $query = $this->getEntityManager()
            ->createQuery
            (
                <<<SQL
                SELECT es FROM EncoreCustomerBundle:EventSection es
                WHERE es.eventHolder = :eventHolder
SQL
            );
        $query = $query->setParameters(
            [
                "eventHolder" => $eventHolder,
            ]
        );
        return $query->getResult();
    }
    public function findAllEventTimeByEventId($eventId)
    {
        $query = $this->getEntityManager()
            ->createQuery
            (
                <<<SQL
                SELECT eh.heldDate FROM EncoreCustomerBundle:EventHolder eh
                JOIN eh.event e
                WHERE e.id = :id
SQL
            );
        $query = $query->setParameters(
            [
                "id" => $eventId,
            ]
        );
        return $query->getResult();
    }
    public function findEventSectionByEventSectionId($eventSectionId)
    {
        $query = $this->getEntityManager()
            ->createQuery
            (
                <<<SQL
                SELECT esect FROM EncoreCustomerBundle:EventSection esect
                WHERE esect.id = :id
SQL
            );
        $query = $query->setParameters(
            [
                "id" => $eventSectionId,
            ]
        );
        return $query->getResult();
    }
    public function findSeatsByEventSection($eventSection)
    {
        $query = $this->getEntityManager()
            ->createQuery
            (
                <<<SQL
                SELECT eseat FROM EncoreCustomerBundle:EventSeat eseat
                WHERE eseat.eventSection = :esect
SQL
            );
        $query = $query->setParameters(
            [
                "esect" => $eventSection,
            ]
        );
        return $query->getResult();
    }
}