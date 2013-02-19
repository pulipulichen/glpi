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
header("Content-Type: text/html; charset=UTF-8");
header_nocache();

$PluginProjetTask=new PluginProjetTask();
$PluginProjetTask->checkGlobal("r");

$PluginProjetTask_Item=new PluginProjetTask_Item();

if (isset($_POST["action"]) && isset($_POST["id"]) && isset($_POST["item"]) && count($_POST["item"]) && isset($_POST["itemtype"])) {

	switch($_POST["action"]) {
		case "delete":
         $PluginProjetTask->getFromDB($_POST["id"],-1);
         foreach ($_POST["item"] as $key => $val) {
            if ($val==1) {
               $PluginProjetTask->delete(array("id"=>$key),$force=0);
            }
         }
         break;
		case "purge":
			$PluginProjetTask->getFromDB($_POST["id"],-1);
         foreach ($_POST["item"] as $key => $val) {
            if ($val==1) {
               $PluginProjetTask->delete(array("id"=>$key),1);
            }
         }
         break;
		case "restore":
			$PluginProjetTask->getFromDB($_POST["id"],-1);
			foreach ($_POST["item"] as $key => $val) {
				if ($val==1) {
					$PluginProjetTask->restore(array("id"=>$key));
				}
			}
         break;
		case "install":
         foreach ($_POST["item"] as $key => $val) {
            if ($val==1) {
               $args = explode(",",$_POST['item_item']);
               $PluginProjetTask_Item->addTaskItem($key,$args[1],$args[0]);
            }
         }
         break;
		case "desinstall":
			foreach ($_POST["item"] as $key => $val) {
				if ($val==1) {
					$args = explode(",",$_POST['item_item']);
					$PluginProjetTask_Item->deleteItemByTaskAndItem($key,$args[0],$args[1]);
            }
         }
         break;
		case "duplicate":
			foreach ($_POST["item"] as $key => $val) {
				if ($val==1) {
					$PluginProjetTask->getFromDB($key);		
					unset($PluginProjetTask->fields["id"]);
					$PluginProjetTask->fields["name"] = addslashes($PluginProjetTask->fields["name"]);
					$PluginProjetTask->fields["comment"] = addslashes($PluginProjetTask->fields["comment"]);
					$PluginProjetTask->fields["sub"] = addslashes($PluginProjetTask->fields["sub"]);
					$PluginProjetTask->fields["others"] = addslashes($PluginProjetTask->fields["others"]);
					$PluginProjetTask->fields["affect"] = addslashes($PluginProjetTask->fields["affect"]);
					$newID=$PluginProjetTask->add($PluginProjetTask->fields);
				}
         }
         break;
		case "update":
         $searchopt = Search::getCleanedOptions($_POST["itemtype"],'w');
         if (isset($searchopt[$_POST["id_field"]]) && class_exists($_POST["itemtype"])) {
            $item = new $_POST["itemtype"]();
            $link_entity_type = array();
            /// Specific entity item
            $itemtable = getTableForItemType($_POST["itemtype"]);

            $itemtype2 = getItemTypeForTable($searchopt[$_POST["id_field"]]["table"]);
            if (class_exists($itemtype2)) {
               $item2 = new $itemtype2();

               if ($searchopt[$_POST["id_field"]]["table"] != $itemtable
                   && $item2->isEntityAssign()
                   && $item->isEntityAssign()) {
                  if ($item2->getFromDB($_POST[$_POST["field"]])) {
                     if (isset($item2->fields["entities_id"])
                         && $item2->fields["entities_id"] >=0) {

                        if (isset($item2->fields["is_recursive"])
                            && $item2->fields["is_recursive"]) {

                           $link_entity_type = getSonsOf("glpi_entities",
                                                         $item2->fields["entities_id"]);
                        } else {
                           $link_entity_type[] = $item2->fields["entities_id"];
                        }
                     }
                  }
               }
            }
            foreach ($_POST["item"] as $key => $val) {
               if ($val == 1) {
                  if ($item->getFromDB($key)) {
                     if (count($link_entity_type) == 0
                         || in_array($item->fields["entities_id"],$link_entity_type)) {
                        $item->update(array('id'            => $key,
                                            $_POST["field"] => $_POST[$_POST["field"]]));
                     }
                  }
               }
            }
         }
         break;
	}

	addMessageAfterRedirect($LANG['common'][23]);
	glpi_header($_SERVER['HTTP_REFERER']);

} else {
	
	commonHeader($LANG['plugin_projet']['title'][1],$_SERVER['PHP_SELF'],"plugins","projet");
	echo "<div align='center'><img src=\"".$CFG_GLPI["root_doc"]."/pics/warning.png\" alt=\"warning\"><br><br>";
	echo "<b>".$LANG['common'][24]."</b></div>";
}

commonFooter();

?>