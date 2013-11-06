<?php

namespace Encore\CustomerBundle\Controller;

use Encore\CustomerBundle\Entity\Customer;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Encore\CustomerBundle\Entity\User;

class ProfileController extends BaseController
{
    /**
     * Logged In User Editing Its Profile
     * @Route("/profile/edit", name="encore_edit_profile")
     */
    public function editAction()
    {
        if ($this->isLoggedIn()) {
            /**
             * @var $user User
             */
            $user = $this->authenticatedUser;
            $request = $this->getRequest();
            if (($user->isEnabled())) {
                $form = $this->createFormBuilder()
                    ->setAction('encore_edit_profile')
                    // Get First Email In Email Array
                    ->add(
                        'email',
                        'email',
                        [
                            // HTML Attributes
                            'attr' => [
                                'value' => $user->getEmails()[0],
                                'disabled',
                                ''
                            ],
                            'label' => 'Email'
                        ]
                    )
                    ->add(
                        'firstName',
                        'text',
                        [
                            'label' => 'First Name'
                        ]
                    )
                    ->add(
                        'lastName',
                        'text',
                        [
                            'label' => 'Last Name'
                        ]
                    )
                    ->add(
                        'birthDate',
                        'birthday',
                        [
                            'label' => 'Birth Date'
                        ]
                    )
                    ->add(
                        'contactNo',
                        'number',
                        [
                            'label' => 'Contact No :'
                        ]
                    )
                    ->add(
                        'address',
                        'textarea',
                        [
                            'label' => 'Address'
                        ]
                    )
                    ->add('edit', 'submit')
                    ->getForm();

                $form->handleRequest($request);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $valid = []; //TODO VALIDATE DATA

                    if ($valid['status']) {
                        // show message indicate success?

                    }
                }

                return $this->render(
                    "EncoreCustomerBundle:User:editProfile.html.twig",
                    array('form' => $form->createView())
                );
            }

            // If Not Enabled
            return $this->redirect($this->generateUrl('encore_complete_profile'));
        }

        // Invalid Access via url
        return $this->redirect($this->generateUrl('encore_login'));
    }

    /**
     * @Route("/profile/{username}", name="encore_view_profile")
     */
    public function viewAction($username)
    {

    }
}