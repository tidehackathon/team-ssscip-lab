import tensorflow as tf
# needed for model to load
import tensorflow_text as tf_text
from typing import Tuple, List
threshold = 0.99999
model = tf.saved_model.load("../bert_fake_detector")


def normalised_score(confidence):
    return confidence/2/threshold if confidence < threshold else 0.5+(confidence-threshold)/2/(1-threshold)


def inference(text: str) -> Tuple[float, bool]:
    confidence = tf.get_static_value(tf.sigmoid(model(tf.constant([text])))[0][0]).item()
    is_fake = confidence > threshold
    return normalised_score(confidence), is_fake


def batch_inference(batch: List[str]) -> List[Tuple[float, bool]]:
    result = tf.sigmoid(model(tf.constant(batch)))
    confidences = tf.get_static_value(result)
    return [(normalised_score(confidence[0]), confidence[0]>threshold) for confidence in confidences]


if __name__ == "__main__":
    result = batch_inference(["Крим - це Україна", "Путін Хуйло"])
    print(result)

