<?php

namespace Encore\CustomerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EncoreCustomerBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
