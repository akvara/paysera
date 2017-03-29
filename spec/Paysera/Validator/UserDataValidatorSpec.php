<?php

namespace spec\Paysera\Validator;

use Paysera\Validator\UserDataValidator;
use PhpSpec\ObjectBehavior;

class UserDataValidatorSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->beConstructedWith(["EUR" => 0.01], 'file');
        $this->shouldHaveType(UserDataValidator::class);
    }
}
