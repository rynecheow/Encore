<?php
/**
 * Created by PhpStorm.
 * User: rynecheow
 * Date: 11/11/13
 * Time: 4:27 PM
 */

namespace Encore\MerchantBundle\Services;

use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraint;

class ValidatorHelper
{

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Gets all validation constraints for the specified property.
     *
     * @param string $className
     * @param string $propertyName
     *
     * @throws \RuntimeException if no metadata is found for $className
     * @throws \RuntimeException if no metadata is found for $propertyName
     *
     * @return Constraint[]
     */
    public function getPropertyConstraints($className, $propertyName)
    {
        $classMetadata = $this->validator->getMetadataFactory()->getMetadataFor($className);

        if (!($classMetadata instanceof ClassMetadata)) {
            throw new \RuntimeException(sprintf('Failed to get class metadata for %s', $className));
        }

        $propertyMetadatas = $classMetadata->getPropertyMetadata($propertyName);

        if (empty($propertyMetadatas)) {
            throw new \RuntimeException(sprintf('Failed to get property metadata for %s', $propertyName));
        }

        return $propertyMetadatas[0]->constraints;
    }

    /**
     * Validates a URL.
     *
     * @param string   $url     the URL to check
     * @param string[] $schemes the accepted protocols
     *
     * @return boolean whether the URL is valid
     */
    public function validateUrl($url, array $schemes = array('http', 'https'))
    {
        $urlConstraint = new Constraints\Url();

        $errorList = $this->validator->validateValue($url, $urlConstraint);

        return (0 === count($errorList));
    }
}
