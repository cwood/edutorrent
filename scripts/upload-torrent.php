<?php
session_start();
/*
Used to upload torrents into the database
*/
	if($_SESSION['main_group']==students){
		Die("You are not allowed on this page.");
	}//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^//
//									Globals										 //
include ("db.php");
$class_name = ($_POST['class_name']);
$torrent_description = ($_POST['torName']);
$torrent_type = ($_POST['type']);
$userID = $_SESSION['uid'];
//##############################################################################//
//							Start Main PHP Code									//

if (fileCh()==1 && TorTypeCh()==1 && TorCh()==1){
		$mainFID =  fidFunc();
				
		if(classAddTorrent_Main()==TRUE){
			InTorMainDb();
			$passkey=mkPasskey();
			classAddTorrent();
			
			
				$_SESSION['error_message']=sprintf('Your file has been added and it is registered to your class: Your passkey for the file is: %s', $passkey);
				header("Location : ../teach_panel.php");
		

		}
}
//*******************************************************************************//
//							Functions start										 //
//_______________________________________________________________________fileCh()
//Checks to make sure the file is a torrent, and compares it to the max file size.
function fileCh(){

	$fileName = $_FILES['torrent']['name'];
		
	define ('MAX_FILE_SIZE', 100000);
	
	if ($_FILES['torrent']['size'] >= MAX_FILE_SIZE)
		{
			$_SESSION['error_message']=sprintf('%s is to large of a file.', $fileName);
			header("Location: ../teach_panel.php");		}
		return 1;
}
//_______________________________________________________________________TorTypeCh()
//Checks to make sure that it is the correct MIME type uses extension fileinfo

function TorTypeCh(){
	
	$fileName = $_FILES['torrent']['name'];
	
	$path_info = pathinfo($fileName);	

	$ext = $path_info['extension'];
	
	if (!$ext == 'torrent'){
			$_SESSION['error_message']=sprintf('Bad file extension: %s', $fileName);
			header("Location: ../teach_panel.php");
	}
	else {
			return 1;
	}
}
//_______________________________________________________________________TorCh()
//Checks to make sure that it is the correct MIME type uses extension fileinfo
function TorCh(){
	//Globals
	global $dbLink;
	//Definitions
	$ANNOUNCE_URL = "http://edutorrent.colinbits.com:2710/announce";
	//Requires
	require_once 'File/Bittorrent2/Decode.php';

	//Decoding the torrent file
    $TorDecode = new File_Bittorrent2_Decode;	
	$info=$TorDecode->decodeFile($_FILES['torrent']['tmp_name']);
	$inHash = $TorDecode->getInfoHash();
	$inAnno = $TorDecode->getAnnounce();
	
	//checks hash of file with hash in the database
	$infoCh = $dbLink->query("SELECT info_hash FROM xbt_files WHERE info_hash=('$inHash')");
	
	$chTorHa=$dbLink->affected_rows;
		
	//More checks to make sure the correct url, the file is private, and to see if it has allready been uploaded.
			
	if($chTorHa==1){
			$_SESSION['error_message']=sprintf('This torrent has all ready been uploaded');
			header("Location: ../teach_panel.php");
			}
	//check to make sure the torrent uploaded is using the correct announce url
	if($inAnno!=$ANNOUNCE_URL){
		$_SESSION['error_message'] = sprintf('This torrent does not have the correct announce url. Please Use:%s', $ANNOUNCE_URL);
			header("Location: ../teach_panel.php");
		}
		
	if (!$TorDecode->isPrivate()){
			$_SESSION['error_message'] = 'This torrent is not private please make it private and try again.';
			header("Location: ../teach_panel.php");
	}
	
	return 1;
	//$dblink->close();
}
//_______________________________________________________________________InTorDb()
//Inserts torrent into private tracker database.

function InTorMainDb(){

	global $dbLink;

	define('UPLOADED_TORRENT_EXTENSION','.torrent');
	
	require_once 'File/Bittorrent2/Decode.php';

	//Decoding the torrent file
    $TorDecode = new File_Bittorrent2_Decode;	
	$info=$TorDecode->decodeFile($_FILES['torrent']['tmp_name']);
	$inHash = $TorDecode->getInfoHash();
	
	$fName=basename($_FILES['torrent']['name']);
	
	$addTor = ("INSERT into xbt_files (`info_hash`, `mtime`, `ctime`) VALUES (UNHEX('$inHash'), UNIX_TIMESTAMP(), UNIX_TIMESTAMP())");
	
	if(!$dbLink->query($addTor)){
			$_SESSION['error_message'] = sprintf('This torrent has all ready been added.');
			header("Location: ../teach_panel.php");
	}
}
//_______________________________________________________________________classAddTorrent
//Insert torrent information into class database. FID, Torrent File, Description. 
function classAddTorrent_Main(){
		global $dbLink, $class_name, $torrent_description, $torrent_type, $mainFID;
		
		$tmpName  = $_FILES['torrent']['tmp_name'];
		$name	  = $_FILES['torrent']['name'];
		
		$fp	= fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content);
		fclose($fp);
				
		$addFile = "INSERT INTO edu_files (`fid`, `torrent_name`, `description`, `type`, `torrent_file`) VALUES ('$mainFID', '$name', '$torrent_description','$torrent_type', '$content')";
		
		if (!$dbLink->query($addFile)){
		$_SESSION['error_message'] = sprintf('This file has failed to upload to the database.');
		header("Location: ../teach_panel.php");
		}
		else 
		{
			return TRUE;
		}
}
//_______________________________________________________________________mkPassKey
//Creates a passkey for users and files each with an unique pass key
function mkPasskey(){

	global $dbLink, $mainFID, $userID;
	
$site_keyQ = "SELECT `value` FROM `xbt_config` WHERE name='torrent_pass_private_key'";
	if($result = $dbLink->query($site_keyQ)){
		while ($row = $result->fetch_row()){
			$site_key=$row[0];}
		$result->close();
	}

$torInHash = "SELECT `info_hash` FROM `xbt_files` WHERE fid={$mainFID}";

if($result = $dbLink->query($torInHash)){
		while ($row = $result->fetch_row()){
			$info_hash_bin=$row[0];}
		$result->close();
	}

$info_hash=bin2hex($info_hash_bin);

$torPaQu   = "SELECT `torrent_pass_version` FROM `xbt_users` WHERE uid={$userID}";

if($result = $dbLink->query($torPaQu)){
		while ($row = $result->fetch_row()){
			$torrent_pass_version=$row[0];}
		$result->close();
	}

$passkey = sprintf('%08x%s', $uid, substr(sha1(sprintf('%s %d %d %s', $site_key, $torrent_pass_version, $uid, pack('H*', $info_hash))), 0, 24));

return $passkey;

}//_______________________________________________________________________classAddTorrent
//Insert torrent information into class database. FID, Torrent File, Description. 
function classAddTorrent(){
		global $dbLink, $class_name, $torrent_description, $torrent_type, $mainFID;

		$addtoReg = "INSERT INTO file_registrar (`c_id`, `fid`) VALUES ('$class_name', '$mainFID')";
		
		if(!$dbLink->query($addtoReg)){
				$_SESSION['error_message']='Your file can not be registered';
				header("Location : ../teach_panel.php");
		}
}

//__________________________________________________________________________getFID
//Gets the last file ID used in the database system.
function fidFunc(){
	global $dbLink;
	
	$TorQueR=$dbLink->query("SHOW TABLE STATUS LIKE 'xbt_files'");
	$row=$TorQueR->fetch_array();
	$n_Incrment = $row['Auto_increment'];
	
	return $n_Incrment;
}
//*******************************************************************************//
//		Close Database															 //
$dbLink->close();
?>