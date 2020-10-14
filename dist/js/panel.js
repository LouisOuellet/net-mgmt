$.extend( true, $.fn.dataTable.defaults, {
	"searching": true,
	"paging": true,
	"pageLength": 10,
	"lengthChange": true,
	"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
	"info": true,
	"autoWidth": true,
	"processing": true,
	"scrolling": false,
	"buttons": [
		'copy', 'csv', 'pdf', 'print'
	],
} );

// $('#mainCTN').load("/src/view/home.php");
document.getElementById('navBtnApps').addEventListener('click', loadApps);
document.getElementById('navBtnUsers').addEventListener('click', loadUsers);

function loadApps(){
	$('#mainCTN').load("/src/view/apps.php",function(){
		$('#tblApps').DataTable();
	});
};

function loadApp(appname){
	$('#mainCTN').load("/src/view/app.php", {name: appname},function(){
		$('#tblKeys').DataTable();
		// $.post("api.php", {
		// 		method: "session",
		// 		request: "getApp",
		// 		application: appname,
		// 	}, function(data,status){
		// 		var dataset = JSON.parse(data);
		// 		var server = window.location.hostname;
		// 		var protocol = window.location.protocol;
		// 		var localdir = document.getElementById('AppCtnSSHGit').value;
		// 		document.getElementById('AppCtnToken').innerHTML = dataset['token'];
		// 		document.getElementById('AppCtnHTTPGit').value = protocol + '//' + server + '/git/' + appname + '.git';
		// 		document.getElementById('AppCtnSSHGit').value = 'git@' + server + ':' + localdir + '/git/' + appname + '.git';
		// 	}
		// );
	});
};

function genApp(){
	$.post("api.php", {
			method: "session",
			request: "genApp",
			application: document.getElementById('GenAppName').value,
		}
	);
	$('#mainCTN').load("/src/view/apps.php",function(){
		$('#tblApps').DataTable();
		$(".modal-backdrop").fadeOut();
		$('.modal-backdrop').remove();
	});
};

function delApp(appname){
	var timeout = 10 * 100;
	$.post("api.php", {
			method: "session",
			request: "delApp",
			application: appname,
		}
	);
	setTimeout(function(){
		$('#mainCTN').load("/src/view/apps.php",function(){
			$('#tblApps').DataTable();
		});
	}, timeout);
};

function genKeys(appname){
	var keyamount = document.getElementById('AmtKey').value;
	var timeout = keyamount * 100;
	$.post("api.php", {
			method: "session",
			request: "genKeys",
			application: appname,
			amount: keyamount,
		}
	);
	setTimeout(function(){
		$('#mainCTN').load("/src/view/app.php", {name: appname},function(){
			$('#tblKeys').DataTable();
			$(".modal-backdrop").fadeOut();
			$('.modal-backdrop').remove();
			$('.nav-pills a[href="#keys"]').tab('show');
		});
	}, timeout);
};

function delKeys(appname, appkey){
	$.post("api.php", {
			method: "session",
			request: "delKeys",
			application: appname,
			key: appkey,
		}
	);
	$('#mainCTN').load("/src/view/app.php", {name: appname},function(){
		$('#tblKeys').DataTable();
		$('.nav-pills a[href="#keys"]').tab('show');
	});
};

function enableKeys(appname, appkey){
	$.post("api.php", {
			method: "session",
			request: "enableKeys",
			application: appname,
			key: appkey,
		}
	);
	$('#mainCTN').load("/src/view/app.php", {name: appname},function(){
		$('#tblKeys').DataTable();
		$('.nav-pills a[href="#keys"]').tab('show');
	});
};

function disableKeys(appname, appkey){
	$.post("api.php", {
			method: "session",
			request: "disableKeys",
			application: appname,
			key: appkey,
		}
	);
	$('#mainCTN').load("/src/view/app.php", {name: appname},function(){
		$('#tblKeys').DataTable();
		$('.nav-pills a[href="#keys"]').tab('show');
	});
};

function activateKeys(appname, appkey){
	$.post("api.php", {
			method: "session",
			request: "activateKeys",
			application: appname,
			key: appkey,
		}
	);
	$('#mainCTN').load("/src/view/app.php", {name: appname},function(){
		$('#tblKeys').DataTable();
		$('.nav-pills a[href="#keys"]').tab('show');
	});
};

function deactivateKeys(appname, appkey){
	$.post("api.php", {
			method: "session",
			request: "deactivateKeys",
			application: appname,
			key: appkey,
		}
	);
	$('#mainCTN').load("/src/view/app.php", {name: appname},function(){
		$('#tblKeys').DataTable();
		$('.nav-pills a[href="#keys"]').tab('show');
	});
};

function setOwnerKeys(appname, appkey){
	$.post("api.php", {
			method: "session",
			request: "setOwnerKeys",
			application: appname,
			key: appkey,
			owner: document.getElementById('owner-' + appkey).value,
		}
	);
	$('#mainCTN').load("/src/view/app.php", {name: appname},function(){
		$('#tblKeys').DataTable();
		$('.nav-pills a[href="#keys"]').tab('show');
	});
};

function clearOwnerKeys(appname, appkey){
	$.post("api.php", {
			method: "session",
			request: "clearOwnerKeys",
			application: appname,
			key: appkey,
		}
	);
	$('#mainCTN').load("/src/view/app.php", {name: appname},function(){
		$('#tblKeys').DataTable();
		$('.nav-pills a[href="#keys"]').tab('show');
	});
};

function loadUsers(){
	$('#mainCTN').load("/src/view/users.php",function(){
		$('#tblUsers').DataTable();
	});
};

function loadUser(username){
	$('#mainCTN').load("/src/view/user.php", {name: username});
};

function genUser(){
	var timeout = 1 * 100;
	$.post("api.php", {
			method: "session",
			request: "genUser",
			username: document.getElementById('userName').value,
			password: document.getElementById('userPass').value,
			password2: document.getElementByIdvar ctx = document.getElementById("myChart");
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
      });('userPass2').value,
		}
	);
	setTimeout(function(){
		$('#mainCTN').load("/src/view/users.php",function(){
			$('#tblUsers').DataTable();
			$(".modal-backdrop").fadeOut();
			$('.modal-backdrop').remove();
		});
	}, timeout);
};

function saveUser(username){
	$.post("api.php", {
			method: "session",
			request: "saveUser",
			username: username,
			password: document.getElementById('userPass').value,
			password2: document.getElementById('userPass2').value,
		}
	);
	$('#mainCTN').load("/src/view/user.php", {name: username});
};

function delUser(username){
	$.post("api.php", {
			method: "session",
			request: "delUser",
			username: username,
		}
	);
	$('#mainCTN').load("/src/view/users.php",function(){
		$('#tblUsers').DataTable();
	});
};
