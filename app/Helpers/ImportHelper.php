<?php

namespace App\Helpers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ImportHelper {

    public function importRunners(Request $request)
    {

        $request->file('file')->move('import', 'import.csv');
        $file = fopen('import/import.csv', 'r');
        $registration_file = [];
        while (($line = fgetcsv($file)) !== false)
        {
            $registration_file[] = $line;
        }
        fclose($file);
        unset($registration_file[0]);

        $data = $this->utf8_converter($registration_file);

        return $data;
    }

    public function utf8_converter($array)
    {
        array_walk_recursive($array, function (&$item, $key)
        {
            if (!mb_detect_encoding($item, 'utf-8', true))
            {
                $item = utf8_encode($item);
            }
        });

        return $array;
    }
}
