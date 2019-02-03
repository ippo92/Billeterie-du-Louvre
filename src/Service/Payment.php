<?php

namespace App\Service;


class Payment
{
    public function Pay($token, $price, $mail){
        \Stripe\Stripe::setApiKey("sk_test_ZKNAdIkaJtCsLgRmzdX4zP7d");
        $charge = \Stripe\Charge::create([
            'amount' => $price * 100,
            'currency' => 'eur',
            'description' => 'commande faite par'.' '.$mail,
            'source' => $token,
        ]);
    }
}