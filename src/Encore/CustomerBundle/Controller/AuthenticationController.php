<?php

namespace Encore\CustomerBundle\Controller;

use Encore\CustomerBundle\Entity\Customer;
use Encore\CustomerBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

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
                $params = $form->getData();
                $invalid = $this->validateSignupParams($params);
                if ($invalid) {
                    var_dump($invalid);
                }
                $this->createUser($params);

                return $this->redirect($this->generateUrl("encore_complete_profile"));
            }
        }

        return $this->render("EncoreCustomerBundle:Authentication:signup.html.twig", ["form" => $form->createView()]);
    }

    /**
     * User which is not enabled complete information
     * @Route("/signup/complete-profile", name="encore_complete_profile")
     */
    public function completeInformationAction(Request $request)
    {
        // Only display form if user is logged in and not completed profile
        if ($this->isLoggedIn()) {
            $user = $this->authenticatedUser;
            if (!($user->isEnabled())) {

                $form = $this->createFormBuilder()
                    ->setAction('encore_complete_profile')
                    // Get First Email In Email Array
                    ->add(
                        'email',
                        'email',
                        [
                            // HTML Attributes
                            'attr' => [
                                'value' => $user->getEmails()[0]->getEmail(),
                                'disabled',
                                ''
                            ],
                            'label' => 'Email :'
                        ]
                    )
                    ->add('firstName', 'text', ['label' => 'First Name :'])
                    ->add('lastName', 'text', ['label' => 'Last Name :'])
                    ->add('birthDate', 'birthday', ['label' => 'Birth Date :'])
                    ->add('contactNo', 'number', ['label' => 'Contact No :'])
                    ->add('address', 'textarea', ['label' => 'Address :'])
                    ->add('edit', 'submit')
                    ->getForm();

                $form->handleRequest($request);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $this->completeInformation($user, $data);
                }

                return $this->render(
                    "EncoreCustomerBundle:User:profile.html.twig",
                    ['form' => $form->createView()]
                );
            }

            // If Enabled
            return $this->redirect($this->generateUrl('encore_home'));
        }

        // Invalid Access via url
        return $this->redirect($this->generateUrl('fos_user_security_login'));

    }

    private function completeInformation($user, $data)
    {
        if ($this->isLoggedIn()) {
            $request = $this->getRequest();

            if (($request->getMethod() === "POST") && ($request->request->get("encore_complete_profile"))) {
                $validate = $this->validateCustomerInfo($data);

                if ($validate["status"]) {
                    $success = $this->createCustomer($user, $data);

                    if ($success["status"]) {
                        // Redirect To Home Page
                        return $this->generateUrl("encore_customer_welcome");
                    }

                }
            }
        } else {
            return $this->render("EncoreCustomerBundle:Security:login.html.twig");
        }
    }

    /**
     * @param $user
     * @param $params
     *
     * @return array
     */
    private function createCustomer($user, $params)
    {
        $customer = new Customer();
        $customer->setUser($user)
            ->setFirstName($params["firstName"])
            ->setLastName($params["lastName"])
            ->setBirthDate($params["birthDate"])
            ->setContactNo($params["contactNo"])
            ->setAddress($params["address"]);

        $this->em->persist($customer);
        $this->em->flush();
        $user->setEnabled(true);
        $this->em->flush();

        return ["status" => true, "customer" => $customer];
    }

    /**
     * @param $params
     *
     * @return array
     */
    private function validateCustomerInfo($params)
    {
        $error = ["status" => true, "message" => ""];
        $entities = array("firstName", "lastName", "birthDate", "contactNo", "address");
        $count = count($entities);
        $i = 0;

        while ($i < $count) {
            if (!isset($params[$entities[$i]])) {
                $error["status"] = false;
                $error["message"] = $entities[$i] . " is required.";

                return $error;
            }

            $i++;
        }

        return $error;
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
        $email_exists = $this->em->getRepository('EncoreCustomerBundle:UserEmail')->findBy(array('email' => $email));

        if (count($email_exists)) {
            $status = 'error';
            $msg = 'Email belongs to another user';
        }

        $result = array('status' => $status, 'message' => $msg);

        return $result;
    }

    /**
     * @param $params
     *
     * @return array
     */
    private function validateSignupParams($params)
    {
        $error = [];

        if (!isset($params['email']) || str_replace(" ", "", $params['email']) == "") {
            $error['status'] = 'fail';
            $error['message'] = 'Email is required.';
        } else {
            $email_check = $this->validateEmail($params['email']);
            if ($email_check['status'] == 'error') {
                $error = $email_check;
            }
        }

        if (!isset($params['password']) || str_replace(" ", "", $params['password']) == "") {
            $error['status'] = 'fail';
            $error['message'] = 'Password is required.';
        }

//        if (!isset($params['username']) || str_replace(" ", "", $params['username']) == "") {
//            $error['status'] = 'fail';
//            $error['message'] = 'Username is required.';
//        }

        return $error;
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
//            ->add(
//                'username',
//                'text',
//                [
//                    'attr' => [
//                        'class' => 'signup-username',
//                        'placeholder' => 'Username',
//                        'data-required' => 'true',
//                        'data-trigger' => 'change',
//                        'data-required-message' => 'Please enter your username.',
//                    ],
//                    'label' => false
//                ]
//            )
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

    private function createUser($params)
    {
//        $now = new \DateTime();
        $userManager = $this->get('encore.user_manager');

        $user = new User();
        $user->setUsername($params['email']);
        $user->setEmail($params['email']);
        $array_role = array(
            User::ROLE_USER,
        );
        $user->setRoles($array_role);
//        $user->setSignedUpAt($now);
        $user->setEnabled(false);
        $fosUserManager = $this->get('fos_user.user_manager');
        $user->setPlainPassword($params['password']);
        $fosUserManager->updatePassword($user);

        $user_email = $userManager->createNewEmail($user);
        $user_email->setEmail($params['email']);

        $this->em->persist($user);
        $this->em->persist($user_email);
        $this->em->flush();

        $username = $user->getUserName() . '_' . $user->getId();

        $user->setUsername($username);

        $this->em->flush();

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());

        $this->get('security.context')->setToken($token);

        $this->get('session')->set('_security_customer', serialize($token));
    }
} 