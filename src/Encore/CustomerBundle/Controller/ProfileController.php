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
     * @Route("/profile/edit/{id}", name="encore_edit_profile", requirements={"id" = "\d+"})
     */
    public function editAction($request)
    {
        if ($this->isLoggedIn()) {
            $user = $this->authenticatedUser;
            if (($user->isEnabled())) {
                $form = $this->createFormBuilder()
                    ->setAction('encore_edit_profile')
                    // Get First Email In Email Array
                    ->add('email', 'email' , array(
                        // HTML Attributes
                        'attr' => array('value'=> $user->getEmails()[0],
                            'disabled', '' ),
                        'label' => 'Email :'
                    ))
                    ->add('firstName', 'text' , array('label' => 'First Name :'))
                    ->add('lastName', 'text', array('label' => 'Last Name :'))
                    ->add('birthDate', 'birthday', array('label' => 'Birth Date :'))
                    ->add('contactNo', 'number', array('label' => 'Contact No :'))
                    ->add('address', 'textarea', array('label' => 'Address :'))
                    ->add('edit','submit')
                    ->getForm();

                $form->handleRequest($request);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $valid = $this->editProfileAction($data);
                    if($valid['status'])
                    {
                        // show message indicate success?

                    }
                }

                return $this->render(
                    "EncoreCustomerBundle:User:profile.html.twig",
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
     * Edit Profile ( Logged in user)
     *
     * @param $data
     * @return array
     */
    private function editProfileAction($data)
    {
        //TODO Write $data posted by form into database and flush.
        return array('status' => true);
    }
    /**
     *
     * @param $data
     * @return Response
     */



} 