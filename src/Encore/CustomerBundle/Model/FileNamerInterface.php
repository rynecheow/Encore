<?php
/**
 * Created by PhpStorm.
 * User: sysadm
 * Date: 11/10/13
 * Time: 4:11 PM
 */

namespace Encore\CustomerBundle\Model;

use Vich\UploaderBundle\Naming\NamerInterface;

interface FileNamerInterface extends NamerInterface
{
    /**
     * Names a file using a simple scheme.
     *
     * @param string|null $extension The file extension.
     *
     * @return string
     */
    public function nameSimple($extension);

    /**
     * Names a file using a complete scheme.
     *
     * @param object $obj The object.
     * @param string $field The object's field name.
     * @param string|null $extension The file extension.
     *
     * @return string
     */
    public function nameComplete($obj, $field, $extension);
}
