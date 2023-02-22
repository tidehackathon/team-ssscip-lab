# SIXL 

Hello and welcome to our GitHub repository!

## Infrastructure

### Monitoring service

We use a combination of **PHP** and **JavaScript** to create our monitoring service, which is responsible for keeping track of the health of our application. We also use **Chart.js** to display metrics in an easily understandable format.
![Alt Text](https://i.ibb.co/5GZnW8v/monitoring.gif)
### Fake detection

Our system includes a feature for detecting fake news and information. This helps us ensure that our users are only receiving accurate information and helps combat the spread of misinformation.

### Extract Text Feature Engine


#This Python module provides a set of functions to extract various features from text data, such as tweet messages or other short texts. It relies on several popular libraries for natural language processing and machine learning, such as NLTK, TextBlob, spaCy, and scikit-learn.

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
    
### ElasticSearch and Kibana

We use **ElasticSearch** and **Kibana** for data storage and visualization, respectively. ElasticSearch allows us to efficiently index and search through large amounts of data, while Kibana provides us with a user-friendly interface for exploring and analyzing our data.
![Screen from Kibana](https://i.ibb.co/5xfRj4P/kibana.gif)
### Tweet aggregation

Our system includes a feature for aggregating tweets related to a particular topic or keyword. This allows us to provide our users with a real-time feed of relevant tweets.

## Feedback

We've put a lot of effort into making this application easy to use and understand, and we hope you find it helpful. If you have any questions or feedback, please don't hesitate to reach out to us!

---

#### This is a footnote or a disclaimer




# RUN PYTHON
1)Install the required packages:

Tweepy: pip install tweepy
Textstat: pip install textstat
NLTK: pip install nltk
TextBlob: pip install textblob
PySafeBrowsing: pip install pysafebrowsing
TensorFlow: pip install tensorflow
TensorFlow Text: pip install tensorflow-text
Spacy: pip install spacy
Requests: pip install requests

2)Download the necessary NLTK data by running the following code:

   import nltk
   nltk.download('averaged_perceptron_tagger')
   nltk.download('cmudict')
   nltk.download('wordnet')
   nltk.download('vader_lexicon')

3)Download the BERT fake news detection model from this link: https://drive.google.com/file/d/1hM9X6dqjtVL0aBBUQ2yU0myzA2h8NlWT/view?usp=sharing. Extract the contents of the zip file to a folder named bert_fake_detector.

4)Create a file named params.json and include the following content:

{
  "es_url": "<Elasticsearch URL>",
  "index_name": "<Elasticsearch index name>",
  "consumer_key": "<Twitter API consumer key>",
  "consumer_secret": "<Twitter API consumer secret>",
  "access_token": "<Twitter API access token>",
  "access_token_secret": "<Twitter API access token secret>",
  "corenlp_url": "<Stanford CoreNLP URL>"
}

Replace the placeholders with the appropriate values. You can get the Twitter API credentials by creating a developer account at https://developer.twitter.com/en/apps. You can download Stanford CoreNLP from this link: https://stanfordnlp.github.io/CoreNLP/download.html.

5)Update the script with the following modifications:

Import the tensorflow and tensorflow_text packages at the beginning of the script.
Replace the line from textstat import textstat with from textstat import textstat as ts.
Add the following code after the import nltk statement:
from nltk import download
download('stopwords')
download('punkt')
Replace the line SIA = SentimentIntensityAnalyzer() with SIA = SentimentIntensityAnalyzer().polarity_scores.
Add the following code after the import spacy statement:
nlp = spacy.load('en_core_web_sm')
sb = SafeBrowsing('<Google Safe Browsing API key>')

Replace <Google Safe Browsing API key> with your own API key, which you can get from the Google Cloud Console.

6)Run the script!
