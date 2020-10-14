<div class="jumbotron">
	<div class="container">
		<h1 class="display-3">Licensing Software Platform</h1>
		<p class="lead">Welcome to LSP the open source licensing and update service.</p>
		<button type="button" class="btn btn-lg btn-primary" onclick="loadApps()">View apps<i class="fas fa-chevron-right ml-2"></i></button>
		<a class="btn btn-lg btn-secondary" href="https://github.com/LouisOuellet/lsp" role="button"><i class="fab fa-github mr-2"></i>GitHub<i class="fas fa-chevron-right ml-2"></i></a>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<h1 class="display-3 text-center"><i class="far fa-question-circle"></i></h1>
			<h2 class="text-center border-bottom border-secondary mb-3 pb-2">Get Started</h2>
			<p class="text-justify">
				To get started, you need to create your first application and generate some key(s).
				Additionnaly for PHP applications you can use the included LSP class in your application
				as described on <i class="fab fa-github mr-1"></i>GitHub.
			</p>
		</div>
		<div class="col-md-4">
			<h1 class="display-3 text-center"><i class="fas fa-key"></i></h1>
			<h2 class="text-center border-bottom border-secondary mb-3 pb-2">License Services</h2>
			<p class="text-justify">
				LSP makes use of cURL to provide a licensing access to your application. It can also
				generate a list of keys for a given app. By default, all license are disabled during
				creation. They will need to be Enabled for an application to authenticate it's license
				and activate it. Licenses are limited to 1 per instance of the application.
			</p>
		</div>
		<div class="col-md-4">
			<h1 class="display-3 text-center"><i class="fas fa-code-branch"></i></h1>
			<h2 class="text-center border-bottom border-secondary mb-3 pb-2">Update Services</h2>
			<p class="text-justify">
				LSP support a git server. This allows you to host your own git repositories and the
				ability to provide reliable updates. The included LSP classes also offers a method
				to upgrade your SQL database structure during the update process of your application.
				This allows you to focus on your application while LSP will takes care of the rest.
			</p>
		</div>
	</div>
</div>
