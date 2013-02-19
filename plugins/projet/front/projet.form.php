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
include (GLPI_ROOT."/inc/includes.php");

if (!isset($_GET["id"])) $_GET["id"] = "";
if (!isset($_GET["withtemplate"])) $_GET["withtemplate"] = "";

$PluginProjetProjet=new PluginProjetProjet();
$PluginProjetProjet_Item=new PluginProjetProjet_Item();

//Project
if (isset($_POST["add"])) {
	
	$PluginProjetProjet->check(-1,'w',$_POST);
   $newID=$PluginProjetProjet->add($_POST);
	glpi_header($_SERVER['HTTP_REFERER']);
} 
else if (isset($_POST["delete"]))
{
	$PluginProjetProjet->check($_POST['id'],'w');
   if (!empty($_POST["withtemplate"]))
      $PluginProjetProjet->delete($_POST,1);
   else $PluginProjetProjet->delete($_POST);
	
	if(!empty($_POST["withtemplate"])) 
		glpi_header($CFG_GLPI["root_doc"]."/plugins/projet/front/setup.templates.php?add=0");
	else 
		glpi_header(getItemTypeSearchURL('PluginProjetProjet'));
}
else if (isset($_POST["restore"]))
{
	$PluginProjetProjet->check($_POST['id'],'w');
	$PluginProjetProjet->restore($_POST);
	glpi_header(getItemTypeSearchURL('PluginProjetProjet'));
}
else if (isset($_POST["purge"]))
{
   $PluginProjetProjet->check($_POST['id'],'w');
	$PluginProjetProjet->delete($_POST,1);
	glpi_header(getItemTypeSearchURL('PluginProjetProjet'));

}
else if (isset($_GET["purge"]))
{
	$PluginProjetProjet->check($_GET['id'],'w');
	$PluginProjetProjet->delete($_GET,1);
	if(!empty($_GET["withtemplate"])) 
		glpi_header($CFG_GLPI["root_doc"]."/plugins/projet/front/setup.templates.php?add=0");
	else 
		glpi_header(getItemTypeSearchURL('PluginProjetProjet'));
}
else if (isset($_POST["update"]))
{
	$PluginProjetProjet->check($_POST['id'],'w');
	$PluginProjetProjet->update($_POST);
	glpi_header($_SERVER['HTTP_REFERER']);
} 
//Items Project
else if (isset($_POST["additem"]))
{
	if (!empty($_POST['itemtype'])) {
      $PluginProjetProjet_Item->check(-1,'w',$_POST);
		$PluginProjetProjet_Item->addItem($_POST["plugin_projet_projets_id"],$_POST['items_id'],$_POST['itemtype']);
	}
	glpi_header($_SERVER['HTTP_REFERER']);

}
else if (isset($_POST["deleteitem"]))
{

	foreach ($_POST["item"] as $key => $val) {
   if ($val==1) {
      $PluginProjetProjet_Item->check($key,'w');
      $PluginProjetProjet_Item->deleteItem($key);
      }
   }

	glpi_header($_SERVER['HTTP_REFERER']);
}
else if (isset($_GET["deletedevice"]))
{

	$input = array('id' => $_GET["id"]);
   $PluginProjetProjet_Item->check($_GET["id"],'w');
   $PluginProjetProjet_Item->deleteItem($_GET["id"]);
	glpi_header($_SERVER['HTTP_REFERER']);
}
else
{
	$PluginProjetProjet->checkGlobal("r");

	commonHeader($PluginProjetProjet->getName(), '',"plugins","projet");

	$PluginProjetProjet->showForm($_GET["id"], array('withtemplate' => $_GET["withtemplate"]));
}

commonFooter();

?>