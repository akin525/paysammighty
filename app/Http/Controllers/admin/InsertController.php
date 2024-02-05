<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class InsertController extends Controller
{
    function getmcdproduct($request)
    {


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://reseller.mcd.5starcompany.com.ng/api/v1/data/'.$request,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer rocqaIlgQZ7S22pno8kiXwgaGsRANJEHD5ai49nX7CrXBfZVS7vvRfCzYmdzZ2GuqmB6JgrUZBmFjwNXUDF9zEV25tWH7ADv7SjcJuOlWypRxpoy28KQU0U2D3XWjKQybBYjNixsMCBv1GJxQPNMcC'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;

        $data = json_decode($response, true);

//return $success;
        foreach ($data as $plan){
            $success =$plan["network"];
            $planid = $plan["planId"];
            $price= $plan['price'];
            $allowance=$plan['allowance'];
            $validity =$plan['validity'];
            $insert= big::create([
                'plan_id' =>$planid,
                'network' =>$success,
                'plan' =>$allowance.$validity,
                'code' =>$planid,
                'amount'=>$price,
                'tamount'=>$price,
                'ramount'=>$price,
                'cat_id'=>$planid,
            ]);
        }
    }

}
