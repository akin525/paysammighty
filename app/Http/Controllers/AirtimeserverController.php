<?php
namespace App\Http\Controllers;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
class AirtimeserverController extends Controller
{

    public function Clubkonnect($request)
    {

        $code=$request['name'];
        if ($code =="m"){
            $network="01";
        }
        if ($code =="g"){
            $network="02";
        }
        if ($code =="a"){
            $network="04";
        }
        if ($code =="9"){
            $network="03";
        }
        $userId ='CK100308875';
        $apiKey ='QEOZE849JE7T04EWM56J3J5H5088G30U857OOJLI72TKNWG8T080MC59KK1P8490';
        $examCode = 'utme';
        $recipientPhoneNo = $request['number'];
        $amount= $request['amount'];
        $callbackUrl = 'https://pay.sammighty.com.ng/api/callback_url';

        $url = "https://www.nellobytesystems.com/APIAirtimeV1.asp?UserID=$userId&APIKey=$apiKey&MobileNetwork=$network&Amount=$amount&MobileNumber=$recipientPhoneNo&

CallBackURL=$callbackUrl";

        $options = array(
            'http' => array(
                'method' => 'GET',
            ),
        );

        $context = stream_context_create($options);
        return file_get_contents($url, false, $context);



    }

    public function mcdbill( $request)
    {

        $url = 'https://integration.mcd.5starcompany.com.ng/api/reseller/pay';

        $headers = array(
            'Content-Type: application/json',
            'Authorization: MCDKEY_903sfjfi0ad833mk8537dhc03kbs120r0h9a'

        );

        $data = array(
            'service' => 'airtime',
            'coded' => $request->name,
            'phone' => $request->number,
            'amount' => $request->amount,
            'reseller_price' => $request->amount
        );

        $options = array(
            'http' => array(
                'header' => implode("\r\n", $headers),
                'method' => 'POST',
                'content' => json_encode($data),
            ),
        );

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        $data = json_decode($response, true);
        return $response;

    }

    public function easyaccess($request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://easyaccess.com.ng/api/data.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'network' =>$request->plan_id,
                'mobileno' => $request->number,
                'dataplan' => $request->code,
                'client_reference' => $request->refid, //update this on your script to receive webhook notifications
            ),
            CURLOPT_HTTPHEADER => array(
                "AuthorizationToken:  fed2524ba6cae4b443f65f60a30a8731", //replace this with your authorization_token
                "cache-control: no-cache"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
//        echo $response;

        return $response;

    }

}



