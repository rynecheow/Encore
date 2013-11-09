<?php

namespace Encore\CustomerBundle\Controller;

use Encore\CustomerBundle\Entity\Customer;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Encore\CustomerBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProfileController extends BaseController
{
    /**
     * Logged In User Editing Its Profile
     *
     * @Route("/profile/{userId}/edit", name="encore_edit_profile")
     * @ParamConverter("user", class="EncoreCustomerBundle:User", options={"id" = "userId"})
     * @Method({"GET","POST"})
     */
    public function editAction(User $user)
    {
        $form = $this->createEditProfileForm();
        return $this->render(
            "EncoreCustomerBundle:User:editProfile.html.twig",
            ["form" => $form->createView()]
        );

//    {
//        $request = $this->getRequest();
//        if ($this->isLoggedIn()) {
//            if (!$this->authorizeRequest($request)) {
//                return $this->redirect(
//                    $this->generateUrl(
//                        'encore_view_profile',
//                        [
//                            'id' => $request->attributes->get('id'),
//                        ]
//                    )
//                );
//            }
//
//            /**
//             * @var $user User
//             */
//            $user = $this->authenticatedUser;
//            $request = $this->getRequest();
//            if (($user->isEnabled())) {
//                $editProfileForm = $this->createEditProfileForm();
//
//                if ($request->isMethod('POST')) {
//                    $editProfileForm->submit($request);
//                    if ($editProfileForm->isValid()) {
//                        $this->em->flush();
//
//                        if ($request->isXmlHttpRequest()) {
//                            return Response::create('', 204);
//                        }
//
//                        $this->pushFlashMessage('success', 'Profile saved');
//
//                        return $this->redirect(
//                            $this->generateUrl(
//                                'encore_view_profile',
//                                [
//                                    'id' => $request->attributes->get('id'),
//                                ]
//                            )
//                        );
//                    }
//                }
//
//                return $this->render(
//                    "EncoreCustomerBundle:User:editProfile.html.twig",
//                    array('form' => $editProfileForm->createView())
//                );
//            }
//
//            // If Not Enabled
//            return $this->redirect($this->generateUrl('encore_complete_profile'));
//        }
//
//        // Invalid Access via url
//        return $this->redirect($this->generateUrl('encore_login'));
    }

    /**
     * @Route("/profile/{id}", name="encore_view_profile")
     * @Method("GET")
     */
    public function viewAction()
    {
        if (!$this->isLoggedIn()) {

            $this->pushFlashMessage('error', 'Unauthorized Access');
            $this->gotoHome();
        }

        $form = $this->createEditProfileForm();

        return $this->render(
            "EncoreCustomerBundle:User:profile.html.twig",
            [
                'username' => 'kokhong'
                ,
                'email' => 'kokhong200gmail.com'
                ,
                'firstname' => 'Kok Hong'
                ,
                'lastname' => 'Choo'
                ,
                'birthdate' => '1991-08-26'
                ,
                'contactno' => '0123456789'
                ,
                'address' => 'ADDRESS THING Jalan Kuchai Lama 1/128b'
                ,
                "form" => $form->createView()
            ]
        );
    }

    /**
     * Authorizes the Request against the currently logged in user.
     *
     * @param Request $request
     *
     * @return boolean whether the ID in the Request belongs to the current user
     */
    private function authorizeRequest(Request $request)
    {
        $userId = $request->attributes->get('id');

        return ($this->authenticatedUser->getId() == $userId);
    }

    private function createEditProfileForm()
    {

        // Dummy Data
        $fname = 'Kok Hong';
        $lname = 'Choo';
        $bdate = '1991-08-26';
        $contactno = '0123456789';
        $address = 'ADDRESS THING Jalan Kuchai Lama 1/128b';

        ////////////
        return $this->createFormBuilder()
            ->setAction('encore_edit_profile')
            // Get First Email In Email Array
            ->add(
                'firstName',
                'text',
                [
                    'attr' => [
                        'class' => 'edit-text-box',
                        'placeholder' => $fname,
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your first name.',
                    ],
                    'label' => 'First Name'
                    ,
                    'label_attr' => array(
                        'class' => 'class-label'
                    )
                    ,'data' => $fname
                ]
            )
            ->add(
                'lastName',
                'text',
                [
                    'attr' => [
                        'class' => 'edit-text-box',
                        'placeholder' => $lname,
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your last name.',
                    ],
                    'label' => 'Last Name'
                    ,
                    'label_attr' => array(
                        'class' => 'class-label'
                    )
                    ,'data' => $lname
                ]
            )
            ->add(
                'birthDate',
                'text',
                [
                    'attr' => [
                        'class' => 'edit-bday',
                        'placeholder' => $bdate,
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your birth date.',
                    ],
                    'label' => 'Birth Date'
                    ,
                    'label_attr' => array(
                        'class' => 'class-label'
                    )
                    ,'data' => $bdate
                ]
            )
            ->add(
                'contactNo',
                'number',
                [
                    'attr' => [
                        'class' => 'edit-text-box',
                        'placeholder' => $contactno,
                        'data-required' => 'true',
                        'data-type' => 'digits',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your contact number.',
                    ],
                    'label' => 'Contact No'
                    ,
                    'label_attr' => array(
                        'class' => 'class-label'
                    )
                    ,'data' => $contactno
                ]
            )
            ->add(
                'address',
                'textarea',
                [
                    'attr' => [
                        'class' => 'edit-address',
                        'placeholder' => $address,
                        'data-required' => 'true',
                        'data-rangelength' => '[20,200]',
                        'data-trigger' => 'keyup',
                        'data-required-message' => 'Please enter your address.',

                    ],
                    'label' => 'Address'
                    ,
                    'label_attr' => array(
                        'class' => 'class-label'
                    )
                    ,'data' => $address
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