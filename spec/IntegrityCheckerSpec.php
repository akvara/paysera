<?php

namespace spec\Paysera;

use Paysera\Config;
use Paysera\FileReader;
use Paysera\IntegrityChecker;
use PhpSpec\ObjectBehavior;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

class IntegrityCheckerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(IntegrityChecker::class);
    }

    function it_passes_correct_config_file()
    {
        $config_file_name = "config.csv";
        $config_file_content = "ABC,123";
        $mocked_file = vfsStream::url("dir/" . $config_file_name);

        $root = vfsStream::setup('dir');
        vfsStream::newFile($config_file_name)->at($root)->withContent($config_file_content);

        $this->check([$mocked_file => Config::CONFIG_FORMAT])->shouldReturn(true);
    }

    function it_throws_exception_on_incorrect_config_file()
    {
        $config_file_name = "config.csv";
        $config_file_content = "ABC,123,wtf";
        $mocked_file = vfsStream::url("dir/" . $config_file_name);

        $root = vfsStream::setup('dir');
        vfsStream::newFile($config_file_name)->at($root)->withContent($config_file_content);
        $expectedException = sprintf(
            "Unexpected number of columns, file: %s, expected %d, found %d",
            $mocked_file,
            count(Config::CONFIG_FORMAT),
            3
        );

        $this
            ->shouldThrow(new \Exception($expectedException))
            ->during('check', [[$mocked_file => Config::CONFIG_FORMAT]]);
    }

}
