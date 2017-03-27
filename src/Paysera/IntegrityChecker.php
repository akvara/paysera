<?php

namespace Paysera;

class IntegrityChecker
{
    /** @var array  */
    private $configs;

    /**
     * IntegrityChecker constructor.
     * @param array $configs
     */
    public function __construct(array $configs)
    {
        $this->configs = $configs;
    }

    /**
     * @return bool
     */
    public function check()
    {
        foreach ($this->configs as $fileName => $fileSpec) {
            $reader = new FileReader($fileName);
            $handle = $reader->getHandle();

            $row = 0;
            $keys = [];

            while (($data = fgetcsv($handle, 0, Config::DELIMITER)) !== FALSE) {
                $row++;
                $keys[] = $data[0];
                $this->checkColumnCount($data, $fileSpec['format'], $fileName, $row);
                $this->checkColumnTypes($data, $fileSpec['format'], $fileName, $row);
            }

            if (isset($fileSpec['keys'])) {
                $this->checkKeys($keys, $fileSpec['keys'], $fileName);
            }
        }

        return true;
    }

    /**
     * @param $data
     * @param $format
     * @param $fileName
     * @param $row
     * @throws \Exception
     */
    private function checkColumnCount($data, $format, $fileName, $row)
    {
        $num = count($data);

        if ($num != count($format)) {
            $err = sprintf(
                "Unexpected number of columns, file %s, line %d: expected %d, found %d",
                $fileName,
                $row,
                count($format),
                $num
            );

            throw new \Exception($err);
        }
    }

    /**
     * @param $data
     * @param $format
     * @param $fileName
     * @param $row
     * @throws \Exception
     */
    private function checkColumnTypes($data, $format, $fileName, $row)
    {
        $num = count($data);

        for ($column=0; $column < $num; $column++) {
            switch ($format[$column]) {
                case 'String':
                    break;
                case 'Numeric':
                    if (!is_numeric($data[$column])) {
                        $err = sprintf(
                            "Unexpected type of column, file %s, line %d: expected Number",
                            $fileName,
                            $row
                        );

                        throw new \Exception($err);
                    }
                    break;
            }
        }
    }

    /**
     * @param $keys
     * @param $required
     * @param $fileName
     * @throws \Exception
     */
    private function checkKeys($keys, $required, $fileName)
    {
        foreach ($required as $key) {
            if (!in_array($key, $keys)) {
                $err = sprintf(
                    "Missing key %s in config file %s",
                    $key,
                    $fileName
                );

                throw new \Exception($err);
            }
        }
    }
}
