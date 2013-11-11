<?php
/**
 * Created by PhpStorm.
 * User: rynecheow
 * Date: 11/11/13
 * Time: 4:29 PM
 */

namespace Encore\MerchantBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Validator\Constraints as Assert;
use Encore\MerchantBundle\Services\ValidatorHelper;

class FileTypeExtension extends AbstractTypeExtension
{

    /**
     * @var ValidatorHelper
     */
    private $validatorHelper;

    public function __construct(ValidatorHelper $validatorHelper)
    {
        $this->validatorHelper = $validatorHelper;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $mimeTypes = null;
        $maxSize = null;

        $parentData = $form->getParent()->getData();

        if (null !== $parentData) {
            $propertyPath = $form->getPropertyPath();
            if ($propertyPath->getLength() > 0) {
                // get the property name associated with this "file" field
                // this is the last element in the property path
                $propertyName = $propertyPath->getElement($propertyPath->getLength() - 1);

                // get the validation constraints for the property
                $constraints = $this->validatorHelper->getPropertyConstraints(
                    get_class($parentData),
                    $propertyName
                );

                foreach ($constraints as $constraint) {
                    if ($constraint instanceof Assert\File) {
                        $mimeTypes = $constraint->mimeTypes;
                        $maxSize = $constraint->maxSize;
                    }
                }
            }
        }

        // set a "mime_types" variable that will be available when rendering this field
        $view->vars['mime_types'] = $mimeTypes;
        $view->vars['max_size'] = $maxSize;
    }

    public function getExtendedType()
    {
        return 'file';
    }
}
