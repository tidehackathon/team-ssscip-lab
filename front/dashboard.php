<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true) {
    header("Location: ../index.php");
    exit;
} 
$tweets_alltime=file_get_contents('http://10.0.201.200/back/gettwetsweekly.php');  // all tweets
$tweets_per_day=file_get_contents('http://10.0.201.200/back/gettweetsday.php');  // tweets per day
$false_content=file_get_contents('http://10.0.201.200/back/getfalsecontentalltime.php'); //alltimefalse contect
$negativ_sentimant=file_get_contents('http://10.0.201.200/back/getneutrallalltime.php?sentiment=negative');  //negative all time
$positive_sentimant= file_get_contents('http://10.0.201.200/back/getneutrallalltime.php?sentiment=positive'); //positive all time
$neutral_sentimant=  file_get_contents('http://10.0.201.200/back/getneutrallalltime.php?sentiment=neutral'); //neutrall all time
$fake_tweets_per_day=  file_get_contents('http://10.0.201.200/back/gettweetsdayfake.php'); //neutrall all time
$fake_tweets_per_alltime=  file_get_contents('http://10.0.201.200/back/gettweetsalltimefake.php'); //neutrall all time

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
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
   Dashboard
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="../assets/css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper">
    <div class="sidebar">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
    -->
      <div class="sidebar-wrapper">
        <div class="logo">
          <a href="javascript:void(0)" class="simple-text logo-mini">
            SIXL
          </a>
          <a href="javascript:void(0)" class="simple-text logo-normal">
           Stop fake today
          </a>
        </div>
        <ul class="nav">
          <li class="active ">
            <a href="#">
              <i class="tim-icons icon-chart-pie-36"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="statistics.php">
              <i class="tim-icons icon-atom"></i>
              <p>Statistics</p>
            </a>
          </li>
          <li>
            <a href="alert.php">
              <i class="tim-icons icon-bell-55"></i>
              <p>Detect fake</p>
            </a>
          </li>
          <li>
            <a href="askme.php">
            <i class="tim-icons icon-compass-05"></i>
              <p>Ask me</p>
            </a>
          </li>
          
          <li>
            <a href="http://10.0.201.201:5601/goto/0343fbef42dd8a5ad9d6f1aa9d072122">
              <i class="tim-icons icon-pin"></i>
              <p>Kibana</p>
            </a>
          </li>
          <li>
            <a href="http://10.0.201.201:9000/">
              <i class="tim-icons icon-paper"></i>
              <p>Stanford CoreNLP</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle d-inline">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:void(0)">Dashboard</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto">
              <li class="search-bar input-group">
                <button class="btn btn-link" id="search-button" data-toggle="modal" data-target="#searchModal"><i class="tim-icons icon-zoom-split" ></i>
                  <span class="d-lg-none d-md-block">Search</span>
                </button>
              </li>
              <li class="dropdown nav-item">
                <a href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <div class="notification d-none d-lg-block d-xl-block"></div>
                  <i class="tim-icons icon-sound-wave"></i>
                  <p class="d-lg-none">
                    Notifications
                  </p>
                </a>
                <ul class="dropdown-menu dropdown-menu-right dropdown-navbar">
                  <li class="nav-link"><a href="#" class="nav-item dropdown-item">Mike John responded to your email</a></li>
                  <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">You have 5 more tasks</a></li>
                  <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Your friend Michael is in town</a></li>
                  <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Another notification</a></li>
                  <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Another one</a></li>
                </ul>
              </li>
              <li class="dropdown nav-item">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <div class="photo">
                    <img src="../assets/img/anime3.png" alt="Profile Photo">
                  </div>
                  <b class="caret d-none d-lg-block d-xl-block"></b>
                  <p class="d-lg-none">
                    Log out
                  </p>
                </a>
                <ul class="dropdown-menu dropdown-navbar">
                  <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Profile</a></li>
                  <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Settings</a></li>
                  <li class="dropdown-divider"></li>
                  <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Log out</a></li>
                </ul>
              </li>
              <li class="separator d-lg-none"></li>
            </ul>
          </div>
        </div>
      </nav>
      <div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="tim-icons icon-simple-remove"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Navbar -->
      <div class="content">
        <div class="col-md-12"> 
        <h2>Dashboard </h2>
				<div class="service-section-header">
					<div class="search-field">
						<i class="ph-magnifying-glass"></i>
						
						<form id="myForm" method="post" action="../../addtopic.php"> 
              <input id="myInput" name="title" type="text" class="form-control" placeholder="
Enter the request you want to add to monitoring">
					</div>
					
					<button style="    margin-top: 15px;" type="submit"  class="btn btn-fill btn-primary">
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
  xhr.open('POST', '../back/addtopic.php');
  
  // Встановлюємо заголовки запиту, якщо потрібно
  
  // Встановлюємо обробник події, що виконається при отриманні відповіді
  xhr.onload = function() {
    if (xhr.status === 200) {
      // Відображаємо повідомлення успіху
    }
    else {
      // Відображаємо повідомлення про помилку
      var errorMessage = document.createElement('p');
      errorMessage.textContent = 'Something wrong,repeat pls.';
      form.parentNode.insertBefore(errorMessage, form.nextSibling);
    }
    
    // Очищаємо значення інпутуs
    input.value = '';
  };
  
  // Відправляємо запит з даними форми
  xhr.send(new FormData(form));
});
						</script>
				</div> 
				<br><br>

				<div style="padding: 15px;
    border: 1px solid white;
    color: white;
    text-align: center;
    background-color: #1762ae;
    "><p id="topics"></p>
		</ul></div>
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
  xhr.open('GET', '../back/gettopic.php', true);
  xhr.send();
}

// Викликаємо функцію для оновлення списку топіків кожну секунду
setInterval(updateTopicsList, 1000);
	</script>
<br><br>
<div>
		
	</div>
        </div>
      <div class="row">

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-4 col-md-6 mb-4">
	<div style="width: 100%;height: 125px!important;" class="card border-left-primary shadow h-100 py-2">
		<div class="card-body">
			<div class="row no-gutters align-items-center">
				<div class="col mr-2">
        <h4 class="card-title">Tweets summary:</h4>
					<div class="h5 mb-0 font-weight-bold text-gray-800">
					<span id="count"><?php echo $tweets_alltime; ?></span></div>
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
        <h4 class="card-title">
					Tweets per day:</h4>
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
        <h4 class="card-title">
					Tweets with propaganda for all time: </h4>
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

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-6 col-md-6 mb-4">
	<div style="width: 100%;height: 125px!important;" class="card border-left-primary shadow h-100 py-2">
		<div class="card-body">
			<div class="row no-gutters align-items-center">
				<div class="col mr-2">
        <h4 class="card-title">Fake tweets summary:</h4>
					<div class="h5 mb-0 font-weight-bold text-gray-800">
					<span id="count"><?php echo $fake_tweets_per_alltime; ?></span></div>
				</div>
				<div class="col-auto">
					<i style="font-size:3.333333em;" class="fa fa-comment fa-lg"></i>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-6 col-md-6 mb-4">
	<div style="width: 100%;height: 125px!important;" class="card border-left-success shadow h-100 py-2">
		<div class="card-body">
			<div class="row no-gutters align-items-center">
				<div class="col mr-2">
        <h4 class="card-title">
					Fake weets per day:</h4>
					<div class="h5 mb-0 font-weight-bold text-gray-800">
					<span id="count_day"><?php echo $fake_tweets_per_day;?></span>
	
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
        <h4 class="card-title">
						Tweets with neutral sentimant:</h4>
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
        <h4 class="card-title">
						Tweets with positive sentimant:</h4>
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
        <h4 class="card-title">
						Tweets with negativ sentimant:</h4>
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
        
      </div>
      <footer class="footer">
        
      </footer>
    </div>
  </div>
  
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <!-- Place this tag in your head or just before your close body tag. -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/black-dashboard.min.js?v=1.0.0"></script><!-- Black Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');
        $navbar = $('.navbar');
        $main_panel = $('.main-panel');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');
        sidebar_mini_active = true;
        white_color = false;

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();



        $('.fixed-plugin a').click(function(event) {
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .background-color span').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data', new_color);
          }

          if ($main_panel.length != 0) {
            $main_panel.attr('data', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data', new_color);
          }
        });

        $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            sidebar_mini_active = false;
            blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
          } else {
            $('body').addClass('sidebar-mini');
            sidebar_mini_active = true;
            blackDashboard.showSidebarMessage('Sidebar mini activated...');
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);
        });

        $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (white_color == true) {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').removeClass('white-content');
            }, 900);
            white_color = false;
          } else {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').addClass('white-content');
            }, 900);

            white_color = true;
          }


        });

        $('.light-badge').click(function() {
          $('body').addClass('white-content');
        });

        $('.dark-badge').click(function() {
          $('body').removeClass('white-content');
        });
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      demo.initDashboardPageCharts();

    });
  </script>
  
</body>

</html>
