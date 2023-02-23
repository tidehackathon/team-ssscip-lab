import pandas as pd
import os
from decouple import config
dataset_file_path = "D:\\fake_news\Datasets\\train.csv"
dataset_dir = config("DATSET_DIR", "D:\\fake_news\kaggle")


def process_item(item):
    id = item["id"]
    label = item["label"]
    author = item["author"]
    text = item['text']
    title = item['title']
    file_name = os.path.join(dataset_dir, str(label), f"{id}.txt")
    with open(file_name, "w", encoding="utf-8") as file:
        try:
            if isinstance(title, str):
                file.write(title)
            if isinstance(text, str):
                file.write(text)
            if isinstance(author, str):
                file.write(author)
        except Exception as e:
            print("id", id, "title", title, "labe;", label, "author", author, "problem", e)


def load_kaggle():
    csv = pd.read_csv(dataset_file_path)
    os.makedirs(os.path.join(dataset_dir, "0"), exist_ok=True)
    os.makedirs(os.path.join(dataset_dir, "1"), exist_ok=True)
    csv.apply(process_item, axis=1)


if __name__=="__main__":
    load_kaggle()
