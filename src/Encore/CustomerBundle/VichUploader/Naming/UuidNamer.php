<?php

namespace Encore\CustomerBundle\VichUploader\Naming;

use Rhumsaa\Uuid\Uuid;
use Encore\CustomerBundle\Model\FileNamerInterface;

class UuidNamer implements FileNamerInterface
{
    /**
     * {@inheritDoc}
     */
    public function name($obj, $field)
    {
        // get the File instance using reflection
        $refObj = new \ReflectionObject($obj);
        $refProp = $refObj->getProperty($field);
        $refProp->setAccessible(true);
        $file = $refProp->getValue($obj);

        $extension = null;

        if ($extension = $file->guessExtension()) {
            // normalize JPEG file extension
            if ('jpeg' === $extension) {
                $extension = 'jpg';
            }
        }

        return $this->nameSimple($extension);
    }

    /**
     * {@inheritDoc}
     */
    public function nameSimple($extension = null)
    {
        // generate a UUID (version 4 - random)
        $uuid = Uuid::uuid4();

        // remove the dashes
        $name = str_replace('-', '', $uuid);

        // append the extension if specified
        if (!empty($extension)) {
            $name = sprintf('%s.%s', $name, $extension);
        }

        return $name;
    }

    /**
     * {@inheritDoc}
     */
    public function nameComplete($obj, $field, $extension = null)
    {
        return $this->nameSimple($extension);
    }
}
