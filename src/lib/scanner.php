<?php

class Scanner {

	protected $Ports = [0,21,22,25,53,80,110,143,443,465,587,993,995,1194,8080];
	protected $UDP = [9,42,67,68,69,82,123,138,161,319,320,370,500,512,513,514,517,518,520,521,525,533,560,561,623,698,750,752,753,1194,1234,1900,1985,3785,3799,5445,9000,20000];
	protected $Timeout = 2;

	public function __construct(){
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', -1);
	}

	public function setPorts($ports = []){
		$this->Ports = $ports;
	}

	public function setUDP($ports = []){
		$this->UDP = $ports;
	}

	public function setTimeout($timeout = 2){
		$this->Timeout = $timeout;
	}

	public function scanHost($host, $format = 'array'){
		if (filter_var($host, FILTER_VALIDATE_IP)) {
      $ip=$host;
    } else {
      $dns=dns_get_record($host, DNS_A);
      $ip=$dns[0]['ip'];
    }
		foreach ($this->Ports as $port){
			if($port != 0){
				if(is_bool($service)){ $service = 'unknown'; }
				$tB = microtime(true);
				if(in_array($port,$this->UDP)){
					$socket = @fsockopen('udp://'.$ip, $port, $errno, $errstr, $this->Timeout);
					$protocol = 'udp';
				} else {
					$socket = @fsockopen($ip, $port, $errno, $errstr, $this->Timeout);
					$protocol = 'tcp';
				}
				$service = getservbyport($port, $protocol);
				$status = 'closed';
				if (is_resource($socket)){
					$status = 'open';
					fclose($socket);
		    }
				$latency = round(((microtime(true) - $tB) * 1000), 0)."ms";
			} else {
				$protocol = 'tcp';
				$service = 'icmp';
				$status = 'down';
				$errno = '';
				$errstr = '';
				$latency = 'ms';
				if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
					exec("ping -n 1 ".$ip." | for /f \"tokens=5\" %a in ('findstr TTL=') do @echo %a", $out);
					if(isset($out[0])){
						$latency = str_replace(['time=','time<','time>'],'',$out[0]);
						$status = 'up';
					}
				} else {
					exec("ping -c 1 " . $ip . " | head -n 2 | tail -n 1 | awk '{print $7}'", $out);
					if(strpos($out[0], 'time') !== false){
						$latency = str_replace(['time=','time<','time>'],'',$out[0]).'ms';
						$status = 'up';
					}
				}
			}
			$results[$host][$port] = [
				'protocol' => $protocol,
				'service' => $service,
				'status' => $status,
				'errno' => $errno,
				'errstr' => $errstr,
				'latency' => $latency,
			];
		}
		if($format != 'json'){
			return $results;
		} else {
			return json_encode($results, JSON_PRETTY_PRINT);
		}
	}
}
