<?php $negativ_sentimant=file_get_contents('http://10.0.201.200/getneutrallalltime.php?sentiment=negative'); 
      $positive_sentimant= file_get_contents('http://10.0.201.200/getneutrallalltime.php?sentiment=positive');
      $neutral_sentimant=  file_get_contents('http://10.0.201.200/getneutrallalltime.php?sentiment=neutral');
?>
<div>
    <h2>Категорія "negative":</h2>
    <p></p>
</div>

<div>
    <h2>Категорія "positive":</h2>
    <p><?php echo $positive_sentimant; ?></p>
</div>

<div>
    <h2>Категорія "neutral":</h2>
    <p><?php echo file_get_contents('http://10.0.201.200/getneutrallalltime.php?sentiment=neutral'); ?></p>
</div>
