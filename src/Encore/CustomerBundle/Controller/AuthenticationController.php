<?php

namespace Encore\CustomerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends BaseController{

    /**
     * @Route("/signup", name="encore_signup")
     */
    public function signupAction() {
        if($this->isLoggedIn())
        {
            return $this->redirect($this->generateUrl( 'encore_home' ));
        }
        $request = $this->getRequest();
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
        if($request->getMethod() === "POST"){
            return $this->render("EncoreCustomerBundle:Authentication:signup.html.twig", ["error"=>"error"]);
        }
        return $this->render("EncoreCustomerBundle:Authentication:signup.html.twig",["error"=>""]);
    }

    /**
     * @Route("/validate-email", name="encore_validate_email")
     * @Method("POST")
     */
    public function validateEmailAction() {

        if ($email = $this->getRequest()->get('email')) {
            $result = $this->validateEmail($email);
        }
        $return = json_encode([
                $result['status'] => $result['message'],
            ]);
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
} 