<?php
/**
 * Created by PhpStorm.
 * User: LiHao
 * Date: 11/8/13
 * Time: 8:04 PM
 */

namespace Encore\MerchantBundle\Controller;

use Encore\CustomerBundle\Entity\Event;
use Encore\CustomerBundle\Entity\EventPhoto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class EventPhotoController extends Controller
{

    use ControllerHelperTrait;

    /**
     * @Route("/events/add/{eventId}/photo", name="encore_merchant_add_event_photo")
     * @ParamConverter("event", class="EncoreCustomerBundle:Event", options={"id" = "eventId"})
     * @Method({"GET","POST"})
     */
    public function addPhotoAction(Event $event)
    {
        $this->handleUploadRequest($event);
    }

    /**
     * @Route("/events/{eventId}/edit/photo", name="encore_merchant_event_edit_photo")
     * @ParamConverter("event", class="EncoreCustomerBundle:Event", options={"id" = "eventId"})
     * @Method({"GET","POST"})
     */
    public function editPhotoAction(Event $event)
    {
        $this->handleUploadRequest($event);
    }

    private function handleUploadRequest(Event $event)
    {
        $request = $this->getRequest();
        $eventPhoto = new EventPhoto();
        $eventPhotos = $this->em->getRepository("EncoreCustomerBundle:EventPhoto")
            ->findByEvent($event);
        $uploadPhotoForm = $this->uploadPhotoForm($eventPhoto);

        if ($request->getMethod() === "POST") {
            $uploadPhotoForm->handleRequest($request);

            if ($uploadPhotoForm->isValid()) {
                $eventPhoto->setEvent($event);
                $this->em->persist($eventPhoto);
                $this->em->flush();
                $event->addPhoto($eventPhoto);
                $this->em->flush();
                $eventPhotos = $this->em->getRepository("EncoreCustomerBundle:EventPhoto")
                    ->findByEvent($event);
            }
        }

        return $this->render(
            "EncoreMerchantBundle:Events:add-event-photo.html.twig",
            array(
                "form" => $uploadPhotoForm->createView(),
                "eventId" => $event->getId(),
                "uploadedPhotos" => $eventPhotos
            )
        );
    }

    /**
     * @param $eventPhoto
     * @return array
     */
    public function deletePhotoAction($eventPhoto)
    {
        $event = $eventPhoto->getEvent();
        $event->removePhoto($eventPhoto);
        $this->em->flush();
        $this->em->remove($eventPhoto);
        $this->flush();

        return [
            "status" => true
        ];
    }

    private function uploadPhotoForm($eventPhoto)
    {
        $form = $this->createFormBuilder($eventPhoto)
            ->add('caption', 'text')
            ->add('image', 'file')
            ->add('save', 'submit')
            ->getForm();

        return $form;
    }
}