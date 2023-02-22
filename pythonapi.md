
# RUN PYTHON
## Install the required packages:
```
Tweepy: pip install tweepy
Textstat: pip install textstat
NLTK: pip install nltk
TextBlob: pip install textblob
PySafeBrowsing: pip install pysafebrowsing
TensorFlow: pip install tensorflow
TensorFlow Text: pip install tensorflow-text
Spacy: pip install spacy
Requests: pip install requests
```
## Download the necessary NLTK data by running the following code:
```
   import nltk
   nltk.download('averaged_perceptron_tagger')
   nltk.download('cmudict')
   nltk.download('wordnet')
   nltk.download('vader_lexicon')
```
## Download the BERT fake news detection model from this link:

```
https://drive.google.com/file/d/1hM9X6dqjtVL0aBBUQ2yU0myzA2h8NlWT/view?usp=sharing.
```
Extract the contents of the zip file to a folder named bert_fake_detector.

## Create a file named params.json and include the following content:
```
{
  "es_url": "<Elasticsearch URL>",
  "index_name": "<Elasticsearch index name>",
  "consumer_key": "<Twitter API consumer key>",
  "consumer_secret": "<Twitter API consumer secret>",
  "access_token": "<Twitter API access token>",
  "access_token_secret": "<Twitter API access token secret>",
  "corenlp_url": "<Stanford CoreNLP URL>"
}
```
Replace the placeholders with the appropriate values. You can get the Twitter API credentials by creating a developer account at https://developer.twitter.com/en/apps. 
You can download Stanford CoreNLP from this link: 
https://stanfordnlp.github.io/CoreNLP/download.html.

## Update the script with the following modifications:

Import the tensorflow and tensorflow_text packages at the beginning of the script.
Replace the line from textstat import textstat with from textstat import textstat as ts.
Add the following code after the import nltk statement:
```
from nltk import download
download('stopwords')
download('punkt')
```
Replace the line SIA = SentimentIntensityAnalyzer() with SIA = SentimentIntensityAnalyzer().polarity_scores.
Add the following code after the import spacy statement:
```
nlp = spacy.load('en_core_web_sm')
sb = SafeBrowsing('<Google Safe Browsing API key>')
```
Replace <Google Safe Browsing API key> with your own API key, which you can get from the Google Cloud Console.

## Run the script!
    
