import requests
import json

es_url = "http://10.0.201.201:9200"
post_id = 1

headers = {
    'Content-Type': 'application/json'
}

data = {
    "title": "Веселые котята",
    "content": "<p>Смешная история про котят<p>",
    "tags": [
        "котята",
        "смешная история"
    ],
    "published_at": "2014-09-12T20:44:42+00:00"
}

response = requests.put(f"{es_url}/blog/post/{post_id}?pretty", headers=headers, data=json.dumps(data))

print(response.text)