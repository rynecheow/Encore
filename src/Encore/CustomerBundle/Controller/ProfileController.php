<?php

namespace Encore\CustomerBundle\Controller;

use Encore\CustomerBundle\Entity\Customer;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Encore\CustomerBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use DateTime;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

class ProfileController extends BaseController
{

    /**
     * @Route("/profile", name="encore_view_profile")
     * @Method({"GET","POST"})
     * @PreAuthorize("hasRole('ROLE_CUSTOMER')")
     */
    public function viewAction()
    {
        if (!$this->isLoggedIn()) {

            $this->pushFlashMessage('error', 'Unauthorized Access');
            $this->gotoHome();
        }

        /**
         * @var $user User
         */
        $user = $this->authenticatedUser;
        $customer = $user->getCustomer();

        if (!$customer) {
            throw $this->createNotFoundException("No customer found for id " . $customer->getId() . " WHYYYYY!");
        }

        $form = $this->createEditProfileForm($customer);
        $request = $this->getRequest();

        if ($request->getMethod() === "POST") {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $birthDate = DateTime::createFromFormat(
                    "Y-m-d",
                    $form->get("birthDate")->getData()
                );
                $customer->setBirthDate($birthDate);
                $this->em->flush();
            }
        }

        return $this->render(
            "EncoreCustomerBundle:User:profile.html.twig",
            [
                "customer" => $customer,
                "form" => $form->createView()
            ]
        );
    }

    /**
     * @param $customer \Encore\CustomerBundle\Entity\Customer
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createEditProfileForm($customer)
    {
        $birthDate = $customer->getBirthDate()->format("Y-m-d");

        return $this->createFormBuilder($customer)
            ->add(
                'firstName',
                'text',
                [
                    'attr' => [
                        'class' => 'edit-text-box',
                        'placeholder' => $customer->getFirstName(),
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your first name.',
                    ],
                    'label' => 'First Name'
                    ,
                    'label_attr' => [
                        'class' => 'class-label'
                    ]
                    ,
                    'data' => $customer->getFirstName()
                ]
            )
            ->add(
                'lastName',
                'text',
                [
                    'attr' => [
                        'class' => 'edit-text-box',
                        'placeholder' => $customer->getLastName(),
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your last name.',
                    ],
                    'label' => 'Last Name'
                    ,
                    'label_attr' => [
                        'class' => 'class-label'
                    ]
                    ,
                    'data' => $customer->getLastName()
                ]
            )
            ->add(
                'birthDate',
                'text',
                [
                    'attr' => [
                        'class' => 'edit-bday datepicker',
                        'placeholder' => $birthDate,
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your birth date.',
                        'readonly' => ''
                    ],
                    'label' => 'Birth Date'
                    ,
                    'label_attr' => [
                        'class' => 'class-label'
                    ]
                    ,
                    'data' => $birthDate
                ]
            )
            ->add(
                'contactNo',
                'number',
                [
                    'attr' => [
                        'class' => 'edit-text-box',
                        'placeholder' => $customer->getContactNo(),
                        'data-required' => 'true',
                        'data-type' => 'digits',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your contact number.',
                    ],
                    'label' => 'Contact No'
                    ,
                    'label_attr' => [
                        'class' => 'class-label'
                    ]
                    ,
                    'data' => $customer->getContactNo()
                ]
            )
            ->add(
                'address',
                'textarea',
                [
                    'attr' => [
                        'class' => 'edit-address',
                        'placeholder' => $customer->getAddress(),
                        'data-required' => 'true',
                        'data-rangelength' => '[20,200]',
                        'data-trigger' => 'keyup',
                        'data-required-message' => 'Please enter your address.',

                    ],
                    'label' => 'Address'
                    ,
                    'label_attr' => [
                        'class' => 'class-label'
                    ]
                    ,
                    'data' => $customer->getAddress()
                ]
            )
            ->add(
                'edit',
                'submit',
                [
                    'attr' => [
                        'class' => 'edit-submit'
                    ]
                ]
            )
            ->getForm();
    }
}