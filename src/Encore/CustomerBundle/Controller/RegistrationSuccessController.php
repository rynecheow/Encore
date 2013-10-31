<?php

namespace Encore\CustomerBundle\Controller;

use Encore\CustomerBundle\Entity\Customer;

class RegistrationSuccessController extends BaseController
{

    public function showAction()
    {
        return $this->render("EncoreCustomerBundle:Registration:information.html.twig");
    }

    /**
     * @return array
     */
    public function completeInformationAction()
    {
        if ($this->isLoggedIn()) {
            $request = $this->getRequest();

            if (($request->getMethod() == "POST") && ($request->request->get("customer-information"))) {
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
        if($user){
            $customer = new Customer();
            $customer->setUser($user);
            $customer->setFirstName($params["first_name"]);
            $customer->setLastName($params["last_name"]);
            $customer->setBirthDate($params["birth_date"]);
            $customer->setContactNo($params["contact_no"]);
            $customer->setAddress($params["address"]);
            $customer->setCardInfo($params["card_info"]);

            $this->em->persist($customer);
            $this->em->flush();
            $user->setEnabled(true);
        }

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