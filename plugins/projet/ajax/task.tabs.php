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
header("Content-Type: text/html; charset=UTF-8");
header_nocache();

if(!isset($_POST["id"])) {
	exit();
}

if(!isset($_POST["withtemplate"])) $_POST["withtemplate"] = "";

$PluginProjetTask=new PluginProjetTask();
$PluginProjetTask->checkGlobal("r");

$PluginProjetTask_Item=new PluginProjetTask_Item();

if ($_POST["id"]>0 && $PluginProjetTask->can($_POST["id"],'r')) {
   switch($_REQUEST['glpi_tab']) {
      case -1 :
         $PluginProjetTask->showHierarchy($_POST["id"],1);
         $PluginProjetTask->showHierarchy($_POST["id"]);
         $PluginProjetTask_Item->showItemFromPlugin($_POST["id"],$_POST["withtemplate"]);
         break;
      case 12 :
         Log::showForItem($PluginProjetTask);
         break;
      default :
         $PluginProjetTask->showHierarchy($_POST["id"],1);
         $PluginProjetTask->showHierarchy($_POST["id"]);
         $PluginProjetTask_Item->showItemFromPlugin($_POST["id"],$_POST["withtemplate"]);
         break;
   }
}

ajaxFooter();	

?>