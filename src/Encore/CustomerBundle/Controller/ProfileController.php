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
    public function editAction(User $user){
        return $this->render(
               "EncoreCustomerBundle:User:editProfile.html.twig");

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
                'address' => 'ADDRESS THING adasdasdsadasdsadsadasdasdasdasdasdasd'
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
        return $this->createFormBuilder()
            ->setAction('encore_edit_profile')
            // Get First Email In Email Array
            ->add(
                'email',
                'email',
                [
                    // HTML Attributes
                    'attr' => [
                        'value' => $this->authenticatedUser->getEmails()[0],
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
    }
}