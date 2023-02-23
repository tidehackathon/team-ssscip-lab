# SIXL 

Hello and welcome to our GitHub repository!

In the midst of a full-scale war, society has become increasingly reliant on digital media and social networks. As a result, the threat of fake news and disinformation has become more widespread than ever before. To combat this issue, we have developed a comprehensive system that can detect and flag false information from Twitter, as well as a monitoring system that allows users to define topics of interest within their personal accounts. Additionally, our system can aggregate tweets and extract text features, all while providing a reliable notification system.

By proactively identifying and addressing fake news, our product can play an essential role in protecting the integrity of online information .

## Infrastructure
![Screen from Kibana](https://i.postimg.cc/sx7qZ3Rn/2023-02-23-10-07-54.jpg)
### Monitoring service in realtime and alert manager

We use a combination of **PHP** and **JavaScript** to create our monitoring service, which is responsible for keeping track of the health of our application. We also use **Chart.js** to display metrics in an easily understandable format.Our product offers an exceptional solution for monitoring any topic of your choosing. 

![Alt Text](https://i.ibb.co/5GZnW8v/monitoring.gif)


### Extract Text Feature Engine


This Python module provides a set of functions to extract various features from text data, such as tweet messages or other short texts. It relies on several popular libraries for natural language processing and machine learning, such as NLTK, TextBlob, spaCy, and scikit-learn.

#### The following features can be extracted using this module:

    - Readability metrics: this module uses the textstat library to compute various metrics of text complexity and readability, such as the Flesch-Kincaid Grade Level, the Automated Readability Index, and the Coleman-Liau Index.

    - Text preprocessing: this module includes various functions to preprocess text data, such as removing URLs, mentions, hashtags, and retweet tags, as well as tokenizing and part-of-speech tagging the remaining words using the NLTK library.

    - Uncertainty score: this module uses the NLTK WordNet to compute a score of how uncertain or ambiguous the text is, based on the presence of words whose definition includes the word "uncertain".

    - Sentiment analysis: this module uses the NLTK Vader library and TextBlob library to compute a sentiment score of the text, ranging from -1 (negative) to 1 (positive).

    - Phoneme count: this module uses the NLTK CMU Pronouncing Dictionary to count the number of phonemes in the text.

    - TF-IDF vectors: this module uses the scikit-learn TfidfVectorizer to compute the TF-IDF vectors of the text, which represent the importance of each word in the text compared to a reference corpus.

    - Named entities: this module uses the spaCy library to extract named entities from the text, such as persons, organizations, and locations.


#### This is a text analysis engine built with Python that extracts various metrics from text. It uses a combination of natural language processing and machine learning techniques to extract the following metrics:

    -Sentiment: A sentiment analysis score that indicates the overall emotional tone of the text.

    -Complexity: The Flesch-Kincaid Grade Level score that indicates the level of education required to understand the text.

    - Uncertainty: A metric that measures the degree of uncertainty expressed in the text.
    
    - Informality: A metric that measures the level of formality in the text.
    
    - Polarity: A metric that measures the degree to which the text expresses positive or negative sentiment.
    
    - TFI: The Term Frequency-Inverse Document Frequency score that indicates how important a word is to the text relative to a search query.
    - Subjectivity: A metric that measures the degree to which the text expresses subjective rather than objective content.
    
    - Contains Propaganda: A metric that indicates whether the text contains propaganda.

    - Identify False Context: A metric that indicates whether the text contains false context.

    - Pleasantness Score: A metric that measures the degree of pleasantness in the text.

    - Activation Score: A metric that measures the degree of activation in the text.
    
    - Imagery Score: A metric that measures the degree of vivid imagery in the text.
    
![Screen from Kibana](https://i.postimg.cc/vDFkqR04/2023-02-22-16-28-15.jpg)

### ElasticSearch and Kibana

We use **ElasticSearch** and **Kibana** for data storage and visualization, respectively. ElasticSearch allows us to efficiently index and search through large amounts of data, while Kibana provides us with a user-friendly interface for exploring and analyzing our data.
![Screen from Kibana](https://i.ibb.co/5xfRj4P/kibana.gif)


### PYTHON API

This script uses the Tweepy library to search for tweets on Twitter based on a search query, and analyzes the sentiment, complexity, informality, and other attributes of each tweet. The script then sends the analyzed data to an ElasticSearch server for storage.

The script uses several libraries, including datetime, requests, tweepy, time, textstat, re, wordnet, nltk, textblob, cmudict, TfidfVectorizer, spacy, SentimentIntensityAnalyzer, pysafebrowsing, json, tensorflow, and tensorflow_text.

The main part of the script iterates through each tweet returned by the Twitter search, and extracts the text, screen name, and other relevant information from the tweet. It then calculates various metrics for the tweet, including sentiment score, complexity, informality, and more. Finally, it sends the analyzed data to an ElasticSearch server for storage.

## Future Directions

* To ensure scalability, we plan to migrate to a Kubernetes Cluster.
* To handle a large number of requests from different users, we plan to add Apache Kafka to our architecture.
* We plan to further integrate with Stanford CoreNLP to identify Person and Location in text for better disinformation targeting.
* We will create a tool for data labeling and creating / augmenting the dataset for the BERT classifier.

![Screen from Kibana](https://i.postimg.cc/NMyXsLcr/2023-02-22-16-37-35.jpg)
## Feedback

We've put a lot of effort into making this application easy to use and understand, and we hope you find it helpful. If you have any questions or feedback, please don't hesitate to reach out to us!

---
## Install product

#### Install Python Api - [pythonapi.md]( pythonapi.md)
#### Install Kibana, Elasticsearch, Apache-Nifi, CoreNLP, Zookeeper
In nifi folder you must build Docker with nifi and requirements 

    docker build -t nifi . 
Then in root folder just run

    docker-compose up
#### In order to bring up the web service(monitoring) you need to install php and change the requests to ElasticSearch in backend files to your address.
---

## Another link to Azure Blob
Model file - https://sscip.blob.core.windows.net/files/classifier01.zip

Apache Nifi Stanford CoreNLP Processor - https://sscip.blob.core.windows.net/files/nifi-stanfordcorenlp-nar-1.2.nar
