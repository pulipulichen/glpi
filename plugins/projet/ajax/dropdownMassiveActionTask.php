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

$PluginProjetTask_Item=new PluginProjetTask_Item();

if (isset($_POST["action"]) && isset($_POST["itemtype"]) && !empty($_POST["itemtype"])) {
	echo "<input type='hidden' name='action' value='".$_POST["action"]."'>";
	echo "<input type='hidden' name='id' value='".$_POST["id"]."'>";
	echo "<input type='hidden' name='itemtype' value='".$_POST["itemtype"]."'>";
	switch($_POST["action"]) {

		case "delete":
      case "purge":
      case "restore":
			echo "&nbsp;<input type=\"submit\" name=\"massiveaction\" class=\"submit\" value=\"".$LANG['buttons'][2]."\" >";
         break;
		case "install":
         echo "&nbsp;";
         $PluginProjetTask_Item->dropdownTaskItems($_POST["plugin_projet_projets_id"],"item_item");
         echo "&nbsp;<input type=\"submit\" name=\"massiveaction\" class=\"submit\" value=\"".$LANG['buttons'][2]."\" >";
         break;
		case "desinstall":
         echo "&nbsp;";
			$PluginProjetTask_Item->dropdownTaskItems($_POST["plugin_projet_projets_id"],"item_item");
         echo "&nbsp;<input type=\"submit\" name=\"massiveaction\" class=\"submit\" value=\"".$LANG['buttons'][2]."\" >";
         break;
		case "duplicate":
         echo "&nbsp;";
         echo "<input type=\"submit\" name=\"massiveaction\" class=\"submit\" value=\"".$LANG['buttons'][2]."\" >";
         break;
         
      case "update" :
         $first_group    = true;
         $newgroup       = "";
         $items_in_group = 0;
         $show_all       = true;
         $show_infocoms  = true;

         $searchopt = Search::getCleanedOptions($_POST["itemtype"], 'w');

         echo "<select name='id_field' id='massiveaction_field'>";
         echo "<option value='0' selected>".DROPDOWN_EMPTY_VALUE."</option>";

         foreach ($searchopt as $key => $val) {
            if (!is_array($val)) {
               if (!empty($newgroup) && $items_in_group>0) {
                  echo $newgroup;
                  $first_group = false;
               }
               $items_in_group = 0;
               $newgroup       = "";
               if (!$first_group) {
                  $newgroup .= "</optgroup>";
               }
               $newgroup .= "<optgroup label=\"$val\">";

            } else {
               // No id and no entities_id massive action and no first item
               if ($val["field"]!='id'
                   && $key != 1
                   // Permit entities_id is explicitly activate
                   && ($val["linkfield"]!='entities_id'
                       || (isset($val['massiveaction']) && $val['massiveaction']))) {

                  if (!isset($val['massiveaction']) || $val['massiveaction']) {

                     if ($show_all) {
                        $newgroup .= "<option value='$key'>".$val["name"]."</option>";
                        $items_in_group++;

                     } else {
                        // Do not show infocom items
                        if (($show_infocoms && Search::isInfocomOption($_POST["itemtype"],$key))
                            || (!$show_infocoms && !Search::isInfocomOption($_POST["itemtype"],
                                                                            $key))) {

                           $newgroup .= "<option value='$key'>".$val["name"]."</option>";
                           $items_in_group++;
                        }
                     }
                  }
               }
            }
         }

         if (!empty($newgroup) && $items_in_group>0) {
            echo $newgroup;
         }
         if (!$first_group) {
            echo "</optgroup>";
         }
         echo "</select>";

         $paramsmassaction = array('id_field' => '__VALUE__',
                                   'itemtype' => $_POST["itemtype"]);

         foreach ($_POST as $key => $val) {
            if (preg_match("/extra_/",$key,$regs)) {
               $paramsmassaction[$key] = $val;
            }
         }
         ajaxUpdateItemOnSelectEvent("massiveaction_field", "show_massiveaction_field",
                                     $CFG_GLPI["root_doc"]."/plugins/projet/ajax/dropdownMassiveActionFieldTask.php",
                                     $paramsmassaction);

         echo "<span id='show_massiveaction_field'>&nbsp;</span>\n";
         break;
	}
}

?>