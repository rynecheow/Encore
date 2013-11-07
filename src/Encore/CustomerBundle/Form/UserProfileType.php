<?php
///**
// * Created by PhpStorm.
// * User: Ryne Cheow
// * Date: 11/7/13
// * Time: 11:35 AM
// */
//
//namespace Encore\CustomerBundle\Form;
//
//use Encore\CustomerBundle\Entity\Customer;
//use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\OptionsResolver\OptionsResolverInterface;
//
//class UserProfileType extends AbstractType
//{
//    const EDIT_PROFILE_MODE = 1;
//
//    /**
//     * @var integer
//     */
//    private $mode;
//
//    /**
//     * @param integer $mode
//     */
//    public function __construct($mode)
//    {
//        $this->mode = $mode;
//    }
//
//    public function buildForm(FormBuilderInterface $builder, array $options)
//    {
//        // common fields for "settings" and "edit profile" modes
//        if (self::EDIT_PROFILE_MODE === $this->mode) {
//            $builder
//                ->add(
//                    'name',
//                    'text',
//                    [
//                        'label' => 'Name',
//                        'attr' => [
//                            'placeholder' => 'Name',
//                        ],
//                    ]
//                )
//                ->add(
//                    'birthday',
//                    'birthday',
//                    [
//                        'label' => 'Date of Birth',
//                        'format' => 'd MMMM yyyy',
//                        'widget' => 'choice',
//                        'years' => range(1900, date('Y')),
//                        'empty_value' => [
//                            'year' => 'Year',
//                            'month' => 'Month',
//                            'day' => 'Day',
//                        ],
//                    ]
//                )->add(
//                    'about',
//                    'textarea',
//                    [
//                        'label' => 'About yourself',
//                        'attr' => [
//                            'placeholder' => 'Something about you',
//                        ],
//                    ]
//                )
//                ->add(
//                    'locationName',
//                    'text',
//                    [
//                        'label' => 'Location',
//                        'attr' => [
//                            'placeholder' => 'Add current city',
//                        ],
//                    ]
//                )
//                ->add(
//                    'countryCode',
//                    'country',
//                    [
//                        'preferred_choices' => [
//                            'MY',
//                        ],
//                    ]
//                )
//        }
//    }
//
//    public function setDefaultOptions(OptionsResolverInterface $resolver)
//    {
//        $resolver->setDefaults(
//            [
//                'data_class' => 'Encore\CustomerBundle\Entity\Customer',
//                'required' => false,
//            ]
//        );
//    }
//
//    public function getName()
//    {
//        return 'encore_user_profile';
//    }
//}
