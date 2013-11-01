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
     * @Route("/signup/complete-profile", name="encore_complete_profile")
     */
    public function completeInformationAction(Request $request)
    {
        // Only display form if user is logged in and not completed profile
        if ($this->isLoggedIn()) {

            $user = $this->authenticatedUser;
            if (!($user->isEnabled())) {
                $user = $this->authenticatedUser;
                $customer = new Customer();
                $form = $this->createFormBuilder()
                    ->add('email', 'email')
                    ->add('firstName', 'text')
                    ->add('lastName', 'text')
                    ->add('birthDate', 'birthday')
                    ->add('contactNo', 'number')
                    ->add('address', 'textarea')
                    ->add('edit', 'submit')
                    ->getForm();

                $form->handleRequest($request);
                //TODO: server side validation
                if ($form->isValid()) {
                    $data = $form->getData();
                    //TODO: handle data
                }

                return $this->render(
                    "EncoreCustomerBundle:User:profile.html.twig",
                    array('form' => $form->createView())
                );
            }

            return $this->redirect($this->generateUrl('encore_home'));
        }

        return $this->redirect($this->generateUrl('encore_login'));

    }

    /**
     * @Route("/profile/edit/{id}
     */
    public function editAction(){

    }
    /**
     * @return array
     */
    //TODO: combine this function with the function above
    public function completeInfoAction()
    {
        if ($this->isLoggedIn()) {
            $request = $this->getRequest();

            if (($request->getMethod() === "POST") && ($request->request->get("customer-information"))) {
                //TODO: REDIRECT USER to COMPLETE INFORMATION
                $params = $request->request->get("customer-information");
                $validate = $this->validateCustomerInfo($params);

                if ($validate["status"]) {
                    $success = $this->createCustomer($params);

                    if ($success["status"]) {
                        return $success["customer"];
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
            ->setFirstName($params["first_name"])
            ->setLastName($params["last_name"])
            ->setBirthDate($params["birth_date"])
            ->setContactNo($params["contact_no"])
            ->setAddress($params["address"])
            ->setCardInfo($params["card_info"]);

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
        $entities = array("first_name", "last_name", "birth_date", "contact_no", "address");
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