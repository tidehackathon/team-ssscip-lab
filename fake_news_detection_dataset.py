import pandas as pd
import os
from decouple import config
from sys import argv

# could be overriden with command line
file_path = {0: "D:\\fake_news\Datasets\\True.csv", 1: "D:\\fake_news\Datasets\\Fake.csv"}
dataset_dir = config("DATSET_DIR", "D:\\fake_news\kaggle")

def process_item(label, item):
    id = item.name
    label = label
    text = item['text']
    title = item['title']
    file_name = os.path.join(dataset_dir, str(label), f"fnd-{id}.txt")
    with open(file_name, "w", encoding="utf-8") as file:
        try:
            if isinstance(title, str):
                file.write(title)
            if isinstance(text, str):
                file.write(text)
        except Exception as e:
            print("id", id, "title", title, "label", label, "problem", e)


def load_fnd():
    for label in range(2):
        csv = pd.read_csv(file_path[label])
        os.makedirs(os.path.join(dataset_dir, str(label)), exist_ok=True)
        csv.apply(lambda item: process_item(label, item), axis=1)


if __name__=="__main__":
    if len(argv) > 2:
        file_path= {0: argv[1], 1: argv[2]}
    load_fnd()
