<?php
/**
 * Created by PhpStorm.
 * User: Ryne Cheow
 * Date: 11/7/13
 * Time: 10:56 PM
 */

namespace Encore\MerchantBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Encore\CustomerBundle\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventController extends Controller
{
    use ControllerHelperTrait;
    /**
     * @Route("/events", name="encore_merchant_events")
     */
    public function indexAction()
    {
        return $this->render("EncoreMerchantBundle::Events:index.html.twig");
    }

    /**
     * @Route("/events/add", name="encore_merchant_add_event")
     */
    public function addAction(Request $request)
    {
        $newEvent = new Event();
        $createEventForm = $this->createEventForm($newEvent);
        $createEventForm->handleRequest($request);

        if ($createEventForm->isValid())
        {
//            $params = [];
//            $params = $createEventForm->getData();
//            $newEvent->setName($params["event_name"])
//                ->setType($params["event_type"])
//                ->setDescription($params["event_description"])
//                ->setSaleStart($params["event_sale_start"])
//                ->setSaleEnd($params["event_sale_end"])
//                ->setHeldDates($params["event_held_dates"])
//                ->setTotalTickets($params["event_total_tickets"]);

            // TODO: Photo and photo sequence

            $this->em->persist($newEvent);
            $this->em->flush();
            $this->pushFlashMessage("Success", "Event has been created");

            return $this->render("EncoreMerchantBundle::Events:index.html.twig");
        }

        return $this->render("EncoreMerchantBundle::Events:add-event.html.twig");
    }

    /**
     * @Route("/event/{id}/edit", name="encore_merchant_edit_event")
     * @ParamConverter("event", class="EncoreCustomerBundle:Event", options={"id" = "eventId"})
     * @Method({"GET","POST"})
     */
    public function editAction(Event $event)
    {
        $request = $this->getRequest();
        $editEventForm = $this->createEventForm($event);
        $editEventForm->handleRequest($request);

        if ($editEventForm->isValid())
        {
            $params = $editEventForm->getData();
            $event->setName($params["event_name"])
                ->setType($params["event_type"])
                ->setDescription($params["event_description"])
                ->setSaleStart($params["event_sale_start"])
                ->setSaleEnd($params["event_sale_end"])
                ->setHeldDates($params["event_held_dates"])
                ->setTotalTickets($params["event_total_tickets"])
                ->setVenue($params["event_venue"]);

            return $this->render("EncoreMerchantBundle::Events:index.html.twig");
        }

        return $this->render("EncoreMerchantBundle::Events:edit-event.html.twig");
    }

    private function createEventForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction('encore_signup')
            ->add(
                'email',
                'email',
                [
                    'attr' => [
                        'class' => 'signup-email',
                        'placeholder' => 'E-mail address',
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-type' => 'email',
                        'data-required-message' => 'Please enter your email.',
                        'data-type-email-message' => 'Your email address is incorrect',
                    ]
                    ,
                    'label' => false
                ]
            )
            ->add(
                'password',
                'password',
                [
                    'attr' => [
                        'class' => 'signup-password',
                        'id' => 'sg-pw',
                        'placeholder' => 'Password',
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your password.',
                        'data-minlength' => '8',
                        'data-minlength-message' => 'Short passwords are easy to guess. Try one with at least 8 characters.',
                    ],
                    'label' => false
                ]
            )
            ->add(
                'verifyPassword',
                'password',
                [
                    'attr' => [
                        'class' => 'signup-password',
                        'placeholder' => 'Verify Password',
                        'data-trigger' => 'change',
                        'data-equalto' => '#form_password',
                        'data-equalto-message' => 'You passwords do not match.',
                        'data-required' => 'true',
                        'data-required-message' => 'Please verify your password.',
                    ],
                    'label' => false
                ]
            )
            ->add(
                'agreement',
                'checkbox',
                [
                    'attr' => [
                        'id' => 'signup-agreement',
                        'class' => 'signup-agreement',
                        'placeholder' => 'Verify Password',
                        'data-trigger' => 'change',
                        'data-required' => 'true',
                        'data-required-message' => "In order to use our services, you must agree to Encore's Terms and Privacy.",
                    ],
                    'label' => false
                ]
            )
            ->add(
                'register',
                'submit',
                [
                    'attr' => [
                        'class' => 'submit',
                        'value' => 'Register'
                    ]
                ]
            )
            ->getForm();
    }
} 