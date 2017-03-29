<?php

namespace spec\Paysera\Validator;

use Paysera\Validator\SystemIntegrityValidator;
use PhpSpec\ObjectBehavior;

/**
 * Class SystemIntegrityValidatorSpec
 * @package spec\Paysera\Validator
 */
class SystemIntegrityValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(["EUR" => 0.01], ["EUR" => 1]);
        $this->shouldHaveType(SystemIntegrityValidator::class);
    }
}
