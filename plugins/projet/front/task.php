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

commonHeader($LANG['plugin_projet']['title'][1],'',"plugins","projet");

$PluginProjetTask = new PluginProjetTask();
if(($PluginProjetTask->canView() || haveRight("config","w"))) {
	
	Search::manageGetValues("PluginProjetTask");
	
	//if $_GET["plugin_projet_projets_id"] exist this show list of tasks from a projet
	//else show all tasks
	if (isset($_GET["plugin_projet_projets_id"]) && !empty($_GET["plugin_projet_projets_id"])) {
		
		$_GET["field"] = array(0=>"23");
		$_GET["contains"] = array(0=>$_GET["plugin_projet_projets_id"]);
	
	}
	
	Search::showGenericSearch("PluginProjetTask",$_GET);
   Search::showList("PluginProjetTask",$_GET);	
	
} else {
	echo "<div align='center'><br><br><img src=\"".$CFG_GLPI["root_doc"]."/pics/warning.png\" alt=\"warning\"><br><br>";
	echo "<b>".$LANG['login'][5]."</b></div>";
}

commonFooter();

?>