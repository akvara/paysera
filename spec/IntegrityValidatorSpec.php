<?php

namespace spec\Paysera;

use Paysera\Config;
use Paysera\IntegrityValidator;
use PhpSpec\ObjectBehavior;
use org\bovigo\vfs\vfsStream;

class IntegrityValidatorSpec extends ObjectBehavior
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
        $this->shouldHaveType(IntegrityValidator::class);
    }

    function it_passes_correct_config_file()
    {
        $config_file_content = "COMPULSORY,123";

        vfsStream::newFile($this->fileName)->at($this->root)->withContent($config_file_content);

        $configs = [
            'format' => Config::CONFIG_FORMAT,
            'keys' => ['COMPULSORY']
        ];

        $this->validateFile($this->mockedFileName, $configs)->shouldReturn(null);
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

        $configs = ['format' => Config::CONFIG_FORMAT];


        $this
            ->shouldThrow(new \Exception($expectedException))
            ->during('validateFile', [$this->mockedFileName, $configs]);
    }

    function it_throws_exception_on_incorrect_config_file_format()
    {
        $config_file_content = "ABC,not-number";  // HERE is the the mitsake :)

        vfsStream::newFile($this->fileName)->at($this->root)->withContent($config_file_content);

        $expectedException = sprintf(
            "Unexpected type of column, file %s, line %d, column %d: expected Number",
            $this->mockedFileName,
            1,
            2
        );

        $configs = ['format' => Config::CONFIG_FORMAT];

        $this
            ->shouldThrow(new \Exception($expectedException))
            ->during('validateFile', [$this->mockedFileName, $configs]);
    }

    function it_throws_exception_on_missing_config_keys()
    {
        $config_file_content = "ABC,123";

        vfsStream::newFile($this->fileName)->at($this->root)->withContent($config_file_content);

        $configs = [
            'keys' => ['COMPULSORY'],
            'format' => Config::CONFIG_FORMAT
        ];

        $expectedException = sprintf(
            "Missing key %s in config file %s",
            'COMPULSORY',
            $this->mockedFileName
        );

        $this
            ->shouldThrow(new \Exception($expectedException))
            ->during('validateFile', [$this->mockedFileName, $configs]);
    }

    function it_passes_correct_user_file()
    {
        $config_file_content = "2016-01-05,1,natural,cash_in,200.00,EUR"; // Mitsake :)

        vfsStream::newFile($this->fileName)->at($this->root)->withContent($config_file_content);

        $configs = [
            'format' => Config::USER_DATA_FORMAT
        ];

        $this->validateFile($this->mockedFileName, $configs)->shouldReturn(null);
    }

    function it_throws_exception_on_wrong_date()
    {
        $config_file_content = "2016-66-77,1,natural,cash_in,200.00,EUR"; // Mitsake :)

        vfsStream::newFile($this->fileName)->at($this->root)->withContent($config_file_content);

        $configs = [
            'format' => Config::USER_DATA_FORMAT
        ];

        $expectedException = sprintf(
            "Incorrect date in file %s, line %d column %d",
            $this->mockedFileName,
            1,
            1
        );

        $this
            ->shouldThrow(new \Exception($expectedException))
            ->during('validateFile', [$this->mockedFileName, $configs]);
    }

    function it_throws_exception_on_wrong_enum()
    {
        $config_file_content = "2016-01-05,1,naturalist,cash_in,200.00,EUR"; // Mitsake :)

        vfsStream::newFile($this->fileName)->at($this->root)->withContent($config_file_content);

        $configs = [
            'format' => Config::USER_DATA_FORMAT
        ];

        $expectedException = sprintf(
            "Invalid value in file %s, line %d column %d",
            $this->mockedFileName,
            1,
            3
        );

        $this
            ->shouldThrow(new \Exception($expectedException))
            ->during('validateFile', [$this->mockedFileName, $configs]);
    }
}
