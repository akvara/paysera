<?php

namespace Paysera;

class IntegrityChecker
{
    static public function check(array $configs)
    {

        foreach ($configs as $fileName => $format) {
            $reader = new FileReader($fileName);
            $handle = $reader->getHandle();

            $row = 0;

            while (($data = fgetcsv($handle, 0, Config::DELIMITER)) !== FALSE) {
                $num = count($data);
                if ($num != count($format)) {
                    $err = sprintf(
                        "Unexpected number of columns, file: %s, expected %d, found %d",
                        $fileName,
                        count($format),
                        $num
                    );

                    throw new \Exception($err);
                }
//                echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                for ($c=0; $c < $num; $c++) {
//                    echo $data[$c] . "->" . gettype($data[$c]);
                }
            }
        }

        return true;
    }
}
