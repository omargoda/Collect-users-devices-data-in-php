<?php
	if (isset($_COOKIE['screens'])) {
		echo 'OK';
	} else {
		class DB {
		  private static function connect () {
			$pdo = new PDO('mysql:host=host-name;dbname=db-name;charset=utf8', 'username', 'password');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		  }
		  public static function query ($query, $params = array()) {
			$statement = self::connect()->prepare($query);
			$statement->execute($params);
			if (explode(' ', $query)[0] == 'SELECT') {
			$data = $statement->fetchAll();
			return $data;
			}
		  }
		}
		function getRealIpAddr() {
			if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
			{
			  $ip=$_SERVER['HTTP_CLIENT_IP'];
			}
			elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
			{
			  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			else
			{
			  $ip=$_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}
		$user_agent = $_SERVER['HTTP_USER_AGENT'];

		function getOS() { 

			global $user_agent;

			$os_platform  = "Unknown OS Platform";

			$os_array     = array(
								  '/windows nt 10/i'      =>  'Windows 10',
								  '/windows nt 6.3/i'     =>  'Windows 8.1',
								  '/windows nt 6.2/i'     =>  'Windows 8',
								  '/windows nt 6.1/i'     =>  'Windows 7',
								  '/windows nt 6.0/i'     =>  'Windows Vista',
								  '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
								  '/windows nt 5.1/i'     =>  'Windows XP',
								  '/windows xp/i'         =>  'Windows XP',
								  '/windows nt 5.0/i'     =>  'Windows 2000',
								  '/windows me/i'         =>  'Windows ME',
								  '/win98/i'              =>  'Windows 98',
								  '/win95/i'              =>  'Windows 95',
								  '/win16/i'              =>  'Windows 3.11',
								  '/macintosh|mac os x/i' =>  'Mac OS X',
								  '/mac_powerpc/i'        =>  'Mac OS 9',
								  '/linux/i'              =>  'Linux',
								  '/ubuntu/i'             =>  'Ubuntu',
								  '/iphone/i'             =>  'iPhone',
								  '/ipod/i'               =>  'iPod',
								  '/ipad/i'               =>  'iPad',
								  '/android/i'            =>  'Android',
								  '/blackberry/i'         =>  'BlackBerry',
								  '/webos/i'              =>  'Mobile'
							);

			foreach ($os_array as $regex => $value)
				if (preg_match($regex, $user_agent))
					$os_platform = $value;

			return $os_platform;
		}

		function getBrowser() {

			global $user_agent;

			$browser        = "Unknown Browser";

			$browser_array = array(
									'/msie/i'      => 'Internet Explorer',
									'/firefox/i'   => 'Firefox',
									'/chrome/i'    => 'Chrome',
									'/safari/i'    => 'Safari',
									'/edge/i'      => 'Edge',
									'/opera/i'     => 'Opera',
									'/netscape/i'  => 'Netscape',
									'/maxthon/i'   => 'Maxthon',
									'/konqueror/i' => 'Konqueror',
									'/iphone/i'    => 'Safari',
									'/gecko/i'     => 'Tor',
									'/mobile/i'    => 'Handheld Browser'
							 );

			foreach ($browser_array as $regex => $value)
				if (preg_match($regex, $user_agent)) {
					$browser = $value;
					break;
				}
			return $browser;
		}
		$user_os        = getOS();
		$user_browser   = getBrowser();
		$height = $_POST['height'];
		$width = $_POST['width'];
		$ip = getRealIpAddr();
		if (empty($height) || empty($width)) {
			echo 'NO';
		} else {
			DB::query('INSERT INTO screens VALUES(:ip, :os, :browser, :height, :width, :string)', array(':ip'=>$ip, ':os'=>$user_os, ':browser'=>$user_browser, ':height'=>$height, ':width'=>$width, ':string'=>$user_agent));
			setcookie("screens", $width, time() + 60 * 60 * 24 * 14, '/', "domain-name", False, True);
			echo 'OK';
		}
	}
?>
