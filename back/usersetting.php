<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" >
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <meta charset="UTF-8">
  <title>Sixl - stop fake</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="app">
	<header class="app-header">
		<div class="app-header-logo">
			<div class="logo">
				<span class="logo-icon">
					<img style="width: 95px;" src="logo.png" />
				</span>
				<h1 class="logo-title">
					<span>SIXL</span>
					<span style="color:#1762ae"/> STOP FAKE</span>
				</h1>
			</div>
		</div>
		<div class="app-header-navigation">
			<div class="tabs">
				<a href="#" class="active">
					Overview
				</a>
				
			</div>
		</div>
		<div class="app-header-actions">
			<button class="user-profile">
				<span>VSB</span>
				
			</button>
			<div class="app-header-actions-buttons">
				
				<button class="icon-button large">
					<i class="ph-bell"></i>
				</button>
			</div>
		</div>
		<div class="app-header-mobile">
			<button class="icon-button large">
				<i class="ph-list"></i>
			</button>
		</div>

	</header>
	<div class="app-body">
		<div class="app-body-navigation">
			<nav class="navigation">
				<a href="#">
					<i class="ph-browsers"></i>
					<span>Dashboard</span>
				</a>
				<a href="#">
					<i class="ph-check-square"></i>
					<span>Scheduled</span>
				</a>
				<a href="#">
					<i class="ph-swap"></i>
					<span>Kibana</span>
				</a>
				<a href="#">
					<i class="ph-file-text"></i>
					<span>History</span>
				</a>
				
			</nav>
			<footer class="footer">
				<h1>SIXL<small>©</small></h1>
				
			</footer>
		</div>
		<div class="app-body-main-content">
			<section class="service-section">
				<!--<h2>Telegram</h2>
				<div class="service-section-header">
					<div class="search-field">
						<i class="ph-magnifying-glass"></i>
						<input type="text" placeholder="Request to search">
					</div>
					<div class="dropdown-field">
						<select>
							<option>Group 1 </option>
							<option>Group 2 </option>
						</select>
						<i class="ph-caret-down"></i>
					</div>
					<button class="flat-button">
						Search
					</button>
				</div>
<br><br>
				<br><br><br> -->
				<h2>Monitoring system</h2>
				<div class="service-section-header">
					<div class="search-field">
						<i class="ph-magnifying-glass"></i>
                        <div id="topics">
  <!-- Кожен блок містить назву теми та кнопку для її видалення -->
  <div class="topic">
    <span>Назва теми 1</span>
    <button onclick="deleteTopic('назва_теми_1')">Видалити</button>
  </div>
  <div class="topic">
    <span>Назва теми 2</span>
    <button onclick="deleteTopic('назва_теми_2')">Видалити</button>
  </div>
  <!-- та так далі... -->
</div>
                        <script>
	// Функція для отримання списку топіків та оновлення списку на сторінці
function updateTopicsList() {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var data = JSON.parse(xhr.responseText);
      var topicsList = document.getElementById('topics');
      topicsList.innerHTML = ''; // очистити вміст, щоб відображати оновлені теми
      for (var i = 0; i < data.titles.length; i++) {
        var topicHtml = '<div class="topic">' +
                          '<span>' + data.titles[i] + '</span>' +
                          '<button onclick="deleteTopic(\'' + data.titles[i] + '\')">Видалити</button>' +
                        '</div>';
        topicsList.innerHTML += topicHtml;
      }
    }
  };
  xhr.open('GET', 'gettopic.php', true);
  xhr.send();
}

// Функція для видалення теми з індексу topics
function deleteTopic(topicTitle) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      alert('Тема "' + topicTitle + '" видалена з Elasticsearch');
      updateTopicsList(); // оновити список тем після видалення
    }
  };
  xhr.open('DELETE', 'deletetopic.php?title=' + topicTitle, true);
  xhr.send();
}

// Викликаємо функцію для оновлення списку топіків
updateTopicsList();
	</script>
				
				</div>

				
			</section>
		</div>
		<!--<div class="app-body-sidebar">
			<section class="payment-section">
				<h2>New Fake</h2>
				<div class="payment-section-header">
					<p>Latest dissinformation from Twitter</p>
					
			</section>
		</div> -->
	</div>
</div>
<!-- partial -->
  <script src='https://unpkg.com/phosphor-icons'></script><script  src="./script.js"></script>

</body>
</html>
