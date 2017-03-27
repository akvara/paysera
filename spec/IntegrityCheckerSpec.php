<?php

namespace spec\Paysera;

use Paysera\Config;
use Paysera\IntegrityChecker;
use PhpSpec\ObjectBehavior;
use org\bovigo\vfs\vfsStream;

class IntegrityCheckerSpec extends ObjectBehavior
{
    private $root;
    private $fileName;
    private $mockedFileName;

    function let()
    {
        $this->root = vfsStream::setup('dir');
        $this->fileName = "config.csv";
        $this->mockedFileName = vfsStream::url("dir/" . $this->fileName);
    }

    function it_is_initializable()
    {
        $configs = ['name' => ['format' => Config::CONFIG_FORMAT]];

        $this->beConstructedWith($configs);

        $this->shouldHaveType(IntegrityChecker::class);
    }

    function it_passes_correct_config_file()
    {
        $config_file_content = "ABC,123";

        vfsStream::newFile($this->fileName)->at($this->root)->withContent($config_file_content);

        $configs = [$this->mockedFileName => ['format' => Config::CONFIG_FORMAT]];

        $this->beConstructedWith($configs);

        $this->check()->shouldReturn(true);
    }

    function it_throws_exception_on_wrong_config_file_column_count()
    {
        $config_file_content = "ABC,123,wtf";  // HERE is the the mitsake :)

        vfsStream::newFile($this->fileName)->at($this->root)->withContent($config_file_content);

        $expectedException = sprintf(
            "Unexpected number of columns, file %s, line %d: expected %d, found %d",
            $this->mockedFileName,
            1,
            count(Config::CONFIG_FORMAT),
            3
        );

        $configs = [$this->mockedFileName => ['format' => Config::CONFIG_FORMAT]];

        $this->beConstructedWith($configs);

        $this
            ->shouldThrow(new \Exception($expectedException))
            ->during('check');
    }

    function it_throws_exception_on_incorrect_config_file_format()
    {
        $config_file_content = "ABC,not-number";  // HERE is the the mitsake :)

        vfsStream::newFile($this->fileName)->at($this->root)->withContent($config_file_content);

        $expectedException = sprintf(
            "Unexpected type of column, file %s, line %d: expected Number",
            $this->mockedFileName,
            1
        );

        $configs = [$this->mockedFileName => ['format' => Config::CONFIG_FORMAT]];

        $this->beConstructedWith($configs);

        $this
            ->shouldThrow(new \Exception($expectedException))
            ->during('check');
    }

    function it_throws_exception_on_missing_config_keys()
    {
        $config_file_content = "ABC,123";

        vfsStream::newFile($this->fileName)->at($this->root)->withContent($config_file_content);

        $configs = [
            $this->mockedFileName => [
                'keys' => ['COMPULSORY'],
                'format' => Config::CONFIG_FORMAT
            ]
        ];

        $this->beConstructedWith($configs);

        $expectedException = sprintf(
            "Missing key %s in config file %s",
            'COMPULSORY',
            $this->mockedFileName
        );

        $this
            ->shouldThrow(new \Exception($expectedException))
            ->during('check');
    }
}
