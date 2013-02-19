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

function plugin_projet_install() {
	global $DB,$LANG;
	
	include_once (GLPI_ROOT."/plugins/projet/inc/profile.class.php");
	include_once (GLPI_ROOT."/plugins/projet/inc/task.class.php");
	include_once (GLPI_ROOT."/plugins/projet/inc/projet.class.php");
	include_once (GLPI_ROOT."/plugins/projet/inc/notificationtargetprojet.class.php");
	include_once (GLPI_ROOT."/plugins/projet/inc/taskplanning.class.php");
   
	if (!TableExists("glpi_plugin_projet_projets") 
         && !TableExists("glpi_plugin_projet") 
            && !TableExists("glpi_plugin_project") 
               && !TableExists("glpi_project")) {
      
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/empty-1.2.0.sql");
		include_once(GLPI_ROOT."/plugins/projet/install/install_120.php");
		install120();

	} else if (TableExists("glpi_project") 
                  && !FieldExists("glpi_plugin_project_profiles","task")) {
      
      $DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-0.6.sql");
		plugin_projet_updatev62();
		plugin_projet_updatev7();
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-0.7.sql");
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-0.8.sql");
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-0.9.sql");
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-1.0.0.sql");
      include_once(GLPI_ROOT."/plugins/projet/install/update_101_110.php");
      update101to110();
      include_once(GLPI_ROOT."/plugins/projet/install/update_110_120.php");
      update110to120();
      
	} else if (TableExists("glpi_plugin_project") 
                  && !FieldExists("glpi_plugin_project_profiles","task")) {
      
		plugin_projet_updatev62();
		plugin_projet_updatev7();
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-0.7.sql");
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-0.8.sql");
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-0.9.sql");
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-1.0.0.sql");
		include_once(GLPI_ROOT."/plugins/projet/install/update_101_110.php");
      update101to110();
      include_once(GLPI_ROOT."/plugins/projet/install/update_110_120.php");
      update110to120();

	} else if (TableExists("glpi_plugin_project") 
               && !TableExists("glpi_dropdown_plugin_project_status")) {
      
		plugin_projet_updatev7();
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-0.7.sql");
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-0.8.sql");
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-0.9.sql");
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-1.0.0.sql");
		include_once(GLPI_ROOT."/plugins/projet/install/update_101_110.php");
      update101to110();
      include_once(GLPI_ROOT."/plugins/projet/install/update_110_120.php");
      update110to120();

	} else if (TableExists("glpi_plugin_project") 
               && !TableExists("glpi_plugin_projet")) {
      
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-0.8.sql");
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-0.9.sql");
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-1.0.0.sql");
		include_once(GLPI_ROOT."/plugins/projet/install/update_101_110.php");
      update101to110();
      include_once(GLPI_ROOT."/plugins/projet/install/update_110_120.php");
      update110to120();

	} else if (TableExists("glpi_plugin_projet") 
               && !FieldExists("glpi_plugin_projet_tasks","location")) {
      
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-0.9.sql");
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-1.0.0.sql");
		include_once(GLPI_ROOT."/plugins/projet/install/update_101_110.php");
      update101to110();
      include_once(GLPI_ROOT."/plugins/projet/install/update_110_120.php");
      update110to120();
		
	} else if (TableExists("glpi_plugin_projet_profiles") 
                  && FieldExists("glpi_plugin_projet_profiles","interface")) {
		
		$DB->runFile(GLPI_ROOT ."/plugins/projet/sql/update-1.0.0.sql");
		include_once(GLPI_ROOT."/plugins/projet/install/update_101_110.php");
      update101to110();
      include_once(GLPI_ROOT."/plugins/projet/install/update_110_120.php");
      update110to120();
	
	} else if (!TableExists("glpi_plugin_projet_tasktypes")) {
		
		include_once(GLPI_ROOT."/plugins/projet/install/update_101_110.php");
      update101to110();
      include_once(GLPI_ROOT."/plugins/projet/install/update_110_120.php");
      update110to120();
	
	} else if (!TableExists("glpi_plugin_projet_taskplannings")) {
		
      include_once(GLPI_ROOT."/plugins/projet/install/update_110_120.php");
      update110to120();
	
	}
	
	$rep_files_projet = GLPI_PLUGIN_DOC_DIR."/projet";
	if (!is_dir($rep_files_projet))
      mkdir($rep_files_projet);
	
	PluginProjetProfile::createFirstAccess($_SESSION['glpiactiveprofile']['id']);
	
	return true;
}

function plugin_projet_uninstall() {
	global $DB;
	
	$tables = array("glpi_plugin_projet_projets",
               "glpi_plugin_projet_projetstates",
               "glpi_plugin_projet_projets_items",
					"glpi_plugin_projet_tasks",
					"glpi_plugin_projet_tasks_items",
					"glpi_plugin_projet_taskstates",
					"glpi_plugin_projet_tasktypes",
					"glpi_plugin_projet_taskplannings",
					"glpi_plugin_projet_profiles");
					
	foreach($tables as $table)				
		$DB->query("DROP TABLE IF EXISTS `$table`;");
	
	$oldtables = array("glpi_plugin_projet",
               "glpi_plugin_projet_items",
					"glpi_plugin_projet_tasks",
					"glpi_plugin_projet_tasks_items",
					"glpi_dropdown_plugin_projet_tasks_type",
					"glpi_plugin_projet_mailing",
					"glpi_dropdown_plugin_projet_status",
					"glpi_dropdown_plugin_projet_task_status",
					"glpi_plugin_project",
               "glpi_plugin_project_items",
					"glpi_plugin_project_tasks",
					"glpi_plugin_project_tasks_items",
					"glpi_dropdown_plugin_project_status",
					"glpi_dropdown_plugin_project_tasks_type",
					"glpi_dropdown_plugin_project_task_status",
					"glpi_plugin_project_mailing",
					"glpi_plugin_project_profiles",
					"glpi_plugin_project_users",
					"glpi_plugin_project_setup",
					"glpi_plugin_project_groups",
					"glpi_plugin_project_items",
					"glpi_plugin_project_enterprises",
					"glpi_plugin_project_contracts",
					"glpi_plugin_project_documents",
					"glpi_dropdown_project_tasks_type",
					"glpi_project",
					"glpi_project_tasks",
					"glpi_project_user",
					"glpi_project_items",
					"glpi_plugin_projet_projetitems",
					"glpi_plugin_projet_mailings",
					"glpi_plugin_projet_taskitems");
					
	foreach($oldtables as $oldtable)				
		$DB->query("DROP TABLE IF EXISTS `$oldtable`;");
		
	$rep_files_projet = GLPI_PLUGIN_DOC_DIR."/projet";

	deleteDir($rep_files_projet);
	
	$in = "IN (" . implode(',', array (
		"'PluginProjetProjet'",
		"'PluginProjetTask'"
	)) . ")";

	$tables = array (
      "glpi_displaypreferences",
		"glpi_documents_items",
		"glpi_contracts_items",
		"glpi_bookmarks",
		"glpi_logs",
      "glpi_tickets"
	);

	foreach ($tables as $table) {
		$query = "DELETE FROM `$table` WHERE (`itemtype` " . $in." ) ";
		$DB->query($query);
	}
	
	$notif = new Notification();
   
   $options = array('itemtype' => 'PluginProjetProjet',
                    'event'    => 'new',
                    'FIELDS'   => 'id');
   foreach ($DB->request('glpi_notifications', $options) as $data) {
      $notif->delete($data);
   }
   $options = array('itemtype' => 'PluginProjetProjet',
                    'event'    => 'update',
                    'FIELDS'   => 'id');
   foreach ($DB->request('glpi_notifications', $options) as $data) {
      $notif->delete($data);
   }
   $options = array('itemtype' => 'PluginProjetProjet',
                    'event'    => 'delete',
                    'FIELDS'   => 'id');
   foreach ($DB->request('glpi_notifications', $options) as $data) {
      $notif->delete($data);
   }
   $options = array('itemtype' => 'PluginProjetProjet',
                    'event'    => 'newtask',
                    'FIELDS'   => 'id');
   foreach ($DB->request('glpi_notifications', $options) as $data) {
      $notif->delete($data);
   }
   $options = array('itemtype' => 'PluginProjetProjet',
                    'event'    => 'updatetask',
                    'FIELDS'   => 'id');
   foreach ($DB->request('glpi_notifications', $options) as $data) {
      $notif->delete($data);
   }
   $options = array('itemtype' => 'PluginProjetProjet',
                    'event'    => 'deletetask',
                    'FIELDS'   => 'id');
   foreach ($DB->request('glpi_notifications', $options) as $data) {
      $notif->delete($data);
   }
   
   //templates
   $template = new NotificationTemplate();
   $translation = new NotificationTemplateTranslation();
   $options = array('itemtype' => 'PluginProjetProjet',
                    'FIELDS'   => 'id');
   foreach ($DB->request('glpi_notificationtemplates', $options) as $data) {
      $options_template = array('notificationtemplates_id' => $data['id'],
                    'FIELDS'   => 'id');
   
         foreach ($DB->request('glpi_notificationtemplatetranslations', $options_template) as $data_template) {
            $translation->delete($data_template);
         }
      $template->delete($data);
   }

	return true;
}

function plugin_projet_AssignToTicket($types) {
	global $LANG;

	if (plugin_projet_haveRight("open_ticket","1"))
		$types['PluginProjetProjet']=$LANG['plugin_projet']['title'][1];

	return $types;
}

// Define dropdown relations
function plugin_projet_getDatabaseRelations() {

	$plugin = new Plugin();
	if ($plugin->isActivated("projet"))
		return array(
		"glpi_users"=>array("glpi_plugin_projet_projets"=>array('users_id'),
                           "glpi_plugin_projet_tasks"=>"users_id"),
      "glpi_groups"=>array("glpi_plugin_projet_projets"=>"groups_id",
                             "glpi_plugin_projet_tasks"=>"groups_id"),
      "glpi_contacts"=>array("glpi_plugin_projet_tasks"=>"contacts_id"),
		"glpi_locations"=>array("glpi_plugin_projet_tasks"=>"locations_id"),
		"glpi_plugin_projet_projets"=>array("glpi_plugin_projet_projets_items"=>"plugin_projet_projets_id",
                                                "glpi_plugin_projet_tasks"=>"plugin_projet_projets_id"),
		"glpi_plugin_projet_tasktypes"=>array("glpi_plugin_projet_tasks"=>"plugin_projet_tasktypes_id"),
		"glpi_plugin_projet_projetstates"=>array("glpi_plugin_projet_projets"=>"plugin_projet_projetstates_id"),
		"glpi_plugin_projet_taskstates"=>array("glpi_plugin_projet_tasks"=>"plugin_projet_taskstates_id"),
		"glpi_plugin_projet_tasks"=>array("glpi_plugin_projet_tasks_items"=>"plugin_projet_tasks_id",
                                          "glpi_plugin_projet_taskplannings"=>"plugin_projet_tasks_id"),
      "glpi_profiles" => array ("glpi_plugin_projet_profiles" => "profiles_id"),
		"glpi_entities"=>array("glpi_plugin_projet_projets"=>"entities_id",
                              "glpi_plugin_projet_tasks"=>"entities_id",
                              "glpi_plugin_projet_tasktypes"=>"entities_id"));
	else
		return array();

}

/*
 * Define dropdown tables to be manage in GLPI
 * 
 */
function plugin_projet_getDropdown() {
	global $LANG;

	$plugin = new Plugin();
	if ($plugin->isActivated("projet"))
		return array (
         "PluginProjetProjetState" => PluginProjetProjetState::getTypeName(),
         "PluginProjetTasktype"    => PluginProjetTasktype::getTypeName(),
         "PluginProjetTaskState"    => PluginProjetTaskState::getTypeName()
		);
	else
		return array ();
}

////// SEARCH FUNCTIONS ///////(){

function plugin_projet_getAddSearchOptions($itemtype) {
   global $LANG;

   $sopt = array();
   if (plugin_projet_haveRight("projet","r")) {
      if (in_array($itemtype, PluginProjetProjet::getTypes(true))) {
         $sopt[2310]['table']          = 'glpi_plugin_projet_projets';
         $sopt[2310]['field']          = 'name';
         $sopt[2310]['massiveaction']  = false;
         $sopt[2310]['name']           = $LANG['plugin_projet']['title'][1]." - ".
                                          $LANG['plugin_projet'][0];
         $sopt[2310]['forcegroupby']   = true;
         $sopt[2310]['datatype']       = 'itemlink';
         $sopt[2310]['itemlink_type']  = 'PluginProjetProjet';
         $sopt[2310]['joinparams']     = array('beforejoin'
                                                => array('table'      => 'glpi_plugin_projet_projets_items',
                                                         'joinparams' => array('jointype' => 'itemtype_item')));

         $sopt[2311]['table']         = 'glpi_plugin_projet_projetstates';
         $sopt[2311]['field']         = 'name';
         $sopt[2311]['massiveaction'] = false;
         $sopt[2311]['name']          = $LANG['plugin_projet']['title'][1]." - ".
                                          $LANG['plugin_projet'][19];
         $sopt[2311]['forcegroupby']  =  true;
         $sopt[2311]['joinparams']     = array('beforejoin' => array(
                                                   array('table'      => 'glpi_plugin_projet_projets',
                                                         'joinparams' => $sopt[2310]['joinparams'])));
      }
   }
   return $sopt;
}

function plugin_projet_addSelect($type,$ID,$num) {
  
   $searchopt=&Search::getOptions($type);
	$table=$searchopt[$ID]["table"];
	$field=$searchopt[$ID]["field"];

	// Example of standard Select clause but use it ONLY for specific Select
	// No need of the function if you do not have specific cases
	switch ($type){
      
      case 'PluginProjetProjet':
         switch ($table.".".$field) {
            case "glpi_plugin_projet_projetstates.name" :
               return "`".$table."`.`".$field."` AS ITEM_$num, `".$table."`.`id` AS ITEM_".$num."_2, ";
               break;
         }
         return "";
         break;
      
      case 'PluginProjetProjetState':
         switch ($table.".".$field) {
            case "glpi_plugin_projet_projetstates.color" :
               return "`".$table."`.`".$field."` AS ITEM_$num, `".$table."`.`id` AS ITEM_".$num."_2, ";
               break;
         }
         return "";
         break;
           
      case 'PluginProjetTask':
         switch ($table.".".$field) {
            case "glpi_contacts.name":
               return "`".$table."`.`id` AS ITEM_$num, `".$table."`.`name` AS contacts_name,
                        `".$table."`.`firstname` AS contacts_firstname, ";
               break;
            case "glpi_plugin_projet_taskstates.name" :
               return "`".$table."`.`".$field."` AS ITEM_$num, `".$table."`.`id` AS ITEM_".$num."_2, ";
               break;
         }
         return "";
         break;
      
      case 'PluginProjetTaskState':
         switch ($table.".".$field) {
            case "glpi_plugin_projet_taskstates.color" :
               return "`".$table."`.`".$field."` AS ITEM_$num, `".$table."`.`id` AS ITEM_".$num."_2, ";
               break;
         }
         return "";
         break;
   }
   return "";
}

function plugin_projet_addLeftJoin($type,$ref_table,$new_table,$linkfield,&$already_link_tables) {

   switch ($type){
      case 'PluginProjetProjet':
	
         switch ($new_table){

            case "parentid_table" :
               return " LEFT JOIN `glpi_plugin_projet_projets` AS `parentid_table_id` 
                        ON (`parentid_table_id`.`id` = `glpi_plugin_projet_projets`.`plugin_projet_projets_id`) ";
               break;
         }
      
         return "";
         break;
         
      case 'PluginProjetTask':
         switch ($new_table){

            case "parentid_tasktable" :
               return " LEFT JOIN `glpi_plugin_projet_tasks` AS `parentid_tasktable_id` 
                        ON (`parentid_tasktable_id`.`id` = `glpi_plugin_projet_tasks`.`plugin_projet_tasks_id`) ";
               break;
            case "glpi_plugin_projet_projets" : // From items
                  $out= " LEFT JOIN `glpi_plugin_projet_projets` 
                        ON (`$ref_table`.`plugin_projet_projets_id` = `glpi_plugin_projet_projets`.`id`) ";
               return $out;
               break;
            case "glpi_contacts" :
               return " LEFT JOIN `glpi_contacts` ON (`glpi_contacts`.`id` = `$ref_table`.`contacts_id`) ";
               break;
            case "glpi_plugin_projet_taskplannings" :
               return " LEFT JOIN `glpi_plugin_projet_taskplannings` 
                        ON (`glpi_plugin_projet_taskplannings`.`plugin_projet_tasks_id` = `$ref_table`.`id`) ";
               break;
         }
      
         return "";
         break;
	}
	
	return "";
}

function plugin_projet_forceGroupBy($type) {

	return true;
	switch ($type) {
		case 'PluginProjetProjet':
		case 'PluginProjetTask':
			return true;
			break;

	}
	return false;
}

function plugin_projet_displayConfigItem($type,$ID,$data,$num) {
	global $CFG_GLPI, $DB, $LANG;

	$searchopt=&Search::getOptions($type);
	$table=$searchopt[$ID]["table"];
	$field=$searchopt[$ID]["field"];
	
	switch ($type) {
      
		case 'PluginProjetProjet':
         
         switch ($table.'.'.$field) {
            case "glpi_plugin_projet_projetstates.name" :
               return " style=\"background-color:".PluginProjetProjetState::getStatusColor($data["ITEM_".$num."_2"]).";\" ";
               break;
         }
         break;
      
      case 'PluginProjetTask':
         
         switch ($table.'.'.$field) {
            case "glpi_plugin_projet_tasks.priority" :
               return " style=\"background-color:".$_SESSION["glpipriority_".$data["ITEM_$num"]].";\" ";
               break;
            case "glpi_plugin_projet_taskstates.name" :
               return " style=\"background-color:".PluginProjetTaskState::getStatusColor($data["ITEM_".$num."_2"]).";\" ";
               break;
         }
         break;
      
      case 'PluginProjetProjetState':
         
         switch ($table.'.'.$field) {

            case "glpi_plugin_projet_projetstates.color" :
               return " style=\"background-color:".PluginProjetProjetState::getStatusColor($data["ITEM_".$num."_2"]).";\" ";
               break;
         }
         break;
      
      case 'PluginProjetTaskState':
         
         switch ($table.'.'.$field) {

            case "glpi_plugin_projet_taskstates.color" :
               return " style=\"background-color:".PluginProjetTaskState::getStatusColor($data["ITEM_".$num."_2"]).";\" ";
               break;
         }
         break;
      
	}
	return "";
}

function plugin_projet_giveItem($type,$ID,$data,$num) {
	global $CFG_GLPI, $DB, $LANG;

	$searchopt=&Search::getOptions($type);
	$table=$searchopt[$ID]["table"];
	$field=$searchopt[$ID]["field"];
   
   $output_type=HTML_OUTPUT;
   if (isset($_GET['display_type']))
      $output_type=$_GET['display_type'];
      
   switch ($type) {
      
		case 'PluginProjetProjet':
         
         switch ($table.'.'.$field) {
            case "glpi_plugin_projet_projets.name" :
               if (!empty($data["ITEM_".$num."_2"])) {
						$link = getItemTypeFormURL('PluginProjetProjet');
                  $out= "";
                  if ($output_type==HTML_OUTPUT)
                     $out= "<a href=\"".$link."?id=".$data["ITEM_".$num."_2"]."\">";
						$out.= $data["ITEM_$num"];
						if ($output_type==HTML_OUTPUT) {
                     if ($_SESSION["glpiis_ids_visible"]||empty($data["ITEM_$num"])) $out.= " (".$data["ITEM_".$num."_2"].")";
                     $out.= "</a>";
						}
						
						if (plugin_projet_haveRight("task","r") && $output_type==HTML_OUTPUT) {
                     
                     $query_tasks = "SELECT COUNT(`id`) AS nb_tasks,SUM(`plugin_projet_taskstates_id`) AS plugin_projet_taskstates_id
                                 FROM `glpi_plugin_projet_tasks`
                                 WHERE `plugin_projet_projets_id` = '".$data['id']."' ";
                     //select finished tasks
                     $finished = " `for_dependency` = '1' ";
                     $states = getAllDatasFromTable("glpi_plugin_projet_taskstates",$finished);
                     $tab = array();
                     if (!empty($states)) {
                        foreach ($states as $state) {
                           $tab[]= $state['id'];
                        }
                     }
                     if (!empty($tab)) {
                        $query_tasks.= "AND `plugin_projet_taskstates_id` IN (".implode(',',$tab).")";
                     }
                     $query_tasks.= "AND `is_deleted` = '0'";
                     $result_tasks = $DB->query($query_tasks);
                     $nb_tasks=$DB->result($result_tasks, 0, "nb_tasks");
                     $is_finished=$DB->result($result_tasks, 0, "plugin_projet_taskstates_id");
                     $out.= "&nbsp;(<a href=\"".$CFG_GLPI["root_doc"]."/plugins/projet/front/task.php?plugin_projet_projets_id=".$data["id"]."\">";
                     if (($nb_tasks-$is_finished) > 0) {
                        $out.= "<span class='plugin_projet_end_date'>";
                        $out.=$nb_tasks-$is_finished."</span></a>)";
                     } else {
                        $out.= "<span class='plugin_projet_date_ok'>";
                        $out.=$nb_tasks."</span></a>)";
                     }
                     
                  }
					}
               return $out;
               break;
            case "glpi_plugin_projet_projets.date_end" :
               if (!empty($data["ITEM_$num"])) {
                  if ($data["ITEM_$num"] <= date('Y-m-d') && !empty($data["ITEM_$num"])) {
                     $out= "<span class='plugin_projet_end_date'>".convdate($data["ITEM_$num"])."</span>";
                  } else {
                     $out= "<span class='plugin_projet_date_ok'>".convdate($data["ITEM_$num"])."</span>";
                  }
               } else {
                  $out= "--";
               }
               return $out;
               break;
            case "glpi_plugin_projet_projets.advance" :	
               $out= PluginProjetProjet::displayProgressBar('100',$data["ITEM_$num"]);
               return $out;
               break;
            case "glpi_plugin_projet_projets_items.items_id" :
               $restrict = "`plugin_projet_projets_id` = '".$data['id']."' 
                           ORDER BY `itemtype`, `items_id`";
               $items = getAllDatasFromTable("glpi_plugin_projet_projets_items",$restrict);
               $out='';
               if (!empty($items)) {
                  foreach ($items as $device) {
                     if (!class_exists($device["itemtype"])) {
                        continue;
                     }
                     $item=new $device["itemtype"]();
                     $item->getFromDB($device["items_id"]);
                     $out.=$item->getTypeName()." - ";
								if ($device["itemtype"] == 'User') {
                           if ($output_type==HTML_OUTPUT) {
                              $link = getItemTypeFormURL('User');
                              $out.="<a href=\"".$link."?id=".$device["items_id"]."\">";
                           }
                           $out.=getUserName($device["items_id"]);
                           if ($output_type==HTML_OUTPUT)
                              $out.="</a>";
								} else {
									$out.=$item->getLink();
                        }
								$out.="<br>";
                  }
               } else
						$out=' ';
               return $out;
               break;
         }
         return "";
         break;
      case 'PluginProjetTask':
			
			switch ($table.'.'.$field) {
            case "glpi_plugin_projet_tasks.advance" :	
               $out= PluginProjetProjet::displayProgressBar('100',$data["ITEM_$num"]);
               return $out;
               break;
            case "glpi_plugin_projet_tasks.priority" :
               $out= Ticket::getPriorityName($data["ITEM_$num"]);
               return $out;
               break;
            case 'glpi_plugin_projet_tasks.depends':
               $out="";
               if ($data["ITEM_$num"]==1)
                  $out.="<span class='plugin_projet_end_date'>";
               $out.= Dropdown::getYesNo($data["ITEM_$num"]);
               if ($data["ITEM_$num"]==1)
                  $out.="</span>";
               return $out;
               break;
            case "glpi_plugin_projet_tasks.plugin_projet_projets_id" :
               $out=Dropdown::getdropdownname("glpi_plugin_projet_projets",$data["ITEM_$num"]);
               $out.= " (".$data["ITEM_$num"].")";
               return $out;
               break;
            case "glpi_plugin_projet_tasks_items.items_id" :
               $restrict = "`plugin_projet_tasks_id` = '".$data['id']."' 
                           ORDER BY `itemtype`, `items_id`";
               $items = getAllDatasFromTable("glpi_plugin_projet_tasks_items",$restrict);
               $out='';
               if (!empty($items)) {
                  foreach ($items as $device) {
                     $item=new $device["itemtype"]();
                     $item->getFromDB($device["items_id"]);
                     $out.=$item->getTypeName()." - ".$item->getLink()."<br>";
                  }
               }
               return $out;
               break;
            case "glpi_contacts.name" :
               if (!empty($data["ITEM_$num"])) {
                  $link=getItemTypeFormURL('Contact');
                  $out= "<a href=\"".$link."?id=".$data["ITEM_$num"]."\">";
                  $temp=$data["contacts_name"];
                  $firstname=$data["contacts_firstname"];
                  if (strlen($firstname)>0) {
                     if ($CFG_GLPI["names_format"]==FIRSTNAME_BEFORE) {
                        $temp=$firstname." ".$temp;
                     } else {
                        $temp.=" ".$firstname;
                     }
                  }
                  $out.= $temp;
                  if ($_SESSION["glpiis_ids_visible"]||empty($data["ITEM_$num"])) $out.= " (".$data["ITEM_$num"].")";
                  $out.= "</a>";
               } else
                  $out= "";
               return $out;
               break;
            case "glpi_plugin_projet_taskplannings.id" :
               if (!empty($data["ITEM_$num"])) {
                  $plan = new PluginProjetTaskPlanning();
                  $plan->getFromDB($data["ITEM_$num"]);
                  $out=convDateTime($plan->fields["begin"]) . "<br>&nbsp;->&nbsp;" .
                     convDateTime($plan->fields["end"]);
               } else
                  $out= $LANG['job'][32];
               return $out;
               break;
            }
			return "";
         break;
	}
	return "";
}

////// SPECIFIC MODIF MASSIVE FUNCTIONS ///////

function plugin_projet_MassiveActions($type) {
	global $LANG;
	
	switch ($type) {
		case 'PluginProjetProjet':
			return array(
				// Specific one
				"plugin_projet_install"=>$LANG['plugin_projet']['setup'][17],
				"plugin_projet_desinstall"=>$LANG['plugin_projet']['setup'][18],
				"plugin_projet_transfert"=>$LANG['buttons'][48],
				);
         break;
		case 'PluginProjetTask':
			return array(
            //"plugin_projet_task_install"=>$LANG['plugin_projet']['setup'][17],
				//"plugin_projet_task_desinstall"=>$LANG['plugin_projet']['setup'][18],
				"plugin_projet_tasks_transfert"=>$LANG['buttons'][48],
				"plugin_projet_duplicate"=>$LANG['plugin_projet'][15],
				);
         break;
	}

   if (in_array($type, PluginProjetProjet::getTypes())) {
      return array("plugin_projet_add_item"=>$LANG['plugin_projet']['setup'][25]);
   }
   return array();
}

function plugin_projet_MassiveActionsDisplay($options=array()) {
	global $LANG,$CFG_GLPI;

	$PluginProjetProjet=new PluginProjetProjet();
	$PluginProjetTask_Item=new PluginProjetTask_Item();
	
	switch ($options['itemtype']) {
		case 'PluginProjetProjet':
			switch ($options['action']) {
				case "plugin_projet_install":
					Dropdown::showAllItems("item_item",0,0,-1,PluginProjetProjet::getTypes());
					echo "<input type=\"submit\" name=\"massiveaction\" class=\"submit\" value=\"".$LANG['buttons'][2]."\" >";
               break;
				case "plugin_projet_desinstall":
					Dropdown::showAllItems("item_item",0,0,-1,PluginProjetProjet::getTypes());
               echo "<input type=\"submit\" name=\"massiveaction\" class=\"submit\" value=\"".$LANG['buttons'][2]."\" >";
               break;
				case "plugin_projet_transfert":
					Dropdown::show('Entity');
               echo "&nbsp;<input type=\"submit\" name=\"massiveaction\" class=\"submit\" value=\"".$LANG['buttons'][2]."\" >";
               break;
			}
         break;
		case 'PluginProjetTask':
			switch ($options['action']) {
				case "plugin_projet_duplicate":
					echo "&nbsp;<input type=\"submit\" name=\"massiveaction\" class=\"submit\" value=\"".$LANG['buttons'][2]."\" >";
               break;
            case "plugin_projet_tasks_transfert":
					Dropdown::show('Entity');
               echo "&nbsp;<input type=\"submit\" name=\"massiveaction\" class=\"submit\" value=\"".$LANG['buttons'][2]."\" >";
               break;
			}
         break;

	}
	if (in_array($options['itemtype'], PluginProjetProjet::getTypes())) {
      $PluginProjetProjet->dropdownProjet("plugin_projet_projets_id");
      echo "&nbsp;<input type=\"submit\" name=\"massiveaction\" class=\"submit\" value=\"".$LANG['buttons'][2]."\" >";
   }
		
	return "";
}

function plugin_projet_MassiveActionsProcess($data) {
	global $LANG,$DB;
   
   $PluginProjetProjet_Item=new PluginProjetProjet_Item();
   $PluginProjetTask_Item=new PluginProjetTask_Item();
   $PluginProjetTask=new PluginProjetTask();
   
	switch ($data['action']) {
		
		case "plugin_projet_add_item":
         foreach ($data["item"] as $key => $val) {
            if ($val == 1) {
               $input = array('plugin_projet_projets_id' => $data['plugin_projet_projets_id'],
                              'items_id'      => $key,
                              'itemtype'      => $data['itemtype']);
               if ($PluginProjetProjet_Item->can(-1,'w',$input)) {
                  $PluginProjetProjet_Item->add($input);
               }
            }
         }
         break;
      case "plugin_projet_install":
         foreach ($data["item"] as $key => $val) {
            if ($val == 1) {
               $input = array('plugin_projet_projets_id' => $key,
                              'items_id'      => $data["item_item"],
                              'itemtype'      => $data['itemtype']);
               if ($PluginProjetProjet_Item->can(-1,'w',$input)) {
                  $PluginProjetProjet_Item->add($input);
               }
            }
         }
			break;
      case "plugin_projet_desinstall":
         foreach ($data["item"] as $key => $val) {
           if ($val == 1) {
               $PluginProjetProjet_Item->deleteItemByProjetAndItem($key,$data['item_item'],$data['itemtype']);
            }
         }
			break;
      case "plugin_projet_transfert":
         if ($data['itemtype'] == 'PluginProjetProjet') {
				foreach ($data["item"] as $key => $val) {
					if ($val == 1) {

                  $PluginProjetTask = new PluginProjetTask();
                  $restrict = "`plugin_projet_projets_id` = '".$key."'";
                  $tasks = getAllDatasFromTable("glpi_plugin_projet_tasks");
                  if (!empty($tasks)) {
                     foreach ($tasks as $task) {

                        $PluginProjetTask->getFromDB($task["id"]);
                        $tasktype = PluginProjetTaskType::transfer($PluginProjetTask->fields["plugin_projet_tasktypes_id"],
                                                                        $data['entities_id']);
                        if ($tasktype > 0) {
                           $values["id"] = $task["id"];
                           $values["plugin_projet_tasktypes_id"] = $tasktype;
                           $PluginProjetTask->update($values);
                        }
                        $values["id"] = $task["id"];
                        $values["entities_id"] = $data['entities_id'];
                        $PluginProjetTask->update($values);
                     }
                  }
                  
                  unset($values);
                  $PluginProjetProjet = new PluginProjetProjet();
                  $values["id"] = $key;
                  $values["entities_id"] = $data['entities_id'];
                  $PluginProjetProjet->update($values);
					}
				}
			}
			break;
      case "plugin_projet_task_install":
         foreach ($data["item"] as $key => $val) {
            if ($val == 1) {
               $args = explode(",",$data['item_item']);
               $input = array('plugin_projet_tasks_id' => $key,
                              'items_id'      => $args[0],
                              'itemtype'      => $args[1]);
               if ($PluginProjetTask_Item->can(-1,'w',$input)) {
                  $PluginProjetTask_Item->add($input);
               }
            }
         }
			break;
      case "plugin_projet_task_desinstall":
         foreach ($data["item"] as $key => $val) {
           if ($val == 1) {
               $args = explode(",",$data['item_item']);
               $PluginProjetTask_Item->deleteItemByTaskAndItem($key,$args[0],$args[1]);
            }
         }
			break;
      case "plugin_projet_tasks_transfert":
         if ($data['itemtype'] == 'PluginProjetTask') {
				foreach ($data["item"] as $key => $val) {
					if ($val == 1) {
                  $PluginProjetTask = new PluginProjetTask();
                  $PluginProjetTask->getFromDB($key);
                  $tasktype = PluginProjetTaskType::transfer($PluginProjetTask->fields["plugin_projet_tasktypes_id"],
                                                                  $data['entities_id']);
                  if ($tasktype > 0) {
                     $values["id"] = $key;
                     $values["plugin_projet_tasktypes_id"] = $tasktype;
                     $PluginProjetTask->update($values);
                  }

                  unset($values);
                  $values["id"] = $key;
                  $values["entities_id"] = $data['entities_id'];
                  $PluginProjetTask->update($values);
					}
				}
			}
			break;
      case "plugin_projet_duplicate":
         if ($data['itemtype']=='PluginProjetTask') {
            foreach ($data["item"] as $key => $val) {
               if ($val==1) {
                  $PluginProjetTask->getFromDB($key);
                  unset($PluginProjetTask->fields["id"]);
                  $PluginProjetTask->fields["name"]=addslashes($PluginProjetTask->fields["name"]);
						$PluginProjetTask->fields["comment"]=addslashes($PluginProjetTask->fields["comment"]);
						$PluginProjetTask->fields["sub"]=addslashes($PluginProjetTask->fields["sub"]);
						$PluginProjetTask->fields["others"]=addslashes($PluginProjetTask->fields["others"]);
						$PluginProjetTask->fields["affect"]=addslashes($PluginProjetTask->fields["affect"]);
                  $newID=$PluginProjetTask->add($PluginProjetTask->fields);

               }
            }
         }
         break;
	}
}

function plugin_projet_MassiveActionsFieldsDisplay($options=array()) {
	
	$table = $options['options']['table'];
   $field = $options['options']['field'];
   $linkfield = $options['options']['linkfield'];
   if ($table == getTableForItemType($options['itemtype'])) {

      // Table fields
      switch ($table.".".$field) {
			
			case "glpi_plugin_projet_projets.advance":
			case "glpi_plugin_projet_tasks.advance":
				echo "<select name='advance'>";
            for ($i=0;$i<101;$i+=5) {
               echo "<option value='$i'>$i</option>";
            }
            echo "</select> ";
				echo "<input type='hidden' name='field' value='advance'>";
            return true;
            break;
			case "glpi_plugin_projet_tasks.priority":
				Ticket::dropdownPriority($linkfield,$field,false,true);
            return true;
            break;
		}

	}
	// Need to return false on non display item
	return false;
}

// Hook done on purge item case
function plugin_item_purge_projet($item) {
  
   $type = get_class($item);
   $temp = new PluginProjetProjet_Item();
   $temp->deleteByCriteria(array('itemtype' => $type,
                                    'items_id' => $item->getField('id')));
   
   $task = new PluginProjetTask_Item();
   $task->deleteByCriteria(array('itemtype' => $type,
                                    'items_id' => $item->getField('id')));
   return true;

}

function plugin_get_headings_projet($item,$withtemplate) {
	global $LANG;
	
	if (get_class($item)=='Central') {
			return array( 
			1 => $LANG['plugin_projet']['title'][1], 
			); 

	} else if (in_array(get_class($item),PluginProjetProjet::getTypes())||
		get_class($item)=='Profile') {
		// template case
		if ($item->getField('id') && !$withtemplate) {
         return array(
            1 => $LANG['plugin_projet']['title'][1],
            );
		}
	}
	return false;	
}

// Define headings actions added by the plugin	 
function plugin_headings_actions_projet($item) {
   
   if (in_array(get_class($item),PluginProjetProjet::getTypes())||
		get_class($item)=='Profile'||
		get_class($item)=='Central') {
		return array(
         1 => "plugin_headings_projet",
         );
	}
	return false;

}

// action heading
function plugin_headings_projet($item,$withtemplate=0) {
	global $CFG_GLPI,$LANG;
   
   $PluginProjetProjet=new PluginProjetProjet();
   $PluginProjetProjet_Item=new PluginProjetProjet_Item();
   $PluginProjetTask=new PluginProjetTask();
   $PluginProjetProfile=new PluginProjetProfile();
   
		switch (get_class($item)) {
			case 'User' :
				$PluginProjetProjet->showUsers(get_class($item),$item->getField('id'));
				$PluginProjetProjet_Item->showPluginFromItems(get_class($item),$item->getField('id'));
            break;
			case 'Group' :
				$PluginProjetProjet->showUsers(get_class($item),$item->getField('id'));
				$PluginProjetProjet_Item->showPluginFromItems(get_class($item),$item->getField('id'));
            break;
			case "Central":
				$PluginProjetTask->showCentral(getLoginUserID());
            break;
			case 'Profile' :
            if (!$PluginProjetProfile->getFromDBByProfile($item->getField('id')))
               $PluginProjetProfile->createAccess($item->getField('id'));
            $PluginProjetProfile->showForm($item->getField('id'), array('target' => $CFG_GLPI["root_doc"]."/plugins/projet/front/profile.form.php"));
            break;
			default :
				if (in_array(get_class($item), PluginProjetProjet::getTypes())) {
					$PluginProjetProjet_Item->showPluginFromItems(get_class($item),$item->getField('id'));
				}
            break;
		}
}

function plugin_projet_updatev62() {
	global $DB;

	$query= "ALTER TABLE `glpi_plugin_project_profiles` 
			ADD `task` char(1) default NULL;";
	$DB->query($query) or die($DB->error());

	$query= "UPDATE `glpi_plugin_project_profiles` 
			SET `task` = NULL 
			WHERE `ID` = 1 ;";
	$DB->query($query) or die($DB->error());
	
	$query= "UPDATE `glpi_plugin_project_profiles` 
			SET `task` = 'r' 
			WHERE `ID` = 2 ;";
	$DB->query($query) or die($DB->error());
	
	$query= "UPDATE `glpi_plugin_project_profiles` 
			SET `task` = 'w' 
			WHERE `ID` = 3 ;";
	$DB->query($query) or die($DB->error());
	
	$query= "UPDATE `glpi_plugin_project_profiles` 
			SET `task` = 'w' 
			WHERE `ID` = 4 ;";
	$DB->query($query) or die($DB->error());

}

function plugin_projet_updatev7() {
	global $DB,$LANG;
	
	$query="INSERT INTO glpi_doc_device (FK_doc,FK_device,device_type) 
		SELECT FK_documents, FK_project, '2300' 
		FROM glpi_plugin_project_documents;";

	$DB->query($query);
	
	$query="INSERT INTO glpi_plugin_project_items (FK_project,FK_device,device_type) 
		SELECT FK_project, FK_users, '".USER_TYPE."' 
		FROM glpi_plugin_project_users;";
	
	$DB->query($query);
	
	$query="INSERT INTO glpi_plugin_project_items (FK_project,FK_device,device_type) 
			SELECT FK_project, FK_groups, '".GROUP_TYPE."' 
			FROM glpi_plugin_project_FK_groups;";
	
	$DB->query($query);
	
	$query="INSERT INTO glpi_plugin_project_items (FK_project,FK_device,device_type) 
			SELECT FK_project, FK_enterprise, '".ENTERPRISE_TYPE."' 
			FROM glpi_plugin_project_enterprises;";
	
	$DB->query($query);
	
	$query="INSERT INTO glpi_plugin_project_items (FK_project,FK_device,device_type) 
			SELECT FK_project, FK_contracts, '".CONTRACT_TYPE."' 
			FROM glpi_plugin_project_contracts;";
	
	$DB->query($query);

}

// Define PDF informations added by the plugin
function plugin_headings_actionpdf_projet($item) {
  
	if (in_array(get_class($item),PluginProjetProjet::getTypes())) {
      return array(1 => array('PluginProjetProjet_Item', 'PdfFromItems'));
	} else {
		return false;
	}
}

/**
 * Hook : options for one type
 *
 * @param $type of item
 *
 * @return array of string which describe the options
 */
function plugin_projet_prefPDF($item) {
	global $LANG;
   
   $tabs = array();
   switch (get_class($item)) {
      case 'PluginProjetProjet' :
         $item->fields['id'] = 1; // really awfull :(
         $tabs = $item->defineTabs();
         break;
   }
   return $tabs;

}

/**
 * Hook to generate a PDF for a type
 *
 * @param $type of item
 * @param $tab_id array of ID
 * @param $tab of option to be printed
 * @param $page boolean true for landscape
 */
function plugin_projet_generatePDF($options) {

   $item   = $options['item'];
   $tab_id = $options['tab_id'];
   $tab    = $options['tab'];
   $page   = $options['page'];
   
   $PluginProjetProjet=new PluginProjetProjet();
   $PluginProjetProjet_Item=new PluginProjetProjet_Item();
   $PluginProjetTask=new PluginProjetTask();
   $PluginProjetTask_Item=new PluginProjetTask_Item();
   
	$pdf = new PluginPdfSimplePDF('a4', ($page ? 'landscape' : 'portrtait'));

	$nb_id = count($tab_id);

	foreach($tab_id as $key => $ID)	{

		if (plugin_pdf_add_header($pdf,$ID,$item)) {
			$pdf->newPage();
		} else {
			// Object not found or no right to read
			continue;
		}

      switch (get_class($item)) {
         case 'PluginProjetProjet':
            $PluginProjetProjet->mainPdf($pdf,$ID);

            foreach($tab as $i)	{
               switch($i) { // See plugin_applicatif::defineTabs();
                  case 1:
                     //hierarchy
                     $PluginProjetProjet->HierarchyPdf($pdf,$item,1);
                     $PluginProjetProjet->HierarchyPdf($pdf,$item);
                     break;
                  case 3:
                     //GANTT
                     $PluginProjetProjet->GanttPdf($pdf,$ID);
                     break;
                  case 4:
                     $PluginProjetProjet_Item->ItemsPdf($pdf,$item);
                     break;
                  case 5:
                     plugin_pdf_document($pdf,$item);
                     plugin_pdf_contract($pdf,$item);
                     break;
                  case 6:
                     //material
                     $PluginProjetProjet_Item->ItemsPdf($pdf,$item,true);
                     break;
                  case 7:
                     plugin_pdf_ticket($pdf,$item);
                     plugin_pdf_oldTicket($pdf,$item);
                     break;
                  case 8:
                     //tasks
                     $PluginProjetTask->TaskPdf($pdf,$item);
                     break;
                  case 10:
                     plugin_pdf_note($pdf,$item);
                     break;
                  case 12:
                     plugin_pdf_history($pdf,$item);
                     break;
                  default:
                     plugin_pdf_pluginhook($i,$pdf,$item);
               }
            }
            break;
      } // Switch type
	} // Each ID
	$pdf->render();
}


?>