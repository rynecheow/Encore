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
        return $this->handleUploadRequest($event);
    }

    /**
     * @Route("/events/{eventId}/edit/photo", name="encore_merchant_event_edit_photo")
     * @ParamConverter("event", class="EncoreCustomerBundle:Event", options={"id" = "eventId"})
     * @Method({"GET","POST"})
     */
    public function editPhotoAction(Event $event)
    {
        return $this->handleUploadRequest($event);
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
            [
                "form" => $uploadPhotoForm->createView(),
                "eventId" => $event->getId(),
                "uploadedPhotos" => $eventPhotos
            ]
        );
    }


    /**
     *
     * @Route("/delete-photo", name="encore_merchant_delete_photo")
     * @Method("POST")
     *
     * @return Response
     */
    public function deletePhotoAction()
    {
        $request = $this->getRequest();
        $imageURL = $request->get("eventPhoto");
        $eventPhotos = $this->em->getRepository("EncoreCustomerBundle:EventPhoto")
                           ->findByImagePath($imageURL);

        if (count($eventPhotos) === 0)
        {
            $response = [
                "code" => "404",
                "status" => false,
                "message" => "Photo not found."
            ];
        }

        else
        {
            foreach ($eventPhotos as $eventPhoto)
            {
                $event = $eventPhoto->getEvent();
                $event->removePhoto($eventPhoto);
                $this->em->flush();
                $this->em->remove($eventPhoto);
                $this->em->flush();
            }

            $response = [
                "code" => "200",
                "status" => true,
                "message" => "Photo has been removed successfully."
            ];
        }

        return new Response(json_encode($response));
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