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

if (!isset ($_POST["withtemplate"]))
	$_POST["withtemplate"] = "";

$PluginProjetProjet=new PluginProjetProjet();
$PluginProjetProjet->checkGlobal("r");

$PluginProjetProjet_Item=new PluginProjetProjet_Item();
$PluginProjetTask=new PluginProjetTask();

//show computer form to add
if ($_POST["id"]>0 && $PluginProjetProjet->can($_POST["id"],'r')) {
   if (!empty($_POST["withtemplate"])) {
		switch($_REQUEST['glpi_tab']) {

         case 4:	
            $PluginProjetProjet_Item->showItemFromPlugin($_POST["id"],$_POST["withtemplate"]);
            break;
         case 5:
            Contract::showAssociated($PluginProjetProjet,$_POST["withtemplate"]);
            Document::showAssociated($PluginProjetProjet,$_POST["withtemplate"]);
            break;
         case 6:
            $PluginProjetProjet_Item->showItemFromPlugin($_POST["id"],$_POST["withtemplate"],true);
            break;
         case 8:
           if($_POST["withtemplate"]<2 && $PluginProjetTask->canCreate())
					$PluginProjetTask->addNewTasks($_POST["id"]);
				if ($PluginProjetTask->canView()) {
					$PluginProjetTask->showMinimalList($_POST);
               $PluginProjetTask->taskLegend();
            }
            break;
         default :
            if (!Plugin::displayAction($PluginProjetProjet,$_REQUEST['glpi_tab'])) {
               $PluginProjetProjet->showHierarchy($_POST["id"],1);
               $PluginProjetProjet->showHierarchy($_POST["id"]);
            }
            break;
      }
   } else {

   switch($_REQUEST['glpi_tab']) {
      case -1:
            if ($_POST["withtemplate"]<2) {
               PluginProjetProjet::showProjetTreeGantt(array('plugin_projet_projets_id'=>$_POST["id"],'prefixp'=>'','parent'=>0));
            }					
            $PluginProjetProjet->showHierarchy($_POST["id"],1);
            $PluginProjetProjet->showHierarchy($_POST["id"]);
            
            $PluginProjetProjet_Item->showItemFromPlugin($_POST["id"],$_POST["withtemplate"]);
            Contract::showAssociated($PluginProjetProjet,$_POST["withtemplate"]);
            Document::showAssociated($PluginProjetProjet,$_POST["withtemplate"]);
            $PluginProjetProjet_Item->showItemFromPlugin($_POST["id"],$_POST["withtemplate"],true);
            
            if($_POST["withtemplate"]<2 && $PluginProjetTask->canCreate())
					$PluginProjetTask->addNewTasks($_POST["id"]);
				if ($PluginProjetTask->canView())
					$PluginProjetTask->showMinimalList($_POST);
            
            Plugin::displayAction($PluginProjetProjet,$_REQUEST['glpi_tab']);
            break;
         case 3:
            if ($_POST["withtemplate"]<2) {
               PluginProjetProjet::showProjetTreeGantt(array('plugin_projet_projets_id'=>$_POST["id"],'prefixp'=>'','parent'=>0));
               $PluginProjetTask->taskLegend();
            }
            break;
         case 4:	
            $PluginProjetProjet_Item->showItemFromPlugin($_POST["id"],$_POST["withtemplate"]);			
            break;
         case 5:
            Contract::showAssociated($PluginProjetProjet,$_POST["withtemplate"]);
            Document::showAssociated($PluginProjetProjet,$_POST["withtemplate"]);
            break;
         case 6:
            $PluginProjetProjet_Item->showItemFromPlugin($_POST["id"],$_POST["withtemplate"],true);
            break;
         case 7:
            Ticket::showListForItem("PluginProjetProjet",$_POST["id"]);
            break;
         case 8:
            if($_POST["withtemplate"]<2 && $PluginProjetTask->canCreate())
					$PluginProjetTask->addNewTasks($_POST["id"]);
				if ($PluginProjetTask->canView()) {
					$PluginProjetTask->showMinimalList($_POST);
               $PluginProjetTask->taskLegend();
            }
            break;
         case 10 :
            showNotesForm($_POST['target'],"PluginProjetProjet",$_POST["id"]);
            break;	
         case 12 :
            Log::showForItem($PluginProjetProjet);
            break;
         default :
            if (!Plugin::displayAction($PluginProjetProjet,$_REQUEST['glpi_tab'])) {
               $PluginProjetProjet->showHierarchy($_POST["id"],1);
               $PluginProjetProjet->showHierarchy($_POST["id"]);
            }
            break;
      }
	}
}

ajaxFooter();

?>