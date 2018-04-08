
<?php

namespace Webfit\MO\SecurityBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WebfitMOSecurityBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
