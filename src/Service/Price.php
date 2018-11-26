<?php

namespace App\Service;



class Price
{

    public function getTicketsPrice($data, $tickets, $datedubillet){
        $price = 0;
        $number = $data->getNumberOfTickets();
        for ($i=0; $i<$number ;$i++){
            $datedenaissance = $tickets[$i]->getDateOfBirth();
            $age = $datedubillet->diff($datedenaissance)->y;

            if ($tickets[$i]->getCategory() == "tarif réduit" && $age > 12) {
                $price += 10;
            }
            if ($tickets[$i]->getCategory() == "tarif réduit" && $age < 12 && $age>=4) {
                $price += 8;
            }
            if ($tickets[$i]->getCategory() == "tarif normal") {
                if ($age<12 && $age>=4){
                    $price += 8;
                }
                if ($age<60 && $age>=12){
                    $price += 16;
                }
                if ($age>=60){
                    $price += 12;
                }
            }
        }
        return $price;
    }



}