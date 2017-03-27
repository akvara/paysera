<?php

namespace spec\Paysera;

use Paysera\FileReader;
use PhpSpec\ObjectBehavior;

class FileReaderSpec extends ObjectBehavior
{
    const NO_FILE = 'no_such_file';

    function it_is_initializable()
    {

        $this->beConstructedWith(basename(__FILE__, '.php'));
        $this->shouldHaveType(FileReader::class);
    }

    function it_shoud_throw_exception_if_file_is_missing()
    {
        $this
            ->shouldThrow(new \Exception('File not found: ' . self::NO_FILE))
            ->during('__construct', [self::NO_FILE]);
    }
}
