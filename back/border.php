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
					<span style="color:#1762ae">SIXL</span>
					<span style="color:#1762ae"> STOP FAKE</span> 
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
				<span style="    background-color: #0163b1;font-size:15px;" >VSB</span>
				
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
				<a href="statistics.php">
					<i class="ph-check-square"></i>
					<span>Statistic</span>
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
			<section style="max-width:1000px;" class="service-section">
				<h2>Monitoring system</h2>
				<div class="service-section-header">
					<div class="search-field">
						<i class="ph-magnifying-glass"></i>
						
						<form id="myForm" method="post" action="addtopic.php"> <input id="myInput" name="title" type="text" placeholder="
Enter the request you want to add to monitoring">
					</div>
					
					<button type="submit" style="background-color:#0163b1;" class="flat-button">
						Add
					</button> 
						</form>
						<script>
							// Отримуємо форму та інпут
var form = document.getElementById('myForm');
var input = document.getElementById('myInput');

// Додаємо обробник події на подію відправки форми
form.addEventListener('submit', function(event) {
  event.preventDefault(); // Відміна стандартної поведінки браузера
  
  // Створюємо новий об'єкт XMLHttpRequest
  var xhr = new XMLHttpRequest();
  
  // Встановлюємо метод та адресу запиту
  xhr.open('POST', 'addtopic.php');
  
  // Встановлюємо заголовки запиту, якщо потрібно
  
  // Встановлюємо обробник події, що виконається при отриманні відповіді
  xhr.onload = function() {
    if (xhr.status === 200) {
      // Відображаємо повідомлення успіху
    }
    else {
      // Відображаємо повідомлення про помилку
      var errorMessage = document.createElement('p');
      errorMessage.textContent = 'Сталася помилка під час додавання запиту до моніторингу. Будь ласка, спробуйте ще раз.';
      form.parentNode.insertBefore(errorMessage, form.nextSibling);
    }
    
    // Очищаємо значення інпуту
    input.value = '';
  };
  
  // Відправляємо запит з даними форми
  xhr.send(new FormData(form));
});
						</script>
				</div> 
				<br><br>
				<style>
					th{
						color:#1762ae;
						font-size:18px;
					}
					TD{
						font: inherit;
						min-width:120px;
						color:black;
						padding: 3px; /* Поля вокруг содержимого таблицы */
    border: 0.2px solid white; /* Параметры рамки */
					}
					TABLE {
    border-collapse: collapse; /* Убираем двойные линии между ячейками */
   }
				</style>
				<div style="padding: 15px;
    border: 1px solid white;
    color: white;
    text-align: center;
    background-color: #1762ae;
    "><p id="topics"></p>
		</ul></div>
<br><br>
<div>
		
	</div>
	<div class="row">

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-4 col-md-6 mb-4">
	<div style="width: 100%;height: 125px!important;" class="card border-left-primary shadow h-100 py-2">
		<div class="card-body">
			<div class="row no-gutters align-items-center">
				<div class="col mr-2">
					<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
						Tweets summary</div>
					<div class="h5 mb-0 font-weight-bold text-gray-800">
					<span id="count"></span>

<script>
	// Функція для отримання загальної кількості документів та оновлення списку на сторінці
	function updateTweetCount() {
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('count').innerHTML = xhr.responseText;
			}
		};
		xhr.open('GET', 'gettwetsweekly.php', true);
		xhr.send();
	}

	// Викликаємо функцію для оновлення загальної кільості документів кожні 10 секунд
	setInterval(updateTweetCount, 1000);
</script></div>
				</div>
				<div class="col-auto">
					<i style="font-size:3.333333em;" class="fa fa-comment fa-lg"></i>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-4 col-md-6 mb-4">
	<div style="width: 100%;height: 125px!important;" class="card border-left-success shadow h-100 py-2">
		<div class="card-body">
			<div class="row no-gutters align-items-center">
				<div class="col mr-2">
					<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
					Tweets(day)</div>
					<div class="h5 mb-0 font-weight-bold text-gray-800">
					<span id="count_day"></span>

<script>
	// Функція для отримання загальної кількості документів та оновлення списку на сторінці
	function updateTweetCount() {
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('count_day').innerHTML = xhr.responseText;
			}
		};
		xhr.open('GET', 'gettweetsday.php', true);
		xhr.send();
	}

	// Викликаємо функцію для оновлення загальної кільості документів кожні 10 секунд
	setInterval(updateTweetCount, 100);
</script>
	
					</div>
				</div>
				<div class="col-auto">
				<i style="font-size:3.333333em;" class="fa fa-comment"></i>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-4 col-md-6 mb-4">
<div style="width: 100%;height: 125px!important;"  class="card border-left-info shadow h-100 py-2">
		<div class="card-body">
			<div class="row no-gutters align-items-center">
				<div class="col mr-2">
					<div class="text-xs font-weight-bold text-info text-uppercase mb-1">% Propaganda all time
					</div>
					<div class="row no-gutters align-items-center">
						<div class="col-auto">
							<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">	<span id="count_fc"></span>
						<span id="false_content_percentage"></span>



						<script>
    // Функція для отримання кількості твітів з фейком та оновлення значення на сторінці
    function updateFalseContentCount() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var falseCount = parseInt(xhr.responseText);
                var totalXhr = new XMLHttpRequest();
                totalXhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var totalCount = parseInt(totalXhr.responseText);
                        var percentage = (falseCount / totalCount) * 100;
                        document.getElementById('false_content_percentage').innerHTML = percentage.toFixed(2) + "%";
                        document.querySelector('.progress-bar').style.width = percentage.toFixed(2) + "%";
                        document.querySelector('.progress-bar').setAttribute('aria-valuenow', percentage.toFixed(2));
                    }
                };
                totalXhr.open('GET', 'gettwetsweekly.php', true);
                totalXhr.send();
            }
        };
        xhr.open('GET', 'getfalsecontentalltime.php', true);
        xhr.send();
    }

    // Викликаємо функцію для оновлення кількості твітів з фейком та відношення кожні 10 секунд
    setInterval(updateFalseContentCount, 1000);
</script>

	</div>
						</div>
						<div class="col-md-4">
							<div class="progress progress-sm mr-2">
								<div class="progress-bar bg-info" role="progressbar"
									style="width: 50%" aria-valuenow="50" aria-valuemin="0"
									aria-valuemax="100"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-auto">
				<i style="font-size:3.333333em;" class="fa fa-bolt"></i>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
	<script>
		// Функція для отримання списку топіків та оновлення списку на сторінці
function updateTopicsList() {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          var data = JSON.parse(xhr.responseText);
          var topicsList = document.getElementById('topics');
          var topicsHtml = '';
          for (var i = 0; i < data.titles.length; i++) {
              topicsHtml += '<b>' + data.titles[i] + '</b>';
              if (i < data.titles.length - 1) {
                  topicsHtml += ', ';
              }
          }
          topicsList.innerHTML = '<p>' + topicsHtml + '</p>';
      }
  };
  xhr.open('GET', 'gettopic.php', true);
  xhr.send();
}

// Викликаємо функцію для оновлення списку топіків кожну секунду
setInterval(updateTopicsList, 1000);
	</script>
	<br><br><h2>Latest fake tweets by selected topics:</h2>
				<div style="
				padding: 15px;
    border: 1px solid #1762ae;
    color: white;
    text-align: center;
   ">
			
			<script>
		function loadTweets() {
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			// Отримуємо результат запиту
			var response = JSON.parse(xhr.responseText);
			// Виводимо результат на сторінку
			var tableRows = "";
			response.forEach(function(tweet) {
				tableRows += "<tr>" +
								"<td>" + tweet.screen_name + "</td>" +
								"<td>" + tweet.text + "</td>" +
								"<td>" + tweet.retweets + "</td>" +
								"<td>" + tweet.user_followers + "</td>" +
								"<td>" + tweet.user_following + "</td>" +
								"<td>" + tweet.sentiment + "</td>" +
							"</tr>";
			});
			document.getElementById("tweets").innerHTML = tableRows;
		}
	};
	xhr.open('GET', 'gettweets.php', true);
	xhr.send();
}

// Оновлюємо дані кожну секунду
setInterval(loadTweets, 1000);
	</script>
</head>
<body>
	<table style="max-width:1100px;" id="tweets_table">
	<thead>
		<tr>
			<th>Name</th>
			<th>Tweet</th>
			<th>Retweet</th>
			<th>Foolowers</th>
			<th>Following</th>
			<th>Sentiment</th>
		</tr>
	</thead>
	<tbody id="tweets">
	</tbody>
</table>
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
