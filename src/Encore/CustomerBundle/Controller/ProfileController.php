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
                    $this->completeInfoAction($data);
                }

                return $this->render(
                    "EncoreCustomerBundle:User:profile.html.twig",
                    array('form' => $form->createView())
                );
            }
            // If Enabled
            return $this->redirect($this->generateUrl('encore_home'));
        }
        // Invalid Access via url
        return $this->redirect($this->generateUrl('fos_user_security_login'));

    }

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
    private function completeInfoAction($data)
    {
        if ($this->isLoggedIn()) {
            $request = $this->getRequest();

            if (($request->getMethod() === "POST") && ($request->request->get("encore_complete_profile"))) {
                $validate = $this->validateCustomerInfo($data);

                if ($validate["status"]) {
                    $success = $this->createCustomer($data);

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
     * @param $params
     *
     * @return array
     */
    private function createCustomer($params)
    {
        $user = $this->authenticatedUser;
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

        return array("status" => true, "customer" => $customer);
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
} 