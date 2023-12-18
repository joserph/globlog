<?php

namespace App\Imports;

use App\Coordination;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CoordinationImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     *
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        $url = $_SERVER["REQUEST_URI"];
        $arr = explode("/", $url);
        $load = $arr[2];
        //dd($load . ' - ' . $row['id_load']);
        if($row['id_load'] != $load)
        {
            
            $row['id_load'] = null;
            //dd($row['id_load']);
        }
        //dd('Igual');
        return new Coordination([
            'hawb'  => $row['hawb'],
            'pieces' => $row['pieces'],
            'hb'    => $row['hb'],
            'qb'  => $row['qb'],
            'eb' => $row['eb'],
            'fulls'    => $row['fulls'],
            'hb_r'  => $row['hb_r'],
            'qb_r' => $row['qb_r'],
            'eb_r'    => $row['eb_r'],
            'pieces_r'  => $row['pieces_r'],
            'fulls_r' => $row['fulls_r'],
            'missing'    => $row['missing'],
            'returns'  => $row['returns'],
            'id_client' => $row['id_client'],
            'id_farm'    => $row['id_farm'],
            'id_load'  => $row['id_load'],
            'variety_id' => $row['variety_id'],
            'id_user'    => $row['id_user'],
            'update_user'  => $row['update_user'],
            'created_at' => $row['created_at'],
            'created_at'    => $row['created_at'],
            'id_marketer'  => $row['id_marketer'],
            'observation' => $row['observation'],
        ]);
    }

    public function rules(): array
    {
        return [
            // Above is alias for as it always validates in batches
            '*.hawb' => 'required|unique:coordinations,hawb',
            '*.pieces' => '',
            '*.hb' => 'required',
            '*.qb' => 'required', 
            '*.eb' => 'required', 
            '*.hb_r' => '',
            '*.qb_r' => '',
            '*.eb_r' => '',
            '*.missing' => '',
            '*.id_client' => 'required',
            '*.id_farm' => 'required',
            '*.id_load' => '',
            '*.variety_id' => 'required',
            '*.id_user' => 'required',
            '*.update_user' => 'required'
        ];
    }
    
}
