<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true) {
    header("Location: index.php");
    exit;
}
$tweets_weekly=file_get_contents('http://10.0.201.200/gettwetsweekly.php');  // all tweets
$tweets_per_day=file_get_contents('http://10.0.201.200/gettweetsday.php');  // tweets per day
$false_content=file_get_contents('http://10.0.201.200/getfalsecontentalltime.php'); //alltimefalse contect
$negativ_sentimant=file_get_contents('http://10.0.201.200/getneutrallalltime.php?sentiment=negative');  //negative all time
$positive_sentimant= file_get_contents('http://10.0.201.200/getneutrallalltime.php?sentiment=positive'); //positive all time
$neutral_sentimant=  file_get_contents('http://10.0.201.200/getneutrallalltime.php?sentiment=neutral'); //neutrall all time
$percent_neutral_sentimant = ($neutral_sentimant / $tweets_weekly) * 100; 
$percent_netral_rounded = number_format($percent_neutral_sentimant, 2);
$percent_negativ_sentimant = ($negativ_sentimant / $tweets_weekly) * 100;
$percent_negativ_rounded = number_format($percent_negativ_sentimant, 2);
$percent_fc = ($false_content / $tweets_weekly) * 100;
$percent_fc_rounded = number_format($percent_fc, 2);
// Створити запит до ElasticSearch
$query = [
    "size" => 0,
    "aggs" => [
        "group_by_screen_name" => [
            "terms" => [
                "field" => "screen_name.keyword",
                "size" => 10,
                "min_doc_count" => 2
            ],
            "aggs" => [
                "post_text" => [
                    "terms" => [
                        "field" => "text.keyword",
                        "size" => 10
                    ]
                ]
            ]
        ]
    ]
];
$queryJson = json_encode($query);

// Виконати запит до ElasticSearch і вивести результат
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://10.0.201.201:9200/blog/_search");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $queryJson);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$response = curl_exec($ch);
curl_close($ch);

// Перетворити відповідь в масив PHP та вивести результат
$data = json_decode($response, true);
$topUsers = array_slice($data['aggregations']['group_by_screen_name']['buckets'], 0, 5);
$firstUser5 = $topUsers[0];
$firstUser4 = $topUsers[1];
$firstUser3 = $topUsers[2];
$firstUser2 = $topUsers[3];
$firstUser1 = $topUsers[1];
?>

<!DOCTYPE html>
<html lang="en" >
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

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
				<span style="background-color:#0163b1;">VSB</span>
				
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
				<a href="border.php">
					<i class="ph-browsers"></i>
					<span>Dashboard</span>
				</a>
				<a href="#">
					<i class="ph-check-square"></i>
					<span>Statistics</span>
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
					<div class="text-xs font-weight-bold text-primary text-info text-uppercase mb-1">
						Tweets summary</div>
					<div class="h5 mb-0 font-weight-bold text-gray-800">
					<span id="count"><?php echo $tweets_weekly; ?></span></div>
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
					<div class="text-xs font-weight-bold text-info text-uppercase mb-1">
					Tweets per day</div>
					<div class="h5 mb-0 font-weight-bold text-gray-800">
					<span id="count_day"><?php echo $tweets_per_day;?></span>
	
					</div>
				</div>
				<div class="col-auto">
				<i style="font-size:3.333333em;" class="fa fa-tag"></i>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="col-xl-4 col-md-6 mb-4">
	<div style="width: 100%;height: 125px!important;" class="card border-left-success shadow h-100 py-2">
		<div class="card-body">
			<div class="row no-gutters align-items-center">
				<div class="col mr-2">
					<div class="text-xs font-weight-bold text-info text-uppercase mb-1">
					Tweets with propaganda for all time </div>
					<div class="h5 mb-0 font-weight-bold text-gray-800">
					<span id="count_day"><?php echo $false_content;?></span>
	
					</div>
				</div>
				<div class="col-auto">
				<i style="font-size:3.333333em;" class="fa fa-tag"></i>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="row">

<div class="col-xl-4 col-md-6 mb-4">
	<div style="width: 95%;height: 125px!important;" class="card border-left-primary shadow h-100 py-2">
		<div class="card-body">
			<div class="row no-gutters align-items-center">
				<div class="col mr-2">
					<div class="text-xs font-weight-bold text-success text-primary text-uppercase mb-1">
						Tweets with neutral sentimant</div>
					<div class="h5 mb-0 font-weight-bold text-gray-800">
					<span id="count"><?php echo $neutral_sentimant; ?></span></div>
				</div>
				<div class="col-auto">
					<i style="font-size:3.333333em;" class="fa fa-bell fa-lg"></i>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-xl-4 col-md-6 mb-4">
	<div style="width: 100%;height: 125px!important;" class="card border-left-primary shadow h-100 py-2">
		<div class="card-body">
			<div class="row no-gutters align-items-center">
				<div class="col mr-2">
					<div class="text-xs text-success font-weight-bold text-primary text-uppercase mb-1">
						Tweets with positive sentimant</div>
					<div class="h5 mb-0 font-weight-bold text-gray-800">
					<span id="count"><?php echo $positive_sentimant; ?></span></div>
				</div>
				<div class="col-auto">
					<i style="font-size:3.333333em;" class="fa fa-check fa-lg"></i>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-xl-4 col-md-6 mb-4">
	<div style="width: 100%;height: 125px!important;" class="card border-left-primary shadow h-100 py-2">
		<div class="card-body">
			<div class="row no-gutters align-items-center">
				<div class="col mr-2">
					<div class="text-xs text-success font-weight-bold text-primary text-uppercase mb-1">
						Tweets with negativ sentimant</div>
					<div class="h5 mb-0 font-weight-bold text-gray-800">
					<span id="count"><?php echo $negativ_sentimant; ?></span></div>
				</div>
				<div class="col-auto">
					<i style="font-size:3.333333em;" class="fa fa-filter fa-lg"></i>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="row">

<!-- Area Chart -->
<div class="col-xl-12 col-lg-12">
	<div class="card shadow mb-4">
		<!-- Card Header - Dropdown -->
		<div
			class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
			<h6 class="m-0 font-weight-bold text-primary">Tweets per week</h6>
			
		</div>
		<!-- Card Body -->
		<div class="card-body">
			<div class="chart-area">
				<canvas id="myAreaChart"></canvas>
			</div>
		</div>
	</div>
</div>
</div>

<div class="row">

<div class="col-xl-7 col-md-7 mb-7"> 
<div class="card shadow mb-4">
<div class="card-header py-3">
            <h6 style="font-size:20px;" class="m-0 font-weight-bold text-primary">Top 5 Aggresive user</h6>
        </div>	
<div class="card-body">

            <h4 class="small font-weight-bold"><?php echo $firstUser5['key']; ?><span
                    class="float-right">- <?php echo $firstUser5['doc_count']; ?> post </span></h4>
            <div class="progress mb-4">
                <div class="progress-bar bg-danger" role="progressbar" style="width:  <?php echo $firstUser5['doc_count']; ?>%"
                    aria-valuenow="20" aria-valuemin="0" aria-valuemax="20"></div>
            </div>
            <h4 class="small font-weight-bold"><?php echo $firstUser4['key']; ?> <span
                    class="float-right"> - <?php echo $firstUser4['doc_count']; ?> post</span></h4>
            <div class="progress mb-4">
                <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $firstUser4['doc_count']; ?>%"
                    aria-valuenow="20" aria-valuemin="0" aria-valuemax="20"></div>
            </div>
            <h4 class="small font-weight-bold"><?php echo $firstUser3['key']; ?> <span
                    class="float-right"> - <?php echo $firstUser3['doc_count']; ?> post</span></h4>
            <div class="progress mb-4">
                <div class="progress-bar" role="progressbar" style="width:  <?php echo $firstUser3['doc_count']; ?>%"
                    aria-valuenow="20" aria-valuemin="0" aria-valuemax="20"></div>
            </div>
            <h4 class="small font-weight-bold"><?php echo $firstUser2['key']; ?> <span
                    class="float-right">- <?php echo $firstUser2['doc_count']; ?> post</span></h4>
            <div class="progress mb-4">
                <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $firstUser2['doc_count']; ?>%"
                    aria-valuenow="20" aria-valuemin="0" aria-valuemax="20"></div>
            </div>
            <h4 class="small font-weight-bold"><?php echo $firstUser1['key']; ?>  <span
                    class="float-right">- <?php echo $firstUser1['doc_count']; ?> post</span></h4>
            <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $firstUser1['doc_count']; ?>%"
                    aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
            
				</div>
				
        </div></div></div>
<div class="col-xl-5 col-md-6 mb-3"><div class="card shadow mb-4">
		<!-- Card Header - Dropdown -->
		<div
			class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
			<h6 style="font-size:20px;" class="m-0 font-weight-bold text-primary">Sensetive diagram</h6>
			
		</div>
		<!-- Card Body -->
		<div class="card-body">
			<div class="chart-pie pt-4 pb-2">
				<canvas id="myPieChart"></canvas>
			</div>
			<div class="mt-4 text-center small">
				<span class="mr-2">
					<i class="fas fa-circle text-primary"></i> Negative
				</span>
				<span class="mr-2">
					<i class="fas fa-circle text-success"></i> Positive
				</span>
				<span class="mr-2">
					<i class="fas fa-circle text-info"></i> Neutral
				</span>
			</div>
		</div>
	</div></div>

</div>

<div class="row">

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-3">
<div style="width: 100%;height: 125px!important;"  class="card border-left-info shadow h-100 py-2">
		<div class="card-body">
			<div class="row no-gutters align-items-center">
				<div class="col mr-2">
					<div class="text-xs font-weight-bold text-uppercase mb-1"> Percent with neutral sentiment for all time
					</div>
					<div class="row no-gutters align-items-center">
						<div class="col-auto">
							<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">	<span id="count_fc"></span>
						<span id="false_content_percentage"></span>


<?php 
echo $percent_netral_rounded.'%';
?> 
			

	</div>
						</div>
						<div class="col-md-8">
							<div class="progress progress-sm mr-2">
								<div class="progress-bar bg-info" role="progressbar"
									style="width: <?php echo $percent_netral_rounded; ?>%" aria-valuenow="10" aria-valuemin="0"
									aria-valuemax="100"></div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-3">
<div style="width: 100%;height: 125px!important;"  class="card border-left-info shadow h-100 py-2">
		<div class="card-body">
			<div class="row no-gutters align-items-center">
				<div class="col mr-2">
					<div class="text-xs font-weight-bold text-uppercase mb-1"> Percent propaganda for all time
					</div>
					<div class="row no-gutters align-items-center">
						<div class="col-auto">
							<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">	<span id="count_fc"></span>
						<span id="false_content_percentage"></span>


						<?php 
echo $percent_negativ_rounded.'%';
?> 
			

	</div>
						</div>
						<div class="col-md-8">
							<div class="progress progress-sm mr-2">
								<div class="progress-bar bg-info" role="progressbar"
									style="width: <?php echo $percent_negativ_rounded; ?>%" aria-valuenow="10" aria-valuemin="0"
									aria-valuemax="100"></div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-3">
<div style="width: 100%;height: 125px!important;"  class="card border-left-info shadow h-100 py-2">
		<div class="card-body">
			<div class="row no-gutters align-items-center">
				<div class="col mr-2">
					<div class="text-xs font-weight-bold text-uppercase mb-1"> Percent positive sentimental for all time
					</div>
					<div class="row no-gutters align-items-center">
						<div class="col-auto">
							<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">	<span id="count_fc"></span>
						<span id="false_content_percentage"></span>


						<?php 
$percent_positive_sentimant = ($positive_sentimant / $tweets_weekly) * 100;
$percent_positive_rounded = number_format($percent_positive_sentimant, 2);
echo $percent_positive_rounded.'%';
?> 
			

	</div>
						</div>
						<div class="col-md-8">
							<div class="progress progress-sm mr-2">
								<div class="progress-bar bg-info" role="progressbar"
									style="width: <?php echo $percent_positive_rounded; ?>%" aria-valuenow="10" aria-valuemin="0"
									aria-valuemax="100"></div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-3">
<div style="width: 100%;height: 125px!important;"  class="card border-left-info shadow h-100 py-2">
		<div class="card-body">
			<div class="row no-gutters align-items-center">
				<div class="col mr-2">
					<div class="text-xs font-weight-bold text-uppercase mb-1"> Percent propaganda for all time
					</div>
					<div class="row no-gutters align-items-center">
						<div class="col-auto">
							<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">	<span id="count_fc"></span>
						<span id="false_content_percentage"></span>


<?php 
echo $percent_fc_rounded.'%';
?> 
			

	</div>
						</div>
						<div class="col-md-8">
							<div class="progress progress-sm mr-2">
								<div class="progress-bar bg-info" role="progressbar"
									style="width: <?php echo $percent_fc_rounded; ?>%" aria-valuenow="10" aria-valuemin="0"
									aria-valuemax="100"></div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
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
	<?php

// Отримуємо поточну дату
$today = new DateTime('now');
$todayStr = $today->format('Y-m-d');

// Формуємо асоціативний масив з датами
$counts = array();
$counts[$todayStr] = 0;
for ($i = 1; $i < 7; $i++) {
    $date = $today->sub(new DateInterval('P1D'))->format('Y-m-d');
    $counts[$date] = 0;
}

// Формуємо запит до ElasticSearch та отримуємо кількість документів для кожної дати
$results = array();
foreach ($counts as $date => &$count) {
    $query = json_encode([
        "query" => [
            "match" => [
                "created_at" => $date
            ]
        ]
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://10.0.201.201:9200/blog/_count");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    $count = $data['count'];

    // Додаємо елемент до масиву результатів
    $results[] = array("date" => $date, "count" => $count);
}

// Виводимо кількість документів для кожної дати

// Виводимо перший елемент масиву результатів як окрему змінну
$firstResult = $results[0];
$labels = array();
foreach ($results as $result) {
    $labels[] = $result["date"];
}
$labels = array_reverse($labels);
?>
</div>

</div>
</div>

			
<!-- partial -->
<script src="Chart.js"></script>

  <script src='https://unpkg.com/phosphor-icons'></script><script  src="./script.js"></script>
<script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
	labels: [<?php echo '"' . implode('", "', $labels) . '"'; ?>],
    datasets: [{
      label: "Count of tweets",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
	  data: [
    <?php echo $results[count($results) - 1]['count'] ?>,
    <?php echo $results[count($results) - 2]['count'] ?>,
    <?php echo $results[count($results) - 3]['count'] ?>,
    <?php echo $results[count($results) - 4]['count'] ?>,
    <?php echo $results[count($results) - 5]['count'] ?>,
    <?php echo $results[count($results) - 6]['count'] ?>,
    <?php echo $results[count($results) - 7]['count'] ?>
],    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return '' + number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ':' + number_format(tooltipItem.yLabel);
        }
      }
    }
  }
});


</script>
<script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Negative", "Positive", "Neutral"],
    datasets: [{
      data: [<?php echo $negativ_sentimant; ?>, <?php echo $positive_sentimant; ?>, <?php echo $neutral_sentimant; ?>],
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});

</script>
</body>
</html>
