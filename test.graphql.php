<?php
$api_url = 'https://oxwxo.jp/test20240319/index.js';


$data = [
    'books' => [
        'title',
        'author'
    ]
];
$result_1 = sendPostDataCurl($data,$api_url);
$result_2 = sendPostDataPhp($data,$api_url);
echo var_dump($result_1);
echo var_dump($result_2);



/**
 * POST_DATAの送信
 * 
 * @param array  $post_data
 *
 * @return string|bool $result return the result on success, false on failure.
 */
function sendPostDataCurl($post_data,$api_url)
{
    // CURLでメッセージを返信する
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8'
    ));

    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    return $result;
}

/**
 * POST_DATAの送信
 * 
 * @param array  $post_data
 *
 * @return string|bool $result return the result on success, false on failure.
 */
function sendPostDataPhp($post_data,$api_url)
{
    $opts = [
        'http' => [
            'method' => 'POST',
            'header' => implode("\r\n", array(
                'Content-Type: application/json; charser=UTF-8',
            )),
            'content' => $post_data,
        ]
    ];
    
    $ctx = stream_context_create($opts);
    
    $result = file_get_contents($api_url, false, $ctx);

    return $result;
}