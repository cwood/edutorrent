<?php
//*******************Database Information
include "db.php";
//*******************Session Start
session_start();
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^//
//         Globals           //
$userID = $_SESSION['uid'];
//##############################################################################//
//       Start Main PHP Code         //

$sqlGetClass = "SELECT c_id FROM registrar WHERE uid='$userID'";
printf("<div id='torrents'>");
if ($getClassQ = $dbLink->query($sqlGetClass)) {
	while ($getClassR = $getClassQ->fetch_assoc()) {
		foreach ($getClassR as $class) {
			$sqlGetDesc = "SELECT class_name FROM classes WHERE c_id='$class'";
			$explode = explode('_', $class);

			if ($class_Desc = $dbLink->query($sqlGetDesc)) {
				while ($class_DescR = $class_Desc->fetch_assoc()) {
					foreach ($class_DescR as $class_name) {
						printf("<p id='%s'><h4>%s</h4></p>", $explode[3], $explode[3]);
						printf("<table id='torrent_category'>");
						printf("<tr><th colspan=5><h5>%s</h5></th></tr>", $class_name);
						$sqlGetFID = "SELECT fid FROM file_registrar WHERE c_id='$class'";
						$sqlGetTypes = "SELECT DISTINCT type FROM edu_files";

						if ($fidQ = $dbLink->query($sqlGetFID)) {
							while ($fid = $fidQ->fetch_assoc()) {
								if ($typesR = $dbLink->query($sqlGetTypes)) {
									while ($typesA = $typesR->fetch_assoc())
										foreach ($typesA as $type) {
											$classQ = "SELECT `fid`, `type`, `description`, `torrent_name` FROM edu_files WHERE fid={$fid['fid']} && type='$type'";
											if ($torrent_result = $dbLink->query($classQ)) {
												while ($torrent_info = $torrent_result->fetch_assoc()) {

													$sqlxbt_files = "SELECT `leechers`, `seeders` FROM xbt_files WHERE fid={$fid['fid']}";
													if ($get_Info = $dbLink->query($sqlxbt_files)) {
														while ($get_Resault = $get_Info->fetch_assoc()) {
															printf("<tr> <th colspan=5><h5>%s</h5></th></tr>", $type);
															printf("<tr><td>Name</td><td>Description</td><td>Seeds</td><td>Leechers</td><td>Download</td></tr>");
															printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $torrent_info['torrent_name'], $torrent_info['description'], $get_Resault['seeders'], $get_Resault['leechers']);
															printf("<td><a href='scripts/download_torrent.php?fid=%s'><img src='../images/download.png' width=16px height=16px/></a></td></tr>", $torrent_info['fid']);
														}
													}
												}
											}
										}
								}
								$torrent_result->close();
							}
						}
						printf("</table>");
					}//end of if($torr
				}//end of foreac
			}
		}
	}

}
printf("</div>");
//*******************************************************************************//
//       Functions start           //
//_______________________________________________________________________printClass
//prints torrent output table. Organized by class and torrents by type.

//end of function printClass

//*******************************************************************************//
//  Close Database                //
$dbLink->close();
?>