<?php

namespace App\Helpers;

use App\Event;
use App\Stages;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class ExportHelper {

    public function exportRegistrationToCSV($event_id)
    {
        $event = Event::find($event_id);
        if($event->registration()->count() == 0){
            return redirect ('/event/'.$event_id.'/registration/admin')->with('message' , 'No registration yet.');
        }
        $event_name = $event->slug.'-registration';

        $path = public_path('/export/' . $event_name);

        $table = $this->generateRegistration($event_id);

        $handle = fopen($path, 'w+');

        fputcsv($handle,$this->registrationHeader());

        foreach ($table as $row)
        {
            fputcsv($handle, [
                $row['OE0002'],
                $row['Stno'],
                $row['XStno'],
                $row['Chipno1'],
                $row['Chipno2'],
                $row['Chipno3'],
                $row['Chipno4'],
                $row['Chipno5'],
                $row['Chipno6'],
                $row['Database Id'],
                $row['Surname'],
                $row['First name'],
                $row['YB'],
                $row['S'],
                $row['Block1'],
                $row['Block2'],
                $row['Block3'],
                $row['Block4'],
                $row['Block5'],
                $row['Block6'],
                $row['E1'],
                $row['E2'],
                $row['E3'],
                $row['E4'],
                $row['E5'],
                $row['E6'],
                $row['nc1'],
                $row['Start1'],
                $row['Finish1'],
                $row['Time1'],
                $row['Classifier1'],
                $row['Credit -1'],
                $row['Penalty +1'],
                $row['Comment1'],
                $row['nc2'],
                $row['Start2'],
                $row['Finish2'],
                $row['Time2'],
                $row['Classifier2'],
                $row['Credit -2'],
                $row['Penalty +2'],
                $row['Comment2'],
                $row['nc3'],
                $row['Start3'],
                $row['Finish3'],
                $row['Time3'],
                $row['Classifier3'],
                $row['Credit -3'],
                $row['Penalty +3'],
                $row['Comment3'],
                $row['nc4'],
                $row['Start4'],
                $row['Finish4'],
                $row['Time4'],
                $row['Classifier4'],
                $row['Credit -4'],
                $row['Penalty +4'],
                $row['Comment4'],
                $row['nc5'],
                $row['Start5'],
                $row['Finish5'],
                $row['Time5'],
                $row['Classifier5'],
                $row['Credit -5'],
                $row['Penalty +5'],
                $row['Comment5'],
                $row['nc6'],
                $row['Start6'],
                $row['Finish6'],
                $row['Time6'],
                $row['Classifier6'],
                $row['Credit -6'],
                $row['Penalty +6'],
                $row['Comment6'],
                $row['Club no.'],
                $row['Cl.name'],
                $row['City'],
                $row['Nat'],
                $row['Location'],
                $row['Region'],
                $row['Cl. no.'],
                $row['Short'],
                $row['Long'],
                $row['Entry cl. No'],
                $row['Entry class (short)'],
                $row['Entry class (long)'],
                $row['Rank'],
                $row['Ranking points'],
                $row['Num1'],
                $row['Num2'],
                $row['Num3'],
                $row['Text1'],
                $row['Text2'],
                $row['Text3'],
                $row['Addr. surname'],
                $row['Addr. first name'],
                $row['Street'],
                $row['Line2'],
                $row['Zip'],
                $row['Addr. city'],
                $row['Phone'],
                $row['Mobile'],
                $row['Fax'],
                $row['EMail'],
                $row['Rented'],
                $row['Start fee'],
                $row['Paid'],
                $row['Team']]);
        }

        fclose($handle);

        return Response::download($path)->deleteFileAfterSend(true);

    }

    public function generateRegistration($event_id)
    {
        $event = Event::find($event_id);
        $stage_number = $event->stages;
        $registration_no = 0;
        $si_chip = [];

        $runners = $event->registration()->get();



    for ($a = 0; $a < count($runners); $a ++)
    {
        $registration_no ++;

        //SI-CHIP
        for ($chip = 0; $chip < $stage_number; $chip ++)
        {
            $si_chip[] = $runners[$a]->si_chip;
        }
        for ($b = 0; $b < 6; $b ++)
        {
            if (!array_key_exists($b, $si_chip))
            {
                array_push($si_chip, null);
            }
        }

        //BLOCK(Stages) && STAGES_FINAL(En)
        $block = explode('-', $runners[$a]->stages);
        for ($d = 0; $d < $stage_number; $d ++)
        {
            if ($block[$d] == 2)
            {
                $block[$d] = 0; //Normal
                $stages_final[$d] = 'X';
            } else if ($block[$d] == 3)
            {
                $block[$d] = 2; //Late
                $stages_final[$d] = 'X';
            } else if ($block[$d] == 1)
            {
                $block[$d] = 1; //Early
                $stages_final[$d] = 'X';
            } else if ($block[$d] == 0)
            { //NOT SURE, CHECK WHAT TO DO IF NO REGISTRATION SELECTED
                $block[$d] = 0;
                $stages_final[$d] = 'O';
            }
        }
        for ($c = 0; $c < 6; $c ++)
        {
            if (!array_key_exists($c, $block))
            {
                array_push($block, null);
            }
        }
        for ($e = 0; $e < 6; $e ++)
        {
            if (!array_key_exists($e, $stages_final))
            {
                array_push($stages_final, null);
            }
        }


        $runner_list[] = [

            'OE0002'              => null,
            'Stno'                => $registration_no,
            'XStno'               => null,
            'Chipno1'             => $si_chip[0],
            'Chipno2'             => $si_chip[1],
            'Chipno3'             => $si_chip[2],
            'Chipno4'             => $si_chip[3],
            'Chipno5'             => $si_chip[4],
            'Chipno6'             => $si_chip[5],
            'Database Id'         => 10000 + $registration_no,
            'Surname'             => $runners[$a]->last_name,
            'First name'          => $runners[$a]->first_name,
            'YB'                  => null,
            'S'                   => null,
            'Block1'              => $block[0],
            'Block2'              => $block[1],
            'Block3'              => $block[2],
            'Block4'              => $block[3],
            'Block5'              => $block[4],
            'Block6'              => $block[5],
            'E1'                  => $stages_final[0],
            'E2'                  => $stages_final[1],
            'E3'                  => $stages_final[2],
            'E4'                  => $stages_final[3],
            'E5'                  => $stages_final[4],
            'E6'                  => $stages_final[5],
            'nc1'                 => 0,
            'Start1'              => null,
            'Finish1'             => null,
            'Time1'               => null,
            'Classifier1'         => 0,
            'Credit -1'           => null,
            'Penalty +1'          => null,
            'Comment1'            => null,
            'nc2'                 => 0,
            'Start2'              => null,
            'Finish2'             => null,
            'Time2'               => null,
            'Classifier2'         => 0,
            'Credit -2'           => null,
            'Penalty +2'          => null,
            'Comment2'            => null,
            'nc3'                 => 0,
            'Start3'              => null,
            'Finish3'             => null,
            'Time3'               => null,
            'Classifier3'         => 0,
            'Credit -3'           => null,
            'Penalty +3'          => null,
            'Comment3'            => null,
            'nc4'                 => 0,
            'Start4'              => null,
            'Finish4'             => null,
            'Time4'               => null,
            'Classifier4'         => 0,
            'Credit -4'           => null,
            'Penalty +4'          => null,
            'Comment4'            => null,
            'nc5'                 => 0,
            'Start5'              => null,
            'Finish5'             => null,
            'Time5'               => null,
            'Classifier5'         => 0,
            'Credit -5'           => null,
            'Penalty +5'          => null,
            'Comment5'            => null,
            'nc6'                 => 0,
            'Start6'              => null,
            'Finish6'             => null,
            'Time6'               => null,
            'Classifier6'         => 0,
            'Credit -6'           => null,
            'Penalty +6'          => null,
            'Comment6'            => null,
            'Club no.'            => null,//CLUB NUMBER.
            'Cl.name'             => null,
            'City'                => $runners[$a]->club,
            'Nat'                 => $runners[$a]->country,
            'Location'            => null,
            'Region'              => null,
            'Cl. no.'             => null,
            'Short'               => $runners[$a]->category, //CATEGORY
            'Long'                => $runners[$a]->category,
            'Entry cl. No'        => null,
            'Entry class (short)' => $runners[$a]->category,
            'Entry class (long)'  => $runners[$a]->category,
            'Rank'                => null,
            'Ranking points'      => null,
            'Num1'                => null,
            'Num2'                => null,
            'Num3'                => null,
            'Text1'               => null,
            'Text2'               => null,
            'Text3'               => null,
            'Addr. surname'       => null,
            'Addr. first name'    => null,
            'Street'              => null,
            'Line2'               => null,
            'Zip'                 => null,
            'Addr. city'          => null,
            'Phone'               => null,
            'Mobile'              => null,
            'Fax'                 => null,
            'EMail'               => null,
            'Rented'              => 0,
            'Start fee'           => null,
            'Paid'                => $runners[$a]->payed,
            'Team'                => null,
        ];

    }

        return $runner_list;


    }

    public function exportCategoryToCSV($event_id)
    {
        $event = Event::find($event_id);

        $event_name = $event->slug.'-category';
        $path = public_path('/export/' . $event_name);

        $table = $this->generateCategory($event_id);

        $handle = fopen($path, 'w+');
        fputcsv($handle, $this->categoryHeader());

        foreach ($table as $row)
        {
            fputcsv($handle, [
                $row['OE0008a'],
                $row['Cl. no.'],
                $row['Short'],
                $row['Long'],
                $row['Start fee'],
                $row['Classified'],
                $row['S'],
                $row['Age from'],
                $row['Age to'],
                $row['Start fee2'],
                $row['Type 1'],
                $row['Type 2'],
                $row['Class additional text'],
                $row['Start fee/Stage'],
                $row['S1 Max. competitors'],
                $row['S2 Max. competitors'],
                $row['S3 Max. competitors'],
                $row['S4 Max. competitors'],
                $row['S5 Max. competitors'],
                $row['S6 Max. competitors']
            ]);
        }
        fclose($handle);

        return Response::download($path)->deleteFileAfterSend(true);

    }

    public function generateCategory($event_id)
    {
        $event = Event::find($event_id);


        $stages = explode('-', $event->category);


        $num = 0;
        $count_category = count($stages);


        for ($a = 0; $a < $count_category; $a ++)
        {
            $num ++;
            $category_list[] = ['OE0008a'               => null,
                                'Cl. no.'               => $num,
                                'Short'                 => $stages[$a],
                                'Long'                  => $stages[$a],
                                'Start fee'             => '1,00',
                                'Classified'            => 'X',
                                'S'                     => 'M',
                                'Age from'              => null,
                                'Age to'                => null,
                                'Start fee2'            => '0,00',
                                'Type 1'                => null,
                                'Type 2'                => null,
                                'Class additional text' => null,
                                'Start fee/Stage'       => '0,00',
                                'S1 Max. competitors'   => null,
                                'S2 Max. competitors'   => null,
                                'S3 Max. competitors'   => null,
                                'S4 Max. competitors'   => null,
                                'S5 Max. competitors'   => null,
                                'S6 Max. competitors'   => null,
            ];
        }

        return $category_list;
    }

    public function categoryHeader()
    {
        return $header = ['OE0008a', 'Cl. no.', 'Short', 'Long', 'Start fee', 'Classified', 'S', 'Age from', 'Age to', 'Start fee2', 'Type 1', 'Type 2',
            'Class additional text', 'Start fee/Stage', 'S1 Max. competitors', 'S2 Max. competitors', 'S3 Max. competitors', 'S4 Max. competitors', 'S5 Max. competitors', 'S6 Max. competitors'];;
    }

    public function registrationHeader()
    {
        return $header = ['OE0002', 'Stno', 'XStno', 'Chipno1', 'Chipno2', 'Chipno3', 'Chipno4', 'Chipno5', 'Chipno6', 'Database Id', 'Surname', 'First name', 'YB', 'S', 'Block1', 'Block2', 'Block3',
            'Block4', 'Block5','Block6','E1','E2','E3','E4','E5','E6','nc1','Start1','Finish1','Time1','Classifier1','Credit -1','Penalty +1','Comment1','nc2','Start2','Finish2','Time2','Classifier2',
            'Credit -2','Penalty +2','Comment2','nc3','Start3','Finish3','Time3','Classifier3','Credit -3','Penalty +3','Comment3','nc4','Start4','Finish4','Time4','Classifier4','Credit -4','Penalty +4',
            'Comment4','nc5','Start5','Finish5','Time5','Classifier5','Credit -5','enalty +5','Comment5','nc6','Start6','Finish6','Time6','Classifier6','Credit -6','Penalty +6','Comment6','Club no.',
            'Cl.name','City','Nat','Location','Region','Cl. no.','Short','Long','Entry cl. No','Entry class (short)','Entry class (long)','Rank','Ranking points','Num1','Num2','Num3','Text1','Text2',
            'Text3','Addr. surname','Addr. first name','Street','Line2','Zip','Addr. city','Phone','Mobile','Fax','EMail','Rented','Start fee','Paid','Team',
        ];
    }
}