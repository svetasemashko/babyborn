<?php

namespace App\Service;

class StatisticCollector
{
    public function getAllData(): array
    {
        $data['kids'] = $this->getAllKids();
        $data['adults'] = $this->getAllAdults();

        return $data;
    }

    public function getAllKids(): array
    {
        return [];
    }

    public function getAllAdults(): array
    {
        return [];
    }
}