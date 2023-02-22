<?php

// Elasticsearch endpoint
$endpoint = 'http://10.0.201.201:9200';

// Elasticsearch index name
$index = 'blog';

// Elasticsearch query
$query = [
    'size' => 10,
    'query' => [
        'match_all' => (object)[]
    ],
    'sort' => [
        [
            'time' => [
                'order' => 'desc'
            ]
        ]
    ]
];

// Set the request URL and method
$url = "{$endpoint}/{$index}/_search";
$method = 'GET';

// Set the cURL options
$options = [
    CURLOPT_URL => $url,
    CURLOPT_CUSTOMREQUEST => $method,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json'
    ],
    CURLOPT_POSTFIELDS => json_encode($query)
];

// Initialize cURL
$curl = curl_init();

// Set the cURL options
curl_setopt_array($curl, $options);

// Execute the cURL request
$response = curl_exec($curl);

// Close the cURL connection
curl_close($curl);

// Handle the response
if ($response === false) {
    // Handle the cURL error
    $error = curl_error($curl);
    echo json_encode(["error" => "cURL Error: {$error}"]);
} else {
    // Handle the Elasticsearch response
    $data = json_decode($response);

    // Process the data as needed
    $tweets = [];
    foreach ($data->hits->hits as $hit) {
        $source = $hit->_source;
        $id = $hit->_id;
        $created_at = $source->created_at;
        $screen_name = $source->screen_name;
        $name = $source->name;
        $time = $source->time;
        $retweets = $source->retweets;
        $user_followers = $source->user_followers;
        $user_following = $source->user_following;
        $sentiment = $source->sentiment;
        $text = $source->text;
        $tweets[] = [
            "id" => $id,
            "time" => $time,
            "created_at" => $created_at,
            "screen_name" => $screen_name,
            "retweets" => $retweets,
            "user_followers" => $user_followers,
            "user_following" => $user_following,
            "sentiment" => $sentiment,
            "text" => $text
        ];
    }

    // Output the data as JSON
    echo json_encode($tweets);
}
