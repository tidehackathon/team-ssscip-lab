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

#The following features can be extracted using this module:

    Readability metrics: this module uses the textstat library to compute various metrics of text complexity and readability, such as the Flesch-Kincaid Grade Level, the Automated Readability Index, and the Coleman-Liau Index.

    - Text preprocessing: this module includes various functions to preprocess text data, such as removing URLs, mentions, hashtags, and retweet tags, as well as tokenizing and part-of-speech tagging the remaining words using the NLTK library.

    - Uncertainty score: this module uses the NLTK WordNet to compute a score of how uncertain or ambiguous the text is, based on the presence of words whose definition includes the word "uncertain".

    - Sentiment analysis: this module uses the NLTK Vader library and TextBlob library to compute a sentiment score of the text, ranging from -1 (negative) to 1 (positive).

    - Phoneme count: this module uses the NLTK CMU Pronouncing Dictionary to count the number of phonemes in the text.

    - TF-IDF vectors: this module uses the scikit-learn TfidfVectorizer to compute the TF-IDF vectors of the text, which represent the importance of each word in the text compared to a reference corpus.

    - Named entities: this module uses the spaCy library to extract named entities from the text, such as persons, organizations, and locations.

    #This is a text analysis engine built with Python that extracts various metrics from text. It uses a combination of natural language processing and machine learning techniques to extract the following metrics:

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

### Tweet aggregation

Our system includes a feature for aggregating tweets related to a particular topic or keyword. This allows us to provide our users with a real-time feed of relevant tweets.

## Feedback

We've put a lot of effort into making this application easy to use and understand, and we hope you find it helpful. If you have any questions or feedback, please don't hesitate to reach out to us!

---

#### This is a footnote or a disclaimer
