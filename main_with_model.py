# coding: utf-8
import datetime
import requests
import tweepy
import time
from textstat import textstat
import re
from nltk.corpus import wordnet
from nltk.tokenize import word_tokenize
from nltk.tag import pos_tag
from textblob import TextBlob
from nltk.corpus import cmudict
from sklearn.feature_extraction.text import TfidfVectorizer
import spacy
from nltk.sentiment.vader import SentimentIntensityAnalyzer
import nltk
from pysafebrowsing import SafeBrowsing
import json
import tensorflow as tf
import tensorflow_text as tf_text


#####################################################################
model = tf.saved_model.load("bert_fake_detector")                   #
f = open('params.json')                                             #
params=json.load(f)                                                 #
es_url = params['es_url']                                           #
index_name = params['index_name']                                   #
consumer_key = params['consumer_key']                               #
consumer_secret = params['consumer_secret']                         #
access_token = params['access_token']                               #
access_token_secret = params['access_token_secret']                 #
corenlp_url = params['corenlp_url']                                 #
annotators = "tokenize,ssplit,pos,lemma,ner,sentiment"              #
output_format = "json"                                              #
auth = tweepy.OAuthHandler(consumer_key, consumer_secret)           #
auth.set_access_token(access_token, access_token_secret)            #
api = tweepy.API(auth)                                              #
#####################################################################


#1)function to check the website that is in the tweet
def get_url(text):
    '''
    Function that appears to perform a check on a given URL to determine
    if it is safe or malicious. The function takes in a single argument ca-
    lled "text", which is expected to be a string that contains a URL.

    The first line of the function uses regular expressions (regex) to ext-
    ract the URL from the input "text" string. The URL  is then  stored  in
    the "url" variable.

    The next few lines use the "SafeBrowsing" library to check if the URL is
    safe or malicious.  The library is initialized with an API  key  and the
    "lookup_urls" method is used to check the given URL. If the URL is found
    to be safe, the function returns -1. If the URL is found to be malicious,
    the function returns 1.

    If an error occurs during the process (e.g. the input  "text"  does  not
    contain a valid URL, or there is an issue with the API key), the  funct-
    ion returns 0 to indicate an error.

    In summary, this function takes a string argument that contains a URL,
    checks the URL against a SafeBrowsing API to determine if it is safe or
    malicious, and returns a numerical value to indicate the result (-1 for
     safe, 1 for malicious, and 0 for an we dont have url in text).
    :param text:
    :return:
    '''
    try:
        url = re.search("(?P<url>https?://[^\s]+)", text).group("url")
        s = SafeBrowsing('AIzaSyAPrXjrZX_CypqKGe9eHPTRZq2qM2aQ_-8')
        r = s.lookup_urls([url])
        return 1 if r[f'{url}']['malicious'] else -1
    except:
        return 0




#2)function
def engagment_rate(tweet):
    '''
    This function takes in a Twitter tweet object and retrieves the
    number of likes and retweets that the tweet has received  using
    the attributes favorite_count and retweet_count,  respectively.
    The function then calculates  the engagement rate of the tweet,
    defined as the sum of likes  and retweets divided by the number
    of followers of the user who posted the tweet.

    In case the user has zero followers (which could be a result of
    a private account or a data error), the function  would  result
    in a division by zero error. Therefore, the function has a try-
    except block that handles this scenario by setting the engagem-
    ent rate to the sum of likes and retweets divided by 1. Finally
    the function returns the engagement  rate as a floating - point
    number.
    :param tweet:
    :return:
    '''
    likes = tweet.favorite_count
    retweets = tweet.retweet_count
    engagement_rate = (likes + retweets) / tweet.user.followers_count if tweet.user.followers_count else 1

    return engagement_rate

#3)function
def score(screen_name,followers_count):
    '''
    This function uses the Twitter API to retrieve a timeline of tweets from a
    given user's screen_name. The function first retrieves the number of tweet
    s in the timeline by calculating the length of the timeline list. It then
    creates an empty list called sp.

    The function then loops through each tweet in the timeline and extracts the
    creation date of each tweet in the "Mon DD HH:MM:SS +0000 YYYY" format usi
    ng the _json['created_at'] attribute. It then converts each creation date
    to a datetime object using the strptime method and appends each datetime
    object to the sp list.

    The function then calculates the tweets_per_day metric, which is defined as
    the total number of tweets divided by the number of days between the oldest
    and newest tweet in the timeline. If the calculation results in a division
    by zero error, the function sets the tweets_per_day metric to the total
    number of tweets in the timeline.

    Finally, the function calculates the bot_score metric, which is defined as
     the tweets_per_day metric divided by the number of followers of the user.
     If the calculation results in a division by zero error, the function sets
     the bot_score metric to the tweets_per_day metric.

    The function returns the bot_score as a floating-point number. The bot_score
     is a metric that can be used to assess the likelihood that a Twitter user
     is a bot based on their tweeting activity and number of followers.

    :param screen_name:
    :param followers_count:
    :return:
    '''
    timeline = api.user_timeline(screen_name=screen_name)
    statuses = len(timeline)
    sp=[]
    for time in timeline:
        date_format = datetime.datetime.strptime(time._json['created_at'], "%a %b %d %H:%M:%S %z %Y")
        sp.append(date_format)
    try:
        tweets_per_day = statuses / (max(sp)- min(sp)).days
    except:
        tweets_per_day=statuses/1
    try:
        bot_score = tweets_per_day / followers_count
    except:
        bot_score=tweets_per_day/1

    return bot_score

#4)function
def get_tweet_sentiment_scores(tweet):
    '''

    :param tweet:
    :return:
    '''
    tokens = nltk.word_tokenize(tweet)
    sid = SentimentIntensityAnalyzer()
    scores = []
    for token in tokens:
        score = sid.polarity_scores(token)
        scores.append(score)
    pleasantness_score = sum([s['pos'] for s in scores]) / len(scores)
    activation_score = (sum([s['pos'] for s in scores]) - sum([s['neg'] for s in scores])) / len(scores)
    imagery_score = sum([s['compound'] for s in scores]) / len(scores)
    return pleasantness_score,activation_score,imagery_score

#5)function
def identify_false_context(text):
    '''

    :param text:
    :return:
    '''
    text = re.sub(r'https?:\/\/\S+', '', text)
    text = re.sub(r'RT @\S+', '', text)
    text = re.sub(r'@[^\s]+', '', text)
    text = re.sub(r'#', '', text)
    nlp = spacy.load("en_core_web_sm")
    doc = nlp(text)
    has_false_context = False
    for token in doc:
        if token.ent_type_:
            for child in token.children:
                if child.pos_ in ["VERB", "ADJ"]:
                    for neg in child.children:
                        if neg.dep_ == "neg":
                            has_false_context = True
                            break
                elif child.pos_ == "NOUN":
                    for neg in child.children:
                        if neg.dep_ == "neg":
                            has_false_context = True
                            break
                if has_false_context:
                    break
        if has_false_context:
            break
    return has_false_context

#6)function
def contains_propaganda(text):
    '''

    :param text:
    :return:
    '''
    text = re.sub(r'https?:\/\/\S+', '', text)
    text = re.sub(r'RT @\S+', '', text)
    text = re.sub(r'@[^\s]+', '', text)
    text = re.sub(r'#', '', text)
    blob = TextBlob(text)
    polarity = blob.sentiment.polarity
    subjectivity = blob.sentiment.subjectivity
    return polarity < -0.5 and subjectivity > 0.5


#7)function
def subjectivity(text):
    '''

    :param text:
    :return:
    '''
    text = re.sub(r'https?:\/\/\S+', '', text)
    text = re.sub(r'RT @\S+', '', text)
    text = re.sub(r'@[^\s]+', '', text)
    text = re.sub(r'#', '', text)

    blob = TextBlob(text)
    subjectivity_value = blob.sentiment.subjectivity

    return subjectivity_value

#8)function
def calc_tfidf(text, query):
    '''

    :param text:
    :param query:
    :return:
    '''
    tfidf_vectorizer = TfidfVectorizer()
    tfidf_matrix = tfidf_vectorizer.fit_transform([text, query])
    return (tfidf_matrix * tfidf_matrix.T).A[0,1]

#9)function
def get_polarity(text):
    '''

    :param text:
    :return:
    '''
    text = re.sub(r'https?:\/\/\S+', '', text)
    text = re.sub(r'RT @\S+', '', text)
    text = re.sub(r'@[^\s]+', '', text)
    text = re.sub(r'#', '', text)
    blob = TextBlob(text)
    return blob.sentiment.polarity

#10)function
def count_syllables(word):
    '''

    :param word:
    :return:
    '''
    d = cmudict.dict()
    if word.lower() not in d:
        return 0
    return max([len([y for y in x if y[-1].isdigit()]) for x in d[word.lower()]])

#11)function
def calculate_informality(text):
    '''

    :param text: input text
    :return:
    '''
    text = re.sub(r'https?:\/\/\S+', '', text)
    text = re.sub(r'RT @\S+', '', text)
    text = re.sub(r'@[^\s]+', '', text)
    text = re.sub(r'#', '', text)
    blob = TextBlob(text)
    tags = blob.tags
    word_count = len(tags)
    informal_count = 0
    for tag in tags:
        pos = tag[1]
        if pos == 'DT' or pos == 'IN' or pos == 'TO' or pos == 'PRP' or pos == 'MD' or pos == 'RB':
            informal_count += 1

    informality = informal_count / word_count if word_count else 1

    return informality

#12)function
def sevntement_value(text):
    '''

    :param text:
    :return:
    '''
    text = re.sub(r'https?:\/\/\S+', '', text)
    text = re.sub(r'RT @\S+', '', text)
    text = re.sub(r'@[^\s]+', '', text)
    text = re.sub(r'#', '', text)

    blob = TextBlob(text)
    sentiment_score = blob.sentiment.polarity
    if sentiment_score > 0:
        sentiment = 'positive'
    elif sentiment_score < 0:
        sentiment = 'negative'
    else:
        sentiment = 'neutral'
    return sentiment_score,sentiment

#13)function
def uncertainty(text):
    ''''''
    try:
        text = re.sub(r'https?:\/\/\S+', '', text)
        text = re.sub(r'RT @\S+', '', text)
        text = re.sub(r'@[^\s]+', '', text)
        text = re.sub(r'#', '', text)
        words = word_tokenize(text)
        tags = pos_tag(words)
        uncertain_count = 0
        for word, tag in tags:
            if tag in ['NN', 'NNS', 'NNP', 'NNPS', 'VB', 'VBD', 'VBG', 'VBN', 'VBP', 'VBZ', 'JJ', 'JJR', 'JJS', 'RB', 'RBR',
                       'RBS']:
                synonyms = wordnet.synsets(word)
                if len(synonyms) > 0:
                    definition = synonyms[0].definition()
                    if 'uncertain' in definition:
                        uncertain_count += 1
        return uncertain_count / len(words)
    except:
        return 0

#14)function
def next_id_search():
    ''''''
    next_id_url = f"{es_url}/{index_name}/_count"
    headers = {"Content-Type": "application/json"}
    time.sleep(2)
    response = requests.get(next_id_url, headers=headers)
    next_id = json.loads(response.text)["count"] + 1
    print(f'ID = {next_id-1}')
    return next_id
def tegs(tweet):
    return len(tweet.entities['hashtags'])
def inference(text: str):
    threshold = 0.5
    confidence = float(str(tf.get_static_value(tf.sigmoid(model(tf.constant([text])))[0][0])))
    is_fake = confidence > threshold
    return confidence, is_fake
#15)Main function
def func(search_query='Elon Musk',num_tweets=2):
    ''''''
    #until='2023-02-19'
    public_tweets = tweepy.Cursor(api.search_tweets,q=search_query, count=num_tweets,tweet_mode='extended',lang='en',until='2023-02-21').items(20)
    for tweet in public_tweets:
        screen_name = tweet.user.screen_name
        text = tweet.full_text
        #status = api.get_status(tweet.id, tweet_mode="extended")
        #text = status.full_text
        tegs(tweet)
        status_json=tweet._json
        if "extended_tweet" in status_json:
            text=status_json['extended_tweet']['full_text']
        elif 'retweeted_status' in status_json:
            if 'full_text' in status_json['retweeted_status']:
                text=status_json['retweeted_status']['full_text']
            else:
                text=status_json['text']
        else:
            text = status_json['full_text']
        print(f'\n\nTEXT = {text}\nLEN = {len(text)}')
        sentiment_score, sentiment=sevntement_value(text)
        pleasantness_score, activation_score, imagery_score=get_tweet_sentiment_scores(text)

        # Отримання наступного ID для дописування
        next_id=next_id_search()

        score_model_float,score_model_bool=inference(text)
        data = {
            "id":int(next_id),
            "tweet_id": tweet.id_str,
            'name': tweet.user.name,
            "created_at": tweet.created_at.strftime('%Y-%m-%dT%H:%M:%S.%fZ'),
            "time":datetime.datetime.now().strftime('%Y-%m-%dT%H:%M:%S.%fZ'),
            "screen_name": screen_name,
            "text": text,
            "search_query":search_query,
            'retweets': tweet.retweet_count,
            'user_followers': tweet.user.followers_count,
            'user_following': tweet.user.friends_count,
            "sentiment": sentiment,
            'complexity':textstat.flesch_kincaid_grade(text),
            'uncertainty':uncertainty(text),
            'informality':calculate_informality(text),
            'polarity':get_polarity(text),
            "tfi":calc_tfidf(text,search_query),
            'subjectivity':subjectivity(text),
            'contains_propaganda':contains_propaganda(text),
            'identify_false_context':identify_false_context(text),
            'pleasantness_score':pleasantness_score,
            'activation_score':activation_score,
            'imagery_score':imagery_score,
            'score_bot':score(screen_name,tweet.user.followers_count),
            'engagment_rate':engagment_rate(tweet),
            'location':tweet.user.location,
            'malicious':get_url(text),
            'tags':tegs(tweet),
            'score_fake_model_float':score_model_float,
            'score_fake_model_bool': score_model_bool,
        }
        url = f"{es_url}/{index_name}/_doc/{next_id}"
        #url=f"{es_url}/{index_name}/post/{next_id}?pretty"
        headers = {"Content-Type": "application/json"}
        response = requests.put(url, headers=headers, json=data)

        print(response.json())

def main():
    #################
    ######START######
    #################
    while True:
        response = requests.get("http://10.0.201.201:9200/topics/_search?size=1000")
        data = json.loads(response.text)
        titles = [hit['_source']['title'] for hit in data['hits']['hits']]
        print(titles)
        for title in titles:
            func(num_tweets=30, search_query=title)
if __name__ == '__main__':
    main()