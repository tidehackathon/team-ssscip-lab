import pandas as pd
import os
dataset_file_path = "D:\\fake_news\Datasets\\MC_Fake_dataset_MC_Fake_dataset.csv"
dataset_dir = "D:\\fake_news\kaggle"

def process_item(item):
    id = item["news_id"]
    label = item["labels"]
    text = item['text']
    title = item['title']
    file_name = os.path.join(dataset_dir, str(label), f"{id}.txt")
    with open(file_name, "w", encoding="utf-8") as file:
        try:
            if isinstance(title, str):
                file.write(title)
            if isinstance(text, str):
                file.write(text)
        except Exception as e:
            print("id", id, "title", title, "labe;", label, "author", author, "problem", e)


def load_MC_fake():
    with open(dataset_file_path, encoding="UTF-8") as file:
        for number, line in enumerate(file.readlines()):
            if number in range(4):
                print(line)
    csv = pd.read_csv(dataset_file_path, sep=';')
    print(list(csv))
    os.makedirs(os.path.join(dataset_dir, "0"), exist_ok=True)
    os.makedirs(os.path.join(dataset_dir, "1"), exist_ok=True)
    csv.apply(process_item, axis=1)


if __name__=="__main__":
    load_MC_fake()