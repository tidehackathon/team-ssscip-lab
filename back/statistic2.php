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
				<a href="index.php">
					<i class="ph-browsers"></i>
					<span>Dashboard</span>
				</a>
				<a href="#">
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
			<section style="width:1000px;" class="service-section">
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
				<h2>Statisctis</h2>
		
				
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
					<div class="text-xs font-weight-bold text-info text-uppercase mb-1">% Propaganda today
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
        xhr.open('GET', 'getfalsecontect.php', true);
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
			</section>
            <div class="row">

<!-- Content Column -->
<div class="col-lg-12 mb-4">


    <!-- Project Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Aggresive user</h6>
        </div>
        <div class="card-body">
            <h4 class="small font-weight-bold">Server Migration <span
                    class="float-right">20%</span></h4>
            <div class="progress mb-4">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 20%"
                    aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <h4 class="small font-weight-bold">Sales Tracking <span
                    class="float-right">40%</span></h4>
            <div class="progress mb-4">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"
                    aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <h4 class="small font-weight-bold">Customer Database <span
                    class="float-right">60%</span></h4>
            <div class="progress mb-4">
                <div class="progress-bar" role="progressbar" style="width: 60%"
                    aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <h4 class="small font-weight-bold">Payout Details <span
                    class="float-right">80%</span></h4>
            <div class="progress mb-4">
                <div class="progress-bar bg-info" role="progressbar" style="width: 80%"
                    aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <h4 class="small font-weight-bold">Account Setup <span
                    class="float-right">Complete!</span></h4>
            <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
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
