import sys
from tqdm import tqdm
import csv
from inference import inference, batch_inference
from decouple import config
from main_with_model import uncertainty, sevntement_value, calculate_informality, get_polarity, subjectivity,\
    contains_propaganda, identify_false_context, get_tweet_sentiment_scores
batch_size = 32
dataset_dir = config("DATSET_DIR", "D:\\fake_news\kaggle")


def process_item(item, type = "twitter"):
    if type == "article":
        text = item['articles']
        title = item['headlines']
        text = title+"\n"+text
        show = title
    else:
        text = item[3]
        show = item[3]
    score, fake = inference(text)
    return score, show


def process_batch(batch, type = "twitter"):
    if type == "article":
        text_batch = [item['articles'] for item in batch]
        title_batch = [item['headlines'] for item in batch]
        text_batch = [title+"\n"+text for title,text in zip(text_batch, title_batch)]
        show_batch = title_batch
    else:
        text_batch = [item[3] for item in batch]
        show_batch = text_batch
    score_fake = batch_inference(text_batch)
    return zip([(score, fake) for score, fake in score_fake], show_batch)


def load_dataset(dataset_file_path):
    df = csv.reader(open(dataset_file_path, encoding="UTF-8"))
    result = []
    iterator = iter(df)
    data = []
    header = next(iterator)
    while True:
        try:
            item = next(iterator)
            data.append(item)
        except(StopIteration):
            break
        except(Exception):
            continue
    if len(sys.argv)>2:
        data = data[int(sys.argv[2]): int(sys.argv[3])]
    print(len(data))
    for i in tqdm(range(0, len(data), batch_size)):
        result.extend(process_batch(data[i:i+batch_size]))

    with open(dataset_file_path.rsplit(".", 1)[0]+"_processed.csv", "w", encoding="UTF-8", newline='') as file:
        writer = csv.writer(file)
        header.extend(["score", "status", "uncertainty", "sevntement value", "informality", "polarity", "subjectivity", "contains propaganda", "has false context",  "pleasantness score", "activation score", "imagery score"])
        writer.writerow(header)
        for (dataitem, result_item) in tqdm(list(zip(data, result))):
            (score, fake), _ = result_item
            text = dataitem[3]
            pleasantness_score, activation_score, imagery_score = get_tweet_sentiment_scores(text)
            dataitem.extend([score, fake,  uncertainty(text), sevntement_value(text), calculate_informality(text), get_polarity(text), subjectivity(text), contains_propaganda(text), identify_false_context(text), pleasantness_score, activation_score, imagery_score])
            writer.writerow(dataitem)
    result.sort(key=lambda score_fake_show: score_fake_show[0][0])
    for (score, fake), show in result:
        print(score, show)


if __name__=="__main__":
    dataset_file_path = "D:\\fake_news\Datasets\\Ukraine_border.csv" if len(sys.argv) == 1 else sys.argv[1]
    load_dataset(dataset_file_path)