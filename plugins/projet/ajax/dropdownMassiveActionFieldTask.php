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

if (!isset($_POST["itemtype"]) || !class_exists($_POST["itemtype"])) {
   exit();
}

$PluginProjetTask = new PluginProjetTask();

$item = new $_POST["itemtype"]();
$item->checkGlobal("w");


if (isset($_POST["itemtype"]) && isset($_POST["id_field"]) && $_POST["id_field"]) {
   
   $search = Search::getOptions($_POST["itemtype"]);
	$search = $search[$_POST["id_field"]];
	
	$FIELDNAME_PRINTED=false;
	$table = getTableForItemType($_POST["itemtype"]);
	if ($search["table"]==$table) { // field type
      switch ($search["table"].".".$search["linkfield"]) {
			case $table.".show_gantt":
			case $table.".depends":
				echo "&nbsp;";
				Dropdown::showYesNo($search["field"]);
            break;
			case $table.".priority":
				Ticket::dropdownPriority($search["linkfield"],$search["field"],false,true);
            break;
			case $table.".advance":
				echo "<select name='advance'>";
            for ($i=0;$i<101;$i+=5) {
               echo "<option value='$i'>$i</option>";
            }
            echo "</select> ";
				echo "<input type='hidden' name='field' value='advance'>";
            break;
			default :
            // Specific plugin Type case
            $plugdisplay = false;
            if ($plug=isPluginItemType($_POST["itemtype"])) {
               $plugdisplay = doOneHook($plug['plugin'], 'MassiveActionsFieldsDisplay',
                                        array('itemtype' => $_POST["itemtype"],
                                              'options'  => $search));
            }
            $already_display = false;

            if (isset($search['datatype'])) {
               switch ($search['datatype']) {
                  case "date" :
                     showDateFormItem($search["field"]);
                     $already_display = true;
                     break;

                  case "datetime" :
                     showDateTimeFormItem($search["field"]);
                     $already_display = true;
                     break;

                  case "bool" :
                     Dropdown::showYesNo($search["linkfield"]);
                     $already_display = true;
                     break;
               }
            }

            if (!$plugdisplay && !$already_display) {
               $newtype = getItemTypeForTable($search["table"]);
               if ($newtype != $_POST["itemtype"]) {
                  $item = new $newtype();
               }
               autocompletionTextField($item, $search["field"],
                                       array('name'   => $search["linkfield"],
                                             'entity' => $_SESSION["glpiactive_entity"]));
            }
		}
	} else { 
	
		switch ($search["table"]) {

			case "glpi_users": // users
            $PluginProjetTask->dropdownItems($_POST["plugin_projet_projets_id"],$search["linkfield"],array(),'','User');
				break;
			case "glpi_groups": // FK_groups
            $PluginProjetTask->dropdownItems($_POST["plugin_projet_projets_id"],$search["linkfield"],array(),'','Group');
				break;
			case "glpi_contacts": // Suppliers
				$PluginProjetTask->dropdownItems($_POST["plugin_projet_projets_id"],$search["linkfield"],array(),'','Supplier');
				break;
			default : // dropdown case
            $plugdisplay = false;
            // Specific plugin Type case
            if (($plug=isPluginItemType($_POST["itemtype"]))
                // Specific for plugin which add link to core object
                || ($plug=isPluginItemType(getItemTypeForTable($search['table'])))) {
               $plugdisplay = doOneHook($plug['plugin'], 'MassiveActionsFieldsDisplay',
                                        array('itemtype' => $_POST["itemtype"],
                                              'options'  => $search));
            }
            $already_display = false;

            if (isset($search['datatype'])) {
               switch ($search['datatype']) {
                  case "date" :
                     showDateFormItem($search["field"]);
                     $already_display = true;
                     break;

                  case "datetime" :
                     showDateTimeFormItem($search["field"]);
                     $already_display = true;
                     break;

                  case "bool" :
                     Dropdown::showYesNo($search["linkfield"]);
                     $already_display = true;
                     break;
               }
            }

            if (!$plugdisplay && !$already_display) {
               Dropdown::show(getItemTypeForTable($search["table"]),
                              array('name'   => $search["linkfield"],
                                    'entity' => $_SESSION['glpiactiveentities']));
            }
		}
	}
	
	if (!$FIELDNAME_PRINTED) {
      if (empty($search["linkfield"])) {
         echo "<input type='hidden' name='field' value='".$search["field"]."'>";
      } else {
         echo "<input type='hidden' name='field' value='".$search["linkfield"]."'>";
      }
   }

   echo "&nbsp;<input type='submit' name='massiveaction' class='submit' value='".
                $LANG['buttons'][2]."'>";
}

?>