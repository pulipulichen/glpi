<?php
/*
 * @version $Id: HEADER 15930 2012-03-08 15:47:55Z tsmr $
 -------------------------------------------------------------------------
 Projet plugin for GLPI
 Copyright (C) 2003-2012 by the Projet Development Team.

 https://forge.indepnet.net/projects/projet
 -------------------------------------------------------------------------

 LICENSE
		
 This file is part of Projet.

 Projet is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 Projet is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Projet. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

define('GLPI_ROOT', '../../..');
include (GLPI_ROOT . "/inc/includes.php");

if(!isset($_GET["id"])) $_GET["id"] = "";
if(!isset($_GET["withtemplate"])) $_GET["withtemplate"] = "";
if(isset($_POST["hour"])&&isset($_POST["minute"])) $_POST["realtime"]=$_POST["hour"]+$_POST["minute"]/60;
if(!isset($_GET["plugin_projet_projets_id"])) $_GET["plugin_projet_projets_id"] = 0;

$PluginProjetTask=new PluginProjetTask();
$PluginProjetTask_Item=new PluginProjetTask_Item();

//add tasks
if (isset($_POST['add'])) {

	$PluginProjetTask->check(-1,'w',$_POST);
	$newID=$PluginProjetTask->add($_POST);
   glpi_header($_SERVER['HTTP_REFERER']);

} 
//update task
else if (isset($_POST["update"])) {

	$PluginProjetTask->check($_POST['id'],'w');
   $PluginProjetTask->update($_POST);
  //no sending mail here : see post_updateItem of PluginProjetTask
	glpi_header($_SERVER['HTTP_REFERER']);
	
}
//from central
//delete task
else if (isset($_POST["delete"])) {
	
	$PluginProjetTask->check($_POST['id'],'w');
	$PluginProjetTask->delete($_POST);
	glpi_header(getItemTypeFormURL('PluginProjetProjet')."?id=".$_POST["plugin_projet_projets_id"]);
	
}
//from central
//restore task
else if (isset($_POST["restore"]))
{
	$PluginProjetTask->check($_POST['id'],'w');
   $PluginProjetTask->restore($_POST);
	glpi_header(getItemTypeFormURL('PluginProjetProjet')."?id=".$_POST["plugin_projet_projets_id"]);
}
//from central
//purge task
else if (isset($_POST["purge"]))
{
	$PluginProjetTask->check($_POST['id'],'w');
   $PluginProjetTask->delete($_POST,1);
	glpi_header(getItemTypeFormURL('PluginProjetProjet')."?id=".$_POST["plugin_projet_projets_id"]);
}
//from central
//add item to task
else if (isset($_POST["addtaskitem"])) {

	$args = explode(",",$_POST['item_item']);
	if($PluginProjetTask->canCreate())
		$PluginProjetTask_Item->addTaskItem($_POST["plugin_projet_tasks_id"],$args[1],$args[0]);

	glpi_header($_SERVER['HTTP_REFERER']);
}
//from central
//delete item to task
else if (isset($_GET["deletetaskitem"])) {

	if($PluginProjetTask->canCreate())
		$PluginProjetTask_Item->deleteTaskItem($_GET["id"]);
	glpi_header($_SERVER['HTTP_REFERER']);
}
else
{

	$PluginProjetTask->checkGlobal("r");
	
	commonHeader($LANG['plugin_projet']['title'][1],'',"plugins","projet");

	$PluginProjetTask->showForm($_GET["id"], array('plugin_projet_projets_id' => $_GET["plugin_projet_projets_id"],'withtemplate' => $_GET["withtemplate"]));

	commonFooter();
}

?>