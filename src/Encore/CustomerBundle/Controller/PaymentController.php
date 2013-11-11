<?php
/**
 * Created by PhpStorm.
 * User: sysadm
 * Date: 11/9/13
 * Time: 2:50 PM
 */

namespace Encore\CustomerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PaymentController extends BaseController
{

    /**
     * @Route("/payment",name="encore_payment")
     */
    public function paymentAction()
    {
        return $this->render("EncoreCustomerBundle:Payment:payment-gateway.html.twig");
    }

    /**
     * @Route("/summary",name="encore_summary")
     */
    public function summaryAction()
    {
        return $this->render("EncoreCustomerBundle:Payment:summary.html.twig");
    }

    private function createPaymentForm()
    {
        return $this->createFormBuilder()
            ->setAction('encore_edit_profile')
            // Get First Email In Email Array
            ->add(
                'cardnumber',
                'text',
                [
                    'attr' => [
                        'class' => 'payment-text-box',
                        'placeholder' => $fname,
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your first name.',
                    ],
                    'label' => 'First Name'
                    ,
                    'label_attr' => [
                        'class' => 'class-label'
                    ]
                    ,
                    'data' => $fname
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
                    'label_attr' => [
                        'class' => 'class-label'
                    ]
                    ,
                    'data' => $lname
                ]
            )
            ->add(
                'birthDate',
                'text',
                [
                    'attr' => [
                        'class' => 'edit-bday datepicker',
                        'placeholder' => $bdate,
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your birth date.',
                    ],
                    'label' => 'Birth Date'
                    ,
                    'label_attr' => [
                        'class' => 'class-label'
                    ]
                    ,
                    'data' => $bdate
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
                    'label_attr' => [
                        'class' => 'class-label'
                    ]
                    ,
                    'data' => $contactno
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
                    'label_attr' => [
                        'class' => 'class-label'
                    ]
                    ,
                    'data' => $address
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