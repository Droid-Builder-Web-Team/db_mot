<?php

namespace App\Listeners;

use LightSaml\ClaimTypes;
use LightSaml\Model\Assertion\Attribute;
use CodeGreenCreative\SamlIdp\Events\Assertion;

class SamlAssertionAttributes
{
    public function handle(Assertion $event)
    {
        $event->attribute_statement
            ->addAttribute(new Attribute(ClaimTypes::GIVEN_NAME, auth()->user()->forename))
            //->addAttribute(new Attribute(ClaimTypes::COMMON_NAME, auth()->user()->username))
            ->addAttribute(new Attribute(ClaimTypes::SURNAME, auth()->user()->surname));
    }
}
