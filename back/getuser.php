<?php
// Створити запит до ElasticSearch
$query = [
    "size" => 0,
    "aggs" => [
        "group_by_screen_name" => [
            "terms" => [
                "field" => "screen_name.keyword",
                "size" => 10,
                "min_doc_count" => 2
            ],
            "aggs" => [
                "post_text" => [
                    "terms" => [
                        "field" => "text.keyword",
                        "size" => 10
                    ]
                ]
            ]
        ]
    ]
];
$queryJson = json_encode($query);

// Виконати запит до ElasticSearch і вивести результат
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://10.0.201.201:9200/blog/_search");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $queryJson);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$response = curl_exec($ch);
curl_close($ch);

// Перетворити відповідь в масив PHP та вивести результат
$data = json_decode($response, true);
foreach ($data['aggregations']['group_by_screen_name']['buckets'] as $bucket) {
    echo $bucket['key'] . ": " . $bucket['doc_count'] . " posts\n";
}