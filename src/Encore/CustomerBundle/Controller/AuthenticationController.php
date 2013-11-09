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

        return $error;
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

    private function createUser($params)
    {
//        $now = new \DateTime();
        /**
         * @var $userManager \Encore\CustomerBundle\Services\EncoreUserManager
         */
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

        $token = new UsernamePasswordToken($user, null, 'customer', $user->getRoles());

        $this->get('security.context')->setToken($token);

        $this->get('session')->set('_security_customer', serialize($token));
    }

    /**
     * User which is not enabled complete information
     * @Route("/signup/complete-profile", name="encore_complete_profile")
     */
    public function completeInformationAction(Request $request)
    {
        // Only display form if user is logged in and not completed profile
        if ($this->isLoggedIn()) {
            /**
             * @var $user \Encore\CustomerBundle\Entity\User
             */
            $user = $this->authenticatedUser;
            if (!($user->isEnabled())) {
                $form = $this->createCompleteProfileForm();

                $form->handleRequest($request);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $validate = $this->validateCustomerInfo($data);

                    if ($validate["status"]) {
                        $success = $this->createCustomer($user, $data);

                        if ($success["status"]) {
                            // Redirect To Home Page
                            return $this->redirect($this->generateUrl("encore_home"));
                        }
                    }
                }

                return $this->render(
                    "EncoreCustomerBundle:User:complete-information.html.twig",
                    ['form' => $form->createView()]
                );
            }

            // If Enabled
            return $this->redirect($this->generateUrl('encore_home'));
        }

        // Invalid Access via url
        return $this->redirect($this->generateUrl('fos_user_security_login'));
    }

    /**
     * Complete Profile Form
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createCompleteProfileForm()
    {
        return $this->createFormBuilder()
            ->setAction('encore_complete_profile')
            ->add(
                'username',
                'text',
                [
                    'attr' => [
                        'class' => 'complete-profile-username',
                        'placeholder' => 'Username',
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your user name.',
                    ],
                    'label' => false
                ]
            )
            ->add(
                'firstName',
                'text',
                [
                    'attr' => [
                        'class' => 'complete-profile-fname',
                        'placeholder' => 'First Name',
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your first name.',
                    ],
                    'label' => false
                ]
            )
            ->add(
                'lastName',
                'text',
                [
                    'attr' => [
                        'class' => 'complete-profile-lname',
                        'placeholder' => 'Last Name',
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your last name.',
                    ],
                    'label' => false
                ]
            )
            ->add(
                'birthDate',
                'birthday',
                [
                    'attr' => [
                        'class' => 'complete-profile-birthday',
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter select your birthday.',
                    ],
                    'label' => 'Date Of Birth',
                    'empty_value' => ['year' => 'Year', 'month' => 'Month', 'day' => 'Day']
                ]
            )
            ->add(
                'contactNo',
                'number',
                [
                    'attr' => [
                        'class' => 'complete-profile-contactno',
                        'placeholder' => 'Contact No.',
                        'data-required' => 'true',
                        'data-type' => 'digits',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your contact number.',
                    ],
                    'label' => false
                ]
            )
            ->add(
                'address',
                'textarea',
                [
                    'attr' => [
                        'class' => 'complete-profile-address',
                        'placeholder' => 'Address',
                        'data-required' => 'true',
                        'data-rangelength' => '[20,200]',
                        'data-trigger' => 'keyup',
                        'data-required-message' => 'Please enter your address.',
                    ],
                    'label' => false
                ]
            )
            ->add(
                'complete registration',
                'submit',
                [
                    'attr' => [
                        'class' => 'submit',
                        'value' => 'Complete registration'
                    ]
                ]
            )
            ->getForm();
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
     * @param $user \Encore\CustomerBundle\Entity\User
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
            ->setAddress($params["address"])
            ->setUsername($params["username"]);

        $user->setUsername($params["username"]);
        $this->em->persist($customer);
        $this->em->flush();
        $user->setEnabled(true);
        $this->em->flush();

        return ["status" => true, "customer" => $customer];
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

        if($result)

        $response = new Response();
        $response = [
            "code" => $result["message"] === "error" ? 400 : 200,
            "status" => $result["message"] === "error" ? false : true,
        ];

        return json_encode($response);
    }

    private function validateUsername($username)
    {
        $status = 'success';
        $msg = 'OK';
        $user_exist = $this->em->getRepository('EncoreCustomerBundle:User')->findUserBySlug($username);

        if (count($user_exist)) {
            $status = 'error';
            $msg = 'Username belongs to another user';
        }

        $result = array('status' => $status, 'message' => $msg);

        return $result;
    }
} 