<?php
namespace Encore\CustomerBundle\Controller;

use Encore\CustomerBundle\Entity\Customer;
use Encore\CustomerBundle\Entity\User;
use Encore\CustomerBundle\Entity\UserEmail;

class AuthenticationController extends BaseController
{

    public function signupAction()
    {
        if ($this->isLoggedIn()) {
            return $this->redirect($this->generateUrl('home'));
        }
        $request = $this->getRequest();
        if ($request->getMethod() === "POST") {
            if ($request->request->get('signup-data')) {
                $params = $request->request->get('signup-data');
                $invalid = $this->validateSignupParameters($params);
                if ($invalid) {
                    return $invalid;
                }
                $success = $this->createCustomerUser($params);

                if ($success['status'] == 'success') {
                    if (!$success['message']) {
                        return array('status' => 'success', 'responseData' => $success['data']);
                    }
                }

                return $success;
            } // validateEmail
            elseif ($request->request->get('email')) {
                return $this->validateEmail($request->request->get('email'));
            }
        }

        return [];
    }

    private function createCustomerUser($params)
    {
        $now = new \DateTime();
        $userManager = $this->get('encore.user_manager');
        $user = new User();
        $user->setUsername($params['email']);

        $array_role = array(
            User::ROLE_NORMAL,
        );

        $user->setRoles($array_role);
        $user->setEnabled(false);
        //PASSWORD PART
        $fosUserManager = $this->get('fos_user.user_manager');
        $user->setPlainPassword($params['password']);
        $fosUserManager->updatePassword($user);
        //PASSWORD PART

        //create user email
        $user_email = $userManager->createNewEmail($user);
        $user_email->setEmail($params['email']);
        $user->setPrimaryEmail($user_email);
        //end create user email

        $this->em->persist($user);
        $this->em->persist($user_email);
        $this->em->flush();

        $user->setUsername($user->getUserName() . '_' . $user->getId());
        $this->em->flush();

        $return = array(
            'status' => 'success',
            'data' => array(
                'id' => $user->getId(),
                'email' => $params['email']
            ),
        );

        return $return;
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

    private function validateSignupParameters($params)
    {
        $error = array();

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
} 