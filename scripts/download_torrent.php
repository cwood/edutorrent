<?php
session_start();
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^//
//									Globals										 //
include ("db.php");
$fid = ($_GET["fid"]);
$uid = ($_SESSION["uid"]);
//##############################################################################//
//							Start Main PHP Code									//


$passkey = mkPasskey();
$announce_url=mkAnnounceURL();
$torrent_file=getTorrentFile();

mkTorrentFile();

//*******************************************************************************//
//							Functions start										 //
//_______________________________________________________________________mkPassKey
//Creates a passkey for users and files each with an unique pass key
function mkPasskey(){

	global $dbLink, $fid, $uid;
	
$site_keyQ = "SELECT `value` FROM `xbt_config` WHERE name='torrent_pass_private_key'";
	if($result = $dbLink->query($site_keyQ)){
		while ($row = $result->fetch_row()){
			$site_key=$row[0];}
		$result->close();
	}

$torInHash = "SELECT `info_hash` FROM `xbt_files` WHERE fid={$fid}";

if($result = $dbLink->query($torInHash)){
		while ($row = $result->fetch_row()){
			$info_hash_bin=$row[0];}
		$result->close();
	}

$info_hash=bin2hex($info_hash_bin);

$torPaQu   = "SELECT `torrent_pass_version` FROM `xbt_users` WHERE uid={$uid}";

if($result = $dbLink->query($torPaQu)){
		while ($row = $result->fetch_row()){
			$torrent_pass_version=$row[0];}
		$result->close();
	}

$passkey = sprintf('%08x%s', $uid, substr(sha1(sprintf('%s %d %d %s', $site_key, $torrent_pass_version, $uid, pack('H*', $info_hash))), 0, 24));

return $passkey;

}
//_______________________________________________________________________mkAnnounceURL
//Creates a passkey for users and files each with an unique pass key//
function mkAnnounceURL(){

	global $passkey;
	
	$host="edutorrent.colinbits.com";
	$port="2710";
	
	$announce_url="http://$host:$port/$passkey/announce";
	
	return $announce_url;
}
//_______________________________________________________________________getTorrentFile()
//Gets the torrent file from the database.
function getTorrentFile(){
		
		global $dbLink, $fid;
		
		$torrent_file = "SELECT * FROM edu_files WHERE fid='$fid'";
		
		if($result = $dbLink->query($torrent_file)){
			while ($row = $result->fetch_row()){
			$torrent_name=$row[3];
			$torrent_file=$row[4];}
			$result->close();
	}		
		return $torrent_file;
		
}
//_______________________________________________________________________mkTorrentFile()
//Creates a torrent file with the use of Torrent.php class in /usr/share/php/.

function mkTorrentFile(){
	global $announce_url, $torrent_file;
	
	require_once('Torrent.php');
	
	$downTorrent = new Torrent ($torrent_file);
	
	$downTorrent->announce($announce_url);
	
	$downTorrent->send();
}
//*******************************************************************************//
//		Close Database															 //
$dbLink->close();
?>