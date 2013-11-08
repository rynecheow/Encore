<?php
/**
 * Created by PhpStorm.
 * User: sysadm
 * Date: 11/8/13
 * Time: 8:04 PM
 */

namespace Encore\MerchantBundle\Controller;


use Encore\CustomerBundle\Entity\Event;
use Encore\CustomerBundle\Entity\EventPhoto;

class EventPhotoController extends BaseController
{
    /**
     * @Route("/events/add／photo", name="encore_merchant_add_event_photo")
     */
    public function addPhotosAction(Event $event)
    {
        $request = $this->getRequest();
        $photos = $request->files->get("photos");

        if ($photos)
        {
            foreach ($photos as $photo)
            {
                $eventPhoto = new EventPhoto();
                $eventPhoto->setEvent($event)
                           ->setImage($photo);
                $this->em->persist($eventPhoto);
                $this->em->flush();
                $event->addPhoto($eventPhoto);
            }
        }

        return [
            "status" => true
        ];
    }

    public function editPhotosAction(Event $event)
    {
        $request = $this->getRequest();
        $photos = $request->files->get("photos");


        if ($photos)
        {
            foreach ($photos as $photo)
            {
                $eventPhoto = $this->em->getRepository("EncoreCustomerBundle:EventPhoto")
                     ->findByImage($photo);
                $exist = count($eventPhoto);

                if ($exist == 0)
                {
                    $eventPhoto = new EventPhoto();
                    $eventPhoto->setEvent($event)
                               ->setImage($photo);
                    $this->em->persist($eventPhoto);
                    $this->em->flush();
                    $event->addPhoto($eventPhoto);
                }
            }
        }
    }

    public function deletePhotoAction($photo)
    {
        $eventPhoto = $this->em->getRepository("EncoreCustomerBundle:EventPhoto")
                           ->findByImage($photo);
        $event = $eventPhoto->getEvent();
        $event->removePhoto($eventPhoto);
        $this->em->flush();

        return [
            "status" => true
        ];
    }

    /**
     * @param $photos array of photo's path
     */
    private function controlPhotoForm($photos)
    {
        //TODO: create upload and remove photo form
    }
}