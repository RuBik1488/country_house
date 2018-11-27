<?php

// CRM server conection data BITRIX24
define('CRM_HOST', 'parnik.bitrix24.ru'); // your CRM domain name
define('CRM_PORT', '443'); // CRM server port
define('CRM_PATH', '/crm/configs/import/lead.php'); // CRM server REST service path

define('CRM_LOGIN', 'ceo@bz-online.ru'); // login of a CRM user able to manage leads
define('CRM_PASSWORD', '810810173'); // password of a CRM user

if(isset($_POST['phone'])){
    
    $leadData = $_POST['DATA'];

    // get lead data from the form
    $postData = array(
        'TITLE' => 'Заявка с сайта septiki-tut.ru',
        'NAME' => $_POST['name'],
        'PHONE_WORK' => $_POST['telephone'],
        //'COMMENTS' => $leadData['COMMENTS'],
    );

    // append authorization data
    if (defined('CRM_AUTH'))
    {
        $postData['AUTH'] = CRM_AUTH;
    }
    else
    {
        $postData['LOGIN'] = CRM_LOGIN;
        $postData['PASSWORD'] = CRM_PASSWORD;
    }

    // open socket to CRM
    $fp = fsockopen("ssl://".CRM_HOST, CRM_PORT, $errno, $errstr, 30);
    if ($fp)
    {
        // prepare POST data
        $strPostData = '';
        foreach ($postData as $key => $value)
            $strPostData .= ($strPostData == '' ? '' : '&').$key.'='.urlencode($value);

        // prepare POST headers
        $str = "POST ".CRM_PATH." HTTP/1.0\r\n";
        $str .= "Host: ".CRM_HOST."\r\n";
        $str .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $str .= "Content-Length: ".strlen($strPostData)."\r\n";
        $str .= "Connection: close\r\n\r\n";

        $str .= $strPostData;

        // send POST to CRM
        fwrite($fp, $str);

        // get CRM headers
        $result = '';
        while (!feof($fp))
        {
            $result .= fgets($fp, 128);
        }
        fclose($fp);

        // cut response headers
        $response = explode("\r\n\r\n", $result);

        $output = '<pre>'.print_r($response[1], 1).'</pre>';
    }
    else
    {
        echo 'Connection Failed! '.$errstr.' ('.$errno.')';
    }

    // END CRM server conection data BITRIX24




    !empty($_POST['name']) && $_POST['name'] != 'undefined' ? $name = "Имя: ". $_POST['name'] : '';
    !empty($_POST['phone']) ? $phone = 'Телефон: '.$_POST['phone'] : $phone = '';
    !empty($_POST['name_prod']) && $_POST['name_prod'] != 'undefined' ? $name_prod = $_POST['name_prod'] : $name_prod = '';

    
    $_POST['utm_campaign'] ? $utm .= "<b>Номер кампании</b>: " . $_POST['utm_campaign']. "<br/>" : '';
    $_POST['utm_term'] ? $utm .= "<b>Ключевое слово</b>: " . $_POST['utm_term'] . "<br/>" : '';
    $_POST['utm_source'] ? $utm .= "<b>Название источника</b>: " . $_POST['utm_source'] . "<br/>" : '';
    
    $author = 'ТопасРобот';
    
    $headers = "From: $author <parnik@yandex.ru>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    
    $letter = "<b>Поступила новая заявка</b> <br/>" . $name.'<br/>'.$phone.'<br/>'.$name_prod.'<br/>'.$utm;
    $title = 'Заказ на сайте';
    

    mail('4095157@gmail.com', $title, $letter, $headers);
    mail('b1lder@bk.ru', $title, $letter, $headers);
    echo 1;
    
}

?>
