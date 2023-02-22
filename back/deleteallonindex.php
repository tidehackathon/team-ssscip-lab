<?php 
$es_url = "http://10.0.201.201:9200";
$index_name = "blog";

// Отримання списку всіх документів у вказаному індексі
$query = [
    'query' => [
        'match_all' => (object)[]
    ]
];
$url = "{$es_url}/{$index_name}/_delete_by_query";
$headers = array("Content-Type: application/json");
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($query));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
curl_close($ch);

// Перевірка результату видалення
$result = json_decode($response);
if ($result->timed_out) {
    echo "Виникла помилка: операція зайняла забагато часу.";
} elseif ($result->deleted > 0) {
    echo "Успішно видалено " . $result->deleted . " документів з індексу " . $index_name . ".";
} else {
    echo "Нічого не видалено з індексу " . $index_name . ".";
}