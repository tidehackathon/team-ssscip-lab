<?php
function getResults($score_fake_model_bool, $contains_propaganda) {
    $today = new DateTime('now');
    $todayStr = $today->format('Y-m-d');

    // Формуємо асоціативний масив з датами
    $counts = array();
    $counts[$todayStr] = 0;
    for ($i = 1; $i < 7; $i++) {
        $date = $today->sub(new DateInterval('P1D'))->format('Y-m-d');
        $counts[$date] = 0;
    }

    // Формуємо запит до ElasticSearch та отримуємо кількість документів для кожної дати
    $results = array();
    foreach ($counts as $date => &$count) {
        $query = json_encode([
            "query" => [
                "bool" => [
                    "must" => [
                        [
                            "match" => [
                                "created_at" => $date
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        if ($score_fake_model_bool !== null) {
            $query["query"]["bool"]["must"][] = [
                "match" => [
                    "score_fake_model_bool" => $score_fake_model_bool
                ]
            ];
        }

        if ($contains_propaganda !== null) {
            $query["query"]["bool"]["must"][] = [
                "match" => [
                    "contains_propaganda" => $contains_propaganda
                ]
            ];
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://10.0.201.201:9200/blog/_count");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        $count = $data['count'];

        // Додаємо елемент до масиву результатів
        $results[] = array("date" => $date, "count" => $count);
    }

    return $results;
    $results = getResults(true, false);
}
echo  $results;

