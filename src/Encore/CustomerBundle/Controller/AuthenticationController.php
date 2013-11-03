<?php

namespace Encore\CustomerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AuthenticationController extends BaseController
{

    /**
     * @Route("/signup", name="encore_signup")
     */
    public function signupAction(Request $request)
    {
        if ($this->isLoggedIn()) {
            return $this->redirect($this->generateUrl('encore_home'));
        }

        $form = $this->createSignUpForm();

        if ($request->getMethod() === "POST") {
            $form->handleRequest($request);
            if ($form->isValid()) {
                die($request->request->get('email'));
            }
        }
//        $request = $this->getRequest();
//        if ($request->getMethod() === "POST") {
//            // signup process
//            if ( $request->request->get( 'signup-data' ) ) {
//                $params = $request->request->get( 'signup-data' );
//                $invalid = $this->validateSignupParams($params);
//                if($invalid)
//                {
//                    return $invalid;
//                }
//                $success = $this->createUser($params);
//
//                if($success['status'] == 'success')
//                {
//                    if(!$success['message'])
//                    {
//                        return array('status'=>'success','responseData'=>$success['data']);
//                    }
//                }
//                return $success;
//            }
//            // validateEmail
//            elseif ($request->request->get('email')) {
//                return $this->validateEmail( $request->request->get('email') );
//            }
//        }
//        return [];


        return $this->render("EncoreCustomerBundle:Authentication:signup.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route("/validate-email", name="encore_validate_email")
     * @Method("POST")
     */
    public function validateEmailAction()
    {

        if ($email = $this->getRequest()->get('email')) {
            $result = $this->validateEmail($email);
        }
        $return = json_encode(
            [
                $result['status'] => $result['message'],
            ]
        );
        $response = new Response();
        $response->setStatusCode(200);
        $response->setContent($return);

        return $response;
    }

    private function validateEmail($email)
    {
        $status = 'success';
        $msg = 'OK';
        $email_exists = $this->em->getRepository('EncoreUserBundle:UserEmail')->findBy(array('email' => $email));

        if (count($email_exists)) {
            $status = 'error';
            $msg = 'Email belongs to another user';
        }

        $result = array('status' => $status, 'message' => $msg);

        return $result;
    }

    /**
     * Sign Up Form
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createSignUpForm()
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
                'username',
                'text',
                [
                    'attr' => [
                        'class' => 'signup-username',
                        'placeholder' => 'Username',
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your username.',
                    ],
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
                'register',
                'submit',
                [
                    'attr' => [
                        'class' => 'submit',
                        'value' => 'Register'
                    ]
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

            ->getForm();
    }
} 