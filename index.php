<?php
session_start();

require dirname(__FILE__,1).'/src/lib/api.php';

$API = new API();

if((!empty($_GET))&&(isset($_GET['logout']))){
	unset($_SESSION['mgmt']);
	$API->Login = FALSE;
}

if(!$API->Login){
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/login.php');
} else { ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="<?=$API->Config['description']?>">
		<meta name="author" content="Louis Ouellet, https://github.com/LouisOuellet">
		<title><?=$API->Config['title']?> | Dashboard</title>
		<link rel="shortcut icon" href="/dist/img/favicon.ico" />
    <!-- <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/dashboard/"> -->
    <!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<!-- DataTables CSS -->
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <!-- Custom styles for this template -->
		<link rel="stylesheet" type="text/css" href="./dist/css/panel.css">
		<!-- Bootstrap -->
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<!-- DataTable -->
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
		<!-- FontAwesome -->
		<script src="https://kit.fontawesome.com/4f8426d3cf.js" crossorigin="anonymous"></script>
  </head>

  <body>
    <nav class="navbar navbar-<?=$API->Config['customization']['mode']?> sticky-top bg-<?=$API->Config['customization']['color']?> flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0 p-2 bg-<?=$API->Config['customization']['color']?>" href="">
				<img class="mr-2" src="/dist/img/logo.png" alt="" width="32" height="32">
				<?=$API->Config['banner']?>
			</a>
			<form class="form-inline w-100">
      	<input class="form-control form-control-<?=$API->Config['customization']['mode']?> py-4 w-100" type="text" placeholder="Search" aria-label="Search">
			</form>
      <ul class="navbar-nav">
				<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle px-4" href="http://example.com" id="profile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=ucwords(str_replace('_',' ',str_replace('.',' ',$_SESSION['mgmt'])))?></a>
          <div class="dropdown-menu dropdown-menu-right position-absolute" aria-labelledby="profile">
            <a class="dropdown-item" href="?logout">Logout</a>
          </div>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block navbar navbar-<?=$API->Config['customization']['mode']?> bg-<?=$API->Config['customization']['mode']?> sidebar shadow">
          <div class="sidebar-sticky px-4">
            <ul class="navbar-nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="#">
									<i class="fas fa-tachometer-alt mr-2"></i>
                  Dashboard
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="fas fa-desktop mr-2"></i>
                  Devices
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="fas fa-network-wired mr-2"></i>
                  Network Interface Cards
                </a>
              </li>
							<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
	              <span>Administration</span>
	            </h6>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="fas fa-users mr-2"></i>
                  Users
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="fas fa-user-friends mr-2"></i>
                  Groups
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="fas fa-shield-alt mr-2"></i>
                  Roles
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-0 pt-3">
					<div class="px-4">
	          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
	            <h1 class="h2">Dashboard</h1>
	            <div class="btn-toolbar mb-2 mb-md-0">
	              <div class="btn-group mr-2">
	                <button class="btn btn-sm btn-outline-secondary">Share</button>
	                <button class="btn btn-sm btn-outline-secondary">Export</button>
	              </div>
	              <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
	                <span data-feather="calendar"></span>
	                This week
	              </button>
	            </div>
	          </div>

	          <canvas class="my-4" id="myChart" width="900" height="380"></canvas>

	          <h2>Section title</h2>
	          <div class="table-responsive">
	            <table class="table table-striped table-sm">
	              <thead>
	                <tr>
	                  <th>#</th>
	                  <th>Header</th>
	                  <th>Header</th>
	                  <th>Header</th>
	                  <th>Header</th>
	                </tr>
	              </thead>
	              <tbody>
	                <tr>
	                  <td>1,001</td>
	                  <td>Lorem</td>
	                  <td>ipsum</td>
	                  <td>dolor</td>
	                  <td>sit</td>
	                </tr>
	                <tr>
	                  <td>1,002</td>
	                  <td>amet</td>
	                  <td>consectetur</td>
	                  <td>adipiscing</td>
	                  <td>elit</td>
	                </tr>
	                <tr>
	                  <td>1,003</td>
	                  <td>Integer</td>
	                  <td>nec</td>
	                  <td>odio</td>
	                  <td>Praesent</td>
	                </tr>
	                <tr>
	                  <td>1,003</td>
	                  <td>libero</td>
	                  <td>Sed</td>
	                  <td>cursus</td>
	                  <td>ante</td>
	                </tr>
	                <tr>
	                  <td>1,004</td>
	                  <td>dapibus</td>
	                  <td>diam</td>
	                  <td>Sed</td>
	                  <td>nisi</td>
	                </tr>
	                <tr>
	                  <td>1,005</td>
	                  <td>Nulla</td>
	                  <td>quis</td>
	                  <td>sem</td>
	                  <td>at</td>
	                </tr>
	                <tr>
	                  <td>1,006</td>
	                  <td>nibh</td>
	                  <td>elementum</td>
	                  <td>imperdiet</td>
	                  <td>Duis</td>
	                </tr>
	                <tr>
	                  <td>1,007</td>
	                  <td>sagittis</td>
	                  <td>ipsum</td>
	                  <td>Praesent</td>
	                  <td>mauris</td>
	                </tr>
	                <tr>
	                  <td>1,008</td>
	                  <td>Fusce</td>
	                  <td>nec</td>
	                  <td>tellus</td>
	                  <td>sed</td>
	                </tr>
	                <tr>
	                  <td>1,009</td>
	                  <td>augue</td>
	                  <td>semper</td>
	                  <td>porta</td>
	                  <td>Mauris</td>
	                </tr>
	                <tr>
	                  <td>1,010</td>
	                  <td>massa</td>
	                  <td>Vestibulum</td>
	                  <td>lacinia</td>
	                  <td>arcu</td>
	                </tr>
	                <tr>
	                  <td>1,011</td>
	                  <td>eget</td>
	                  <td>nulla</td>
	                  <td>Class</td>
	                  <td>aptent</td>
	                </tr>
	                <tr>
	                  <td>1,012</td>
	                  <td>taciti</td>
	                  <td>sociosqu</td>
	                  <td>ad</td>
	                  <td>litora</td>
	                </tr>
	                <tr>
	                  <td>1,013</td>
	                  <td>torquent</td>
	                  <td>per</td>
	                  <td>conubia</td>
	                  <td>nostra</td>
	                </tr>
	                <tr>
	                  <td>1,014</td>
	                  <td>per</td>
	                  <td>inceptos</td>
	                  <td>himenaeos</td>
	                  <td>Curabitur</td>
	                </tr>
	                <tr>
	                  <td>1,015</td>
	                  <td>sodales</td>
	                  <td>ligula</td>
	                  <td>in</td>
	                  <td>libero</td>
	                </tr>
	              </tbody>
	            </table>
	          </div>
					</div>
					<footer class="footer mt-auto py-3 px-4" style="padding:10px;background-color:#ccc;">
						<div class="float-right d-none d-sm-block">
							<b>Version</b> <?=$API->Config['version']?>
						</div>
						<strong>Copyright &copy; 2020-<?= date('Y') ?> <a href="<?=$API->Config['copyright']['link']?>"><?=$API->Config['copyright']['text']?></a></strong> All rights reserved.
					</footer>
        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
		<!-- Popper -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>

    <!-- Graphs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script>
      var ctx = document.getElementById("myChart");
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
          datasets: [{
            data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
            lineTension: 0,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            borderWidth: 4,
            pointBackgroundColor: '#007bff'
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: false
              }
            }]
          },
          legend: {
            display: false,
          }
        }
      });
    </script>
  </body>
</html>
<?php } ?>
