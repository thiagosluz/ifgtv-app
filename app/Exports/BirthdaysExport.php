<?php

namespace App\Exports;

use App\Models\Birthday;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BirthdaysExport implements FromCollection, WithHeadings, WithMapping
{

    protected $birthdays;

    public function __construct($birthdays)
    {
        $this->birthdays = $birthdays;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->birthdays;
    }

    /**
     * Define os cabeçalhos das colunas.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nome',
            'Data de Aniversário',
        ];
    }


    /**
     * Mapeia os dados para exportação.
     *
     * @param mixed $birthday
     * @return array
     */
    public function map($birthday): array
    {
        return [
            $birthday->name,
            $birthday->birthday->format('d/m/Y'), // Formata a data como d/m/Y
        ];
    }

}
