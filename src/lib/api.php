<?php

require_once dirname(__FILE__,3).'/src/lib/Parsedown.php';
require_once dirname(__FILE__,3).'/src/lib/scanner.php';

class API{

	public $User;
	public $Config;
	public $Login = FALSE;
	public $Status = FALSE;

	public function __construct(){
		$this->init();
	}

	public function init(){
		$this->Config = json_decode(file_get_contents(dirname(__FILE__,3).'/config/app.json'),true);
		foreach(json_decode(file_get_contents(dirname(__FILE__,3).'/config/config.json'),true) as $key => $config){
			$this->Config[$key] = $config;
		}
		if(!is_dir(dirname(__FILE__,3).'/users')){
			mkdir(dirname(__FILE__,3).'/users');
		}
		if(!file_exists(dirname(__FILE__,3).'/users/.htaccess')){
			$htaccess=fopen(dirname(__FILE__,3).'/users/.htaccess', 'w');
			fwrite($htaccess, "Order deny,allow\n");
			fwrite($htaccess, "Deny from all\n");
			fclose($htaccess);
		}
		if(count(scandir(dirname(__FILE__,3).'/users'))-2 >= 2){
			$this->Status = TRUE;
		}
		if(isset($_SESSION['mgmt'])){
			$this->User = json_decode(file_get_contents(dirname(__FILE__,3).'/users/'.$_SESSION['mgmt'].'.json'),true);
			$this->Login = TRUE;
		}
	}

	public function login($userfile,$pass){
		if(file_exists(dirname(__FILE__,3).'/users/'.$userfile.'.json')){
			$user = json_decode(file_get_contents(dirname(__FILE__,3).'/users/'.$userfile.'.json'),true);
			if(password_verify($pass, $user['password'])){
				$_SESSION['mgmt'] = $userfile;
				$this->Login = TRUE;
			} else {
				echo "Invalid Login";
			}
		} else {
			echo "Unknown User";
		}
	}

	public function validate($license,$name,$fingerprint,$ip){
		if(file_exists(dirname(__FILE__,3).'/apps/'.$name.'/keys.json')){
			$keys=json_decode(file_get_contents(dirname(__FILE__,3).'/apps/'.$name.'/keys.json'),true);
			if((isset($keys[$license]))&&(password_verify($license, $keys[$license]['hash']))&&($keys[$license]['status'])){
				if(($keys[$license]['active'])&&($keys[$license]['ip']==$ip)){
					if((password_verify($fingerprint, $keys[$license]['fingerprint']))){
						$app=json_decode(file_get_contents(dirname(__FILE__,3).'/apps/'.$name.'/app.json'),true);
						echo json_encode($app['token'], JSON_PRETTY_PRINT);
						exit;
					}
				}
			}
		} else {
			echo "Unknown Application";
		}
	}

	public function activate($license,$name,$fingerprint,$ip){
		if(file_exists(dirname(__FILE__,3).'/apps/'.$name.'/keys.json')){
			$keys=json_decode(file_get_contents(dirname(__FILE__,3).'/apps/'.$name.'/keys.json'),true);
			if(!$keys[$license]['active']){
				$keys[$license]['active']=TRUE;
				$keys[$license]['ip']=$ip;
				$keys[$license]['fingerprint']=password_hash($fingerprint, PASSWORD_DEFAULT);
				unlink(dirname(__FILE__,3).'/apps/'.$name.'/keys.json');
				$json = fopen(dirname(__FILE__,3).'/apps/'.$name.'/keys.json', 'w');
				fwrite($json, json_encode($keys, JSON_PRETTY_PRINT));
				fclose($json);
				$app=json_decode(file_get_contents(dirname(__FILE__,3).'/apps/'.$name.'/app.json'),true);
				echo json_encode($app['token'], JSON_PRETTY_PRINT);
				exit;
			}
		} else {
			echo "Unknown Application";
		}
	}

	public function getApp($name){
		if(file_exists(dirname(__FILE__,3).'/apps/'.$name.'/app.json')){
			$app = json_decode(file_get_contents(dirname(__FILE__,3).'/apps/'.$name.'/app.json'),true);
			$app['token'] = password_hash($app['token'], PASSWORD_DEFAULT);
			echo json_encode($app, JSON_PRETTY_PRINT);
		}
	}

	public function genApp($name){
		if(!empty($name)){
			if(!is_dir(dirname(__FILE__,3).'/apps')){ mkdir(dirname(__FILE__,3).'/apps'); }
			if(!is_dir(dirname(__FILE__,3).'/git')){ mkdir(dirname(__FILE__,3).'/git'); }
			if(!is_dir(dirname(__FILE__,3).'/repos')){ mkdir(dirname(__FILE__,3).'/repos'); }
			if(!is_dir(dirname(__FILE__,3).'/apps/'.$name)){
				mkdir(dirname(__FILE__,3).'/apps/'.$name);
				mkdir(dirname(__FILE__,3).'/git/'.$name.'.git');
				shell_exec("git init --bare '".dirname(__FILE__,3).'/git/'.$name.'.git'."'");
				$file = fopen(dirname(__FILE__,3).'/git/'.$name.'.git/objects/info/packs', 'w');
				fwrite($file, json_encode("\n", JSON_PRETTY_PRINT));
				fclose($file);
				$file = fopen(dirname(__FILE__,3).'/git/'.$name.'.git/info/refs', 'w');
				fwrite($file, json_encode("", JSON_PRETTY_PRINT));
				fclose($file);
				$htaccess=fopen(dirname(__FILE__,3).'/git/'.$name.'.git/.htaccess', 'w');
				fwrite($htaccess, "Order deny,allow\n");
				fwrite($htaccess, "Allow from all\n");
				fclose($htaccess);
				$app['token']=md5($name.date("Y/m/d h:i:s"));
				$json = fopen(dirname(__FILE__,3).'/apps/'.$name.'/app.json', 'w');
				fwrite($json, json_encode($app, JSON_PRETTY_PRINT));
				fclose($json);
				shell_exec("cd ".dirname(__FILE__,3)."/repos && git clone ".(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://".$_SERVER['HTTP_HOST']."/git/".$name.".git");
			}
		}
	}

	public function delApp($name){
		if(is_dir(dirname(__FILE__,3).'/apps/'.$name)){
			shell_exec("rm -rf '".dirname(__FILE__,3).'/apps/'.$name."'");
			shell_exec("rm -rf '".dirname(__FILE__,3).'/git/'.$name.'.git'."'");
			shell_exec("rm -rf '".dirname(__FILE__,3).'/repos/'.$name."'");
		}
	}

	public function genKeys($name,$amount){
		if(is_dir(dirname(__FILE__,3).'/apps/'.$name)){
			if(file_exists(dirname(__FILE__,3).'/apps/'.$name.'/keys.json')){
				$keys=json_decode(file_get_contents(dirname(__FILE__,3).'/apps/'.$name.'/keys.json'),true);
			}
			for ($x = 1; $x <= $amount; $x++) {
				$key=implode("-", str_split(md5($name.$x.date("Y/m/d h:i:s")), 4));
				$keys[md5($key)]=[
					'key' => $key,
					'hash' => password_hash(md5($key), PASSWORD_DEFAULT),
					'status' => FALSE,
					'active' => FALSE,
				];
			}
			if(file_exists(dirname(__FILE__,3).'/apps/'.$name.'/keys.json')){
				unlink(dirname(__FILE__,3).'/apps/'.$name.'/keys.json');
			}
			$json = fopen(dirname(__FILE__,3).'/apps/'.$name.'/keys.json', 'w');
			fwrite($json, json_encode($keys, JSON_PRETTY_PRINT));
			fclose($json);
		}
	}

	public function delKeys($name,$key){
		if(file_exists(dirname(__FILE__,3).'/apps/'.$name.'/keys.json')){
			$keys=json_decode(file_get_contents(dirname(__FILE__,3).'/apps/'.$name.'/keys.json'),true);
			unset($keys[$key]);
			unlink(dirname(__FILE__,3).'/apps/'.$name.'/keys.json');
			$json = fopen(dirname(__FILE__,3).'/apps/'.$name.'/keys.json', 'w');
			fwrite($json, json_encode($keys, JSON_PRETTY_PRINT));
			fclose($json);
		}
	}

	public function enableKeys($name,$key){
		if(file_exists(dirname(__FILE__,3).'/apps/'.$name.'/keys.json')){
			$keys=json_decode(file_get_contents(dirname(__FILE__,3).'/apps/'.$name.'/keys.json'),true);
			$keys[$key]['status']=TRUE;
			unlink(dirname(__FILE__,3).'/apps/'.$name.'/keys.json');
			$json = fopen(dirname(__FILE__,3).'/apps/'.$name.'/keys.json', 'w');
			fwrite($json, json_encode($keys, JSON_PRETTY_PRINT));
			fclose($json);
		}
	}

	public function disableKeys($name,$key){
		if(file_exists(dirname(__FILE__,3).'/apps/'.$name.'/keys.json')){
			$keys=json_decode(file_get_contents(dirname(__FILE__,3).'/apps/'.$name.'/keys.json'),true);
			$keys[$key]['status']=FALSE;
			unlink(dirname(__FILE__,3).'/apps/'.$name.'/keys.json');
			$json = fopen(dirname(__FILE__,3).'/apps/'.$name.'/keys.json', 'w');
			fwrite($json, json_encode($keys, JSON_PRETTY_PRINT));
			fclose($json);
		}
	}

	public function activateKeys($name,$key){
		if(file_exists(dirname(__FILE__,3).'/apps/'.$name.'/keys.json')){
			$keys=json_decode(file_get_contents(dirname(__FILE__,3).'/apps/'.$name.'/keys.json'),true);
			$keys[$key]['active']=TRUE;
			unlink(dirname(__FILE__,3).'/apps/'.$name.'/keys.json');
			$json = fopen(dirname(__FILE__,3).'/apps/'.$name.'/keys.json', 'w');
			fwrite($json, json_encode($keys, JSON_PRETTY_PRINT));
			fclose($json);
		}
	}

	public function deactivateKeys($name,$key){
		if(file_exists(dirname(__FILE__,3).'/apps/'.$name.'/keys.json')){
			$keys=json_decode(file_get_contents(dirname(__FILE__,3).'/apps/'.$name.'/keys.json'),true);
			$keys[$key]['active']=FALSE;
			unlink(dirname(__FILE__,3).'/apps/'.$name.'/keys.json');
			$json = fopen(dirname(__FILE__,3).'/apps/'.$name.'/keys.json', 'w');
			fwrite($json, json_encode($keys, JSON_PRETTY_PRINT));
			fclose($json);
		}
	}

	public function setOwnerKeys($name,$key,$owner){
		if(file_exists(dirname(__FILE__,3).'/apps/'.$name.'/keys.json')){
			$keys=json_decode(file_get_contents(dirname(__FILE__,3).'/apps/'.$name.'/keys.json'),true);
			$keys[$key]['owner']=$owner;
			unlink(dirname(__FILE__,3).'/apps/'.$name.'/keys.json');
			$json = fopen(dirname(__FILE__,3).'/apps/'.$name.'/keys.json', 'w');
			fwrite($json, json_encode($keys, JSON_PRETTY_PRINT));
			fclose($json);
		}
	}

	public function clearOwnerKeys($name,$key){
		if(file_exists(dirname(__FILE__,3).'/apps/'.$name.'/keys.json')){
			$keys=json_decode(file_get_contents(dirname(__FILE__,3).'/apps/'.$name.'/keys.json'),true);
			unset($keys[$key]['owner']);
			unlink(dirname(__FILE__,3).'/apps/'.$name.'/keys.json');
			$json = fopen(dirname(__FILE__,3).'/apps/'.$name.'/keys.json', 'w');
			fwrite($json, json_encode($keys, JSON_PRETTY_PRINT));
			fclose($json);
		}
	}

	public function getUser($name){
		if(file_exists(dirname(__FILE__,3).'/users/'.$name.'.json')){
			$user = json_decode(file_get_contents(dirname(__FILE__,3).'/users/'.$name.'.json'),true);
			echo json_encode($user, JSON_PRETTY_PRINT);
		}
	}

	public function genUser($name,$pass,$pass2){
		if($pass == $pass2){
			if(file_exists(dirname(__FILE__,3).'/users/'.$name.'.json')){
				unlink(dirname(__FILE__,3) . '/users/'.$name.'.json');
			}
			$user['password']=password_hash($pass, PASSWORD_DEFAULT);
			$json = fopen(dirname(__FILE__,3).'/users/'.$name.'.json', 'w');
			fwrite($json, json_encode($user, JSON_PRETTY_PRINT));
			fclose($json);
		}
	}

	public function saveUser($name,$pass,$pass2){
		if($pass == $pass2){
			if(file_exists(dirname(__FILE__,3).'/users/'.$name.'.json')){
				$user = json_decode(file_get_contents(dirname(__FILE__,3).'/users/'.$name.'.json'),true);
				$user['password']=password_hash($pass, PASSWORD_DEFAULT);
				unlink(dirname(__FILE__,3) . '/users/'.$name.'.json');
				$json = fopen(dirname(__FILE__,3).'/users/'.$name.'.json', 'w');
				fwrite($json, json_encode($user, JSON_PRETTY_PRINT));
				fclose($json);
			}
		} else {
			return FALSE;
		}
	}

	public function delUser($name){
		if(file_exists(dirname(__FILE__,3).'/users/'.$name.'.json')){
			unlink(dirname(__FILE__,3).'/users/'.$name.'.json');
		}
	}
}
