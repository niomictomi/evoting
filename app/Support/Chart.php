<?php
namespace App\Support;

/**
 * Helper untuk membantu pengolahan diagram atau chart
 */
class Chart {

    /**
     * Melakukan pengeditan terhadap data yang digunakan pada
     * diagram
     *
     * @param array $data
     * @param bool $withPercent
     * @return \Illuminate\Support\Collection
     */
    public function parse($data, $withPercent = true)
    {
        $newData = [];

        $total = $this->getTotalCount($data);

        foreach($data as $key => $value) {
            if($withPercent) {
                array_push($newData, [
                    $key . ' (' . number_format($this->getPercent($value, $total), 2) . '%)',
                    $value
                ]);
            }
            else {
                array_push($newData, [
                    $key, $value
                ]);
            }
        }

        return collect($newData);
    }

    /**
     * Mendapatkan total data
     *
     * @param array $data
     * @return int
     */
    private function getTotalCount($data)
    {   
        $sum = 0;

        foreach($data as $key => $value)
            $sum += $value;
        
        return $sum;
    }

    /**
     * Mendapatkan presentase dari sejumlah data terhadap jumlah
     * data
     *
     * @param int $part
     * @param int $sum
     * @return float
     */
    private function getPercent($part, $sum)
    {
        return $part / $sum * 100;
    }

}