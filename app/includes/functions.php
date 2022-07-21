<?php
include 'connection.php'; // start MySQL connection

$role = $_SESSION['role']; // user role
$ip = fetchip(); // ip address
function vpn_check($ipaddr)
{
	global $proxycheckapikey;
    	$url = "https://proxycheck.io/v2/{$ipaddr}?key={$proxycheckapikey}?vpn=1";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	$json = json_decode($result);
	if($json->$ipaddr->proxy == "yes")
	{
		return true;
	}

    return false;
}

function selectedapp($username)
{
    global $link;

    ($result = mysqli_query($link, "SELECT * FROM `accounts` WHERE `username` = '$username'")) or die(mysqli_error($link));
	$row = mysqli_fetch_array($result);

    $appname = $row["selectedapp"];
    $_SESSION['selectedapp'] = $appname;

    ($result = mysqli_query($link, "SELECT * FROM `apps` WHERE `owner` = '$username' AND `name` = '$appname'")) or die(mysqli_error($link));
	$row = mysqli_fetch_array($result);

    $_SESSION["app"] = $row["secret"];

}

function expire_check($username, $expires)
{
	global $link;
	
	if($expires < time())
	{
		$_SESSION['role'] = "tester";
		mysqli_query($link,"UPDATE `accounts` SET `role` = 'tester' WHERE `username` = '$username'");
	}

	if($expires - time() < 2629743) // account expires in month
	{
		return true;
	}
	else
	{
		return false;
	}
}

function wh_log($webhook_url, $msg, $un)
{
    $timestamp = date("c", strtotime("now"));

    $json_data = json_encode([
    // Message
    "content" => $msg,

    // Username
    "username" => "$un",

    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    $ch = curl_init($webhook_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-type: application/json'
    ));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    curl_exec($ch);
    curl_close($ch);
}

function xss_clean($data)
{
// Fix &entity\n;
$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

// Remove any attribute starting with "on" or xmlns
$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

// Remove javascript: and vbscript: protocols
$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

// Remove namespaced elements (we do not need them)
$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

do
{
    // Remove really unwanted tags
    $old_data = $data;
    $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
}
while ($old_data !== $data);

// we are done...
return $data;
}

function sanitize($input)
{
    if (empty($input) & !is_numeric($input))
    {
        return NULL;
    }
    global $link; // needed to refrence active MySQL connection
    return mysqli_real_escape_string($link, strip_tags(trim($input))); // return string with quotes escaped to prevent SQL injection, script tags stripped to prevent XSS attach, and trimmed to remove whitespace
    
}
function getIp()
{
    return $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
}
function fetchip()
{
    return str_replace(",62.210.119.214", "",$_SERVER['HTTP_X_FORWARDED_FOR']) ?? $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
}

function error($msg)
{
    echo '<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css"><script type=\'text/javascript\'>
                
                            const notyf = new Notyf();
                            notyf
                              .error({
                                message: \'' . $msg . '\',
                                duration: 3500,
                                dismissible: true
                              });               
                
                </script>';
}

function success($msg)
{
    echo '<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css"><script type=\'text/javascript\'>
                
                            const notyf = new Notyf();
                            notyf
                              .success({
                                message: \'' . $msg . '\',
                                duration: 3500,
                                dismissible: true
                              });               
                
                </script>';
}

function random_string_upper($length = 10, $keyspace = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'):
    string
    {
        $out = '';

        for ($i = 0;$i < $length;$i++)
        {
            $rand_index = random_int(0, strlen($keyspace) - 1);

            $out .= $keyspace[$rand_index];
        }

        return $out;
    }

    function random_string_lower($length = 10, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyz'):
        string
        {
            $out = '';

            for ($i = 0;$i < $length;$i++)
            {
                $rand_index = random_int(0, strlen($keyspace) - 1);

                $out .= $keyspace[$rand_index];
            }

            return $out;
        }

        function formatBytes($bytes, $precision = 2)
        {
            $units = array(
                'B',
                'KB',
                'MB',
                'GB',
                'TB'
            );

            $bytes = max($bytes, 0);
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
            $pow = min($pow, count($units) - 1);

            // Uncomment one of the following alternatives
            // $bytes /= pow(1024, $pow);
            $bytes /= (1 << (10 * $pow));

            return round($bytes, $precision) . ' ' . $units[$pow];
        }

        function generateRandomString($length = 10)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0;$i < $length;$i++)
            {
                $randomString .= $characters[rand(0, $charactersLength - 1) ];
            }
            return $randomString;
        }

        function generateRandomNum($length = 6)
        {
            $characters = '0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0;$i < $length;$i++)
            {
                $randomString .= $characters[rand(0, $charactersLength - 1) ];
            }
            return $randomString;
        }

                function getsession($sessionid, $secret)
                {
                    global $link; // needed to refrence active MySQL connection
                    mysqli_query($link, "DELETE FROM `sessions` WHERE `expiry` < " . time() . "") or die(mysqli_error($link));
                    // clean out expired sessions
                    $result = mysqli_query($link, "SELECT * FROM `sessions` WHERE `id` = '$sessionid' AND `app` = '$secret'");
                    $num = mysqli_num_rows($result);
                    if ($num === 0)
                    {
                        die("no active session");
                    }
                    $row = mysqli_fetch_array($result);
                    return array(
                        "credential" => $row["credential"],
                        "enckey" => $row["enckey"],
                        "validated" => $row["validated"]
                    );
                }
?>

<style>
			/* width */
			::-webkit-scrollbar {
			width: 10px;
			}

			/* Track */
			::-webkit-scrollbar-track {
			box-shadow: inset 0 0 5px grey; 
			border-radius: 10px;
			}
			
			/* Handle */
			::-webkit-scrollbar-thumb {
			background: #2549e8; 
			border-radius: 10px;
			}

			/* Handle on hover */
			::-webkit-scrollbar-thumb:hover {
			background: #0a2bbf; 
			}
			</style>