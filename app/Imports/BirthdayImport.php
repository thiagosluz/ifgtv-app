<?php

namespace App\Imports;

use App\Models\Birthday;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BirthdayImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Birthday([
            'name' => $row['nome'],
            'birthday'=> Carbon::createFromFormat('d/m/Y', $row['aniversario'])
        ]);
    }
}
