<?php
$host = "223.3.94.164"; //host
$port = '12401'; //port
$null = NULL; //null var

//Create TCP/IP sream socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//reuseable port
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);

//bind socket to specified host
socket_bind($socket, 0, $port);

//listen to port
socket_listen($socket);

//create & add listning socket to the list
$clients = array($socket); 
var_dump($clients);
echo "out while";
//start endless loop, so that our script doesn't stop

$classSocket = array();

while (true) {
	//manage multipal connections
	$changed = $clients;
	//returns the socket resources in $changed array
	//第四个参数为等待时延，为0是轮询模式
	socket_select($changed, $null, $null, 0, 10);
	
	//check for new socket
	if (in_array($socket, $changed)) {
		$socket_new = socket_accept($socket); //accpet new socket
		$clients[] = $socket_new; //add socket to client array
		
		var_dump($clients);
		
		$header = socket_read($socket_new, 1024); //read data sent by the socket
		perform_handshaking($header, $socket_new, $host, $port); //perform websocket handshake
		
		socket_getpeername($socket_new, $ip); //get ip address of connected socket
		//$response = mask(json_encode(array('type'=>'system', 'message'=>$ip.' connected'))); //prepare json data
		//send_message($response); //notify all users about new connection
		
		//make room for new socket
		$found_socket = array_search($socket, $changed);
		unset($changed[$found_socket]);
	}
	
	//loop through all connected sockets
	foreach ($changed as $changed_socket) {	
		//var_dump($changed_socket);
		//check for any incomming data
		while(socket_recv($changed_socket, $buf, 1024, 0) >= 1)
		{
			/*var msg = {
					message: "I'M COMMING!!",
					name: "LANXIANG",
					color : '007AFF',
					userType: 'teacher',
					msgType: 'connect',
					classId:'1';
				};	
			*/			
			$received_text = unmask($buf); //unmask data
			$tst_msg = json_decode($received_text); //json decode 
			$user_name = $tst_msg->name; //sender name
			$user_message = $tst_msg->message; //message text
			$user_type = $tst_msg->userType;
			$msg_type = $tst_msg->msgType;
			$classId = $tst_msg->classId;			
			if($msg_type=='connect'){
				$classSocket[$classId][]=$changed_socket;					
			}
			else{
			//prepare data to be sent to client
			$response_text = mask(json_encode(array('msgType'=>$msg_type, 'name'=>$user_name, 'message'=>$user_message, 'userType'=>$user_type)));
			send_message($response_text,$classId); //send data
			}
			break 2;
		}
		
		$buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
		
		if ($buf === false) { // check disconnected client
			// remove client for $clients array
			$found_socket = array_search($changed_socket, $clients);
			$foundSocket = array_search($changed_socket, $classSocket[$classId]);
			echo "lanxiang\n";
			echo "\n$foundSocket\n";
			echo "xianglan\n";
			socket_getpeername($changed_socket, $ip);
			unset($clients[$found_socket]);		
			unset($classSocket[$classId][$foundSocket]);	
			echo "One guy has disconnected!";
			var_dump($classSocket);			
			//notify all users about disconnected connection
			//$response = mask(json_encode(array('type'=>'system', 'message'=>$ip.' disconnected')));
			//send_message($response,$classId);
		}
	}
}
// close the listening socket
socket_close($sock);

function send_message($msg,$classId)
{
	global $classSocket;
	echo "Let's send message!!";
	var_dump($classSocket);
	
	foreach($classSocket[$classId] as $classMember)
	{
		@socket_write($classMember,$msg,strlen($msg));
	}
	return true;
}


//Unmask incoming framed message
function unmask($text) {
	$length = ord($text[1]) & 127;
	if($length == 126) {
		$masks = substr($text, 4, 4);
		$data = substr($text, 8);
	}
	elseif($length == 127) {
		$masks = substr($text, 10, 4);
		$data = substr($text, 14);
	}
	else {
		$masks = substr($text, 2, 4);
		$data = substr($text, 6);
	}
	$text = "";
	for ($i = 0; $i < strlen($data); ++$i) {
		$text .= $data[$i] ^ $masks[$i%4];
	}
	return $text;
}

//Encode message for transfer to client.
function mask($text)
{
	$b1 = 0x80 | (0x1 & 0x0f);
	$length = strlen($text);
	
	if($length <= 125)
		$header = pack('CC', $b1, $length);
	elseif($length > 125 && $length < 65536)
		$header = pack('CCn', $b1, 126, $length);
	elseif($length >= 65536)
		$header = pack('CCNN', $b1, 127, $length);
	return $header.$text;
}

//handshake new client.
function perform_handshaking($receved_header,$client_conn, $host, $port)
{
	$headers = array();
	$lines = preg_split("/\r\n/", $receved_header);
	foreach($lines as $line)
	{
		$line = chop($line);
		if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
		{
			$headers[$matches[1]] = $matches[2];
		}
	}

	$secKey = $headers['Sec-WebSocket-Key'];
	$secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
	//hand shaking header
	$upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
	"Upgrade: websocket\r\n" .
	"Connection: Upgrade\r\n" .
	"WebSocket-Origin: $host\r\n" .
	"WebSocket-Location: ws://$host:$port/demo/shout.php\r\n".
	"Sec-WebSocket-Accept:$secAccept\r\n\r\n";
	socket_write($client_conn,$upgrade,strlen($upgrade));
}
