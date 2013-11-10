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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventPhotoController extends Controller
{

    use ControllerHelperTrait;

    /**
     * @Route("/events/add/photo", name="encore_merchant_add_event_photo")
     */
    public function testAction()
    {
        $request = $this->getRequest();
        $eventPhoto = new EventPhoto();
        $form = $this->createFormBuilder($eventPhoto)
                     ->add('image', 'file')
                     ->add('save', 'submit')
                     ->getForm();
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $this->em->persist($eventPhoto);
            $this->em->flush();
        }

        return $this->render("EncoreMerchantBundle:Events:add-event-photo.html.twig", array(
                "form" =>$form->createView()
            ));
    }


    public function addPhotosAction(Event $event)
    {
        $photos = [];
        $request = $this->getRequest();
        $controlPhotoForm = $this->controlPhotoForm($photos);
        $controlPhotoForm->handleRequest($request);

        if ($controlPhotoForm->isValid()) {
            $photos = $controlPhotoForm->getData();

            foreach ($photos as $photo) {
                $eventPhoto = new EventPhoto();
                $eventPhoto->setEvent($event)
                    ->setImage($photo);
                $this->em->persist($eventPhoto);
                $this->em->flush();
                $event->addPhoto($eventPhoto);
            }

            return $this->render("EncoreMerchantBundle::Events:index.html.twig");
        }

        return $this->render("EncoreMerchantBundle::Events:add-event-photo.html.twig");
    }

    public function editPhotosAction(Event $event)
    {
        $photos = [];
        $eventPhotos = $event->getPhotos();

        /**
         * @var $eventPhoto \Encore\CustomerBundle\Entity\EventPhoto
         */

        foreach ($eventPhotos as $eventPhoto) {
            $photos[] = $eventPhoto->getImage();
        }

        $request = $this->getRequest();
        $controlPhotoForm = $this->controlPhotoForm($photos);
        $controlPhotoForm->handleRequest($request);

        if ($controlPhotoForm->isValid()) {
            $photos = $controlPhotoForm->getData();

            foreach ($photos as $photo) {
                $eventPhoto = $this->em->getRepository("EncoreCustomerBundle:EventPhoto")
                    ->findByImage($photo);
                $exist = count($eventPhoto);

                if ($exist == 0) {
                    $eventPhoto = new EventPhoto();
                    $eventPhoto->setEvent($event)
                        ->setImage($photo);
                    $this->em->persist($eventPhoto);
                    $this->em->flush();
                    $event->addPhoto($eventPhoto);
                }
            }

            return $this->render("EncoreMerchantBundle::Events:index.html.twig");
        }

        return $this->render("EncoreMerchantBundle::Events:edit-event-photo.html.twig");
    }

    /**
     * @param $photo \Doctrine\Common\Collections\Collection
     *
     * @return array
     */
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