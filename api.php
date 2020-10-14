<?php
session_start();

// Include Library
require dirname(__FILE__,1).'/src/lib/api.php';

// Start API
$API = new API();

if((!empty($_POST))&&(isset($_POST))){
	if(!$API->Status){
		if(isset($_POST['method'])){
			switch($_POST['method']){
				case "auth":
					if(isset($_POST['username'],$_POST['password'])){
						$API->login($_POST['username'],$_POST['password']);
					} else {
						echo "No Login Data Received";
					}
					break;
			}
		}
	}
	if($API->Status){
		if(isset($_POST['request'],$_POST['license'],$_POST['app'],$_POST['fingerprint'],$_POST['ip'])){
			switch($_POST['request']){
				case "validate":
					if(isset($_POST['license'],$_POST['app'],$_POST['fingerprint'],$_POST['ip'])){
						$API->validate($_POST['license'],$_POST['app'],$_POST['fingerprint'],$_POST['ip']);
					}
					break;
				case "activate":
					if(isset($_POST['license'],$_POST['app'],$_POST['fingerprint'],$_POST['ip'])){
						$API->activate($_POST['license'],$_POST['app'],$_POST['fingerprint'],$_POST['ip']);
					}
					break;
			}
		}
		if($API->Login){
			if(isset($_POST['request'])){
				switch($_POST['request']){
					case "getApp":
						if(isset($_POST['application'])){
							$API->getApp($_POST['application']);
						}
						break;
					case "genApp":
						if(isset($_POST['application'])){
							$API->genApp($_POST['application']);
						}
						break;
					case "delApp":
						if(isset($_POST['application'])){
							$API->delApp($_POST['application']);
						}
						break;
					case "genKeys":
						if(isset($_POST['application'],$_POST['amount'])){
							$API->genKeys($_POST['application'],$_POST['amount']);
						}
						break;
					case "delKeys":
						if(isset($_POST['application'],$_POST['key'])){
							$API->delKeys($_POST['application'],$_POST['key']);
						}
						break;
					case "enableKeys":
						if(isset($_POST['application'],$_POST['key'])){
							$API->enableKeys($_POST['application'],$_POST['key']);
						}
						break;
					case "disableKeys":
						if(isset($_POST['application'],$_POST['key'])){
							$API->disableKeys($_POST['application'],$_POST['key']);
						}
						break;
					case "activateKeys":
						if(isset($_POST['application'],$_POST['key'])){
							$API->activateKeys($_POST['application'],$_POST['key']);
						}
						break;
					case "deactivateKeys":
						if(isset($_POST['application'],$_POST['key'])){
							$API->deactivateKeys($_POST['application'],$_POST['key']);
						}
						break;
					case "setOwnerKeys":
						if(isset($_POST['application'],$_POST['key'],$_POST['owner'])){
							$API->setOwnerKeys($_POST['application'],$_POST['key'],$_POST['owner']);
						}
						break;
					case "clearOwnerKeys":
						if(isset($_POST['application'],$_POST['key'])){
							$API->clearOwnerKeys($_POST['application'],$_POST['key']);
						}
					case "getUser":
						if(isset($_POST['username'])){
							$API->getUser($_POST['username']);
						}
					case "genUser":
						if(isset($_POST['username'],$_POST['password'],$_POST['password2'])){
							$API->genUser($_POST['username'],$_POST['password'],$_POST['password2']);
						}
						break;
					case "saveUser":
						if(isset($_POST['username'],$_POST['password'],$_POST['password2'])){
							$API->saveUser($_POST['username'],$_POST['password'],$_POST['password2']);
						}
						break;
					case "delUser":
						if(isset($_POST['username'])){
							$API->delUser($_POST['username']);
						}
						break;
				}
			}
		}
	}
}
