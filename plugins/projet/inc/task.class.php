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
 
if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginProjetTask extends CommonDBTM {
	
	public $itemtype = 'PluginProjetProjet';
   public $items_id = 'plugin_projet_projets_id';
	public $dohistory=true;
   
   static function getTypeName() {
      global $LANG;

      return $LANG['plugin_projet']['title'][3]." ".$LANG['plugin_projet']['title'][3];
   }
   
   function canCreate() {
      return plugin_projet_haveRight('task', 'w');
   }

   function canView() {
      return plugin_projet_haveRight('task', 'r');
   }
   
   function getSearchOptions() {
      global $LANG;

      $tab = array();
    
      $tab['common'] = $LANG['plugin_projet']['title'][3];

      $tab[1]['table']=$this->getTable();
      $tab[1]['field']='name';
      $tab[1]['name']=$LANG['plugin_projet'][22];
      $tab[1]['datatype']='itemlink';
      $tab[1]['itemlink_type'] = $this->getType();
      
      $tab[2]['table']='glpi_users';
      $tab[2]['field']='name';
      $tab[2]['name']=$LANG['common'][34];
      $tab[2]['massiveaction'] = false;
      
      $tab[3]['table']='glpi_groups';
      $tab[3]['field']='name';
      $tab[3]['name']=$LANG['common'][35];
      $tab[3]['massiveaction'] = false;
      
      $tab[4]['table']='glpi_contacts';
      $tab[4]['field']='name';
      $tab[4]['name']=$LANG['financial'][26];
      $tab[4]['massiveaction'] = false;
      
      $tab[5]['table']='glpi_plugin_projet_tasktypes';
      $tab[5]['field']='name';
      $tab[5]['name']=$LANG['plugin_projet'][23];
      
      $tab[6]['table']='glpi_plugin_projet_taskstates';
      $tab[6]['field']='name';
      $tab[6]['name']=$LANG['plugin_projet'][19];
      $tab[6]['massiveaction'] = false;
      
      $tab[7]['table']='glpi_plugin_projet_taskplannings';
      $tab[7]['field']='id';
      $tab[7]['name']=$LANG['job'][35];
      $tab[7]['massiveaction'] = false;
      
      $tab[9]['table']=$this->getTable();
      $tab[9]['field']='advance';
      $tab[9]['name']=$LANG['plugin_projet'][47];
      $tab[9]['datatype']='integer';
      
      $tab[10]['table']=$this->getTable();
      $tab[10]['field']='priority';
      $tab[10]['name']=$LANG['plugin_projet'][41];
      
      $tab[11]['table']=$this->getTable();
      $tab[11]['field']='comment';
      $tab[11]['name']=$LANG['joblist'][6];
      $tab[11]['datatype']='text';
      
      $tab[12]['table']=$this->getTable();
      $tab[12]['field']='sub';
      $tab[12]['name']=$LANG['plugin_projet'][18];
      $tab[12]['datatype']='text';
      
      $tab[13]['table']=$this->getTable();
      $tab[13]['field']='others';
      $tab[13]['name']=$LANG['plugin_projet'][39];
      $tab[13]['datatype']='text';
      
      $tab[14]['table']=$this->getTable();
      $tab[14]['field']='affect';
      $tab[14]['name']=$LANG['plugin_projet'][40];
      $tab[14]['datatype']='text';
      
      $tab[15]['table']='parentid_tasktable';
      $tab[15]['field']='name';
      $tab[15]['linkfield']='id';
      $tab[15]['name']=$LANG['plugin_projet'][58];
      $tab[15]['massiveaction'] = false;
      $tab[15]['joinparams'] = array('jointype' => 'item_item');
      
      $tab[16]['table']=$this->getTable();
      $tab[16]['field']='show_gantt';
      $tab[16]['name']=$LANG['plugin_projet'][64];
      $tab[16]['datatype']='bool';
      
      $tab[18]['table']=$this->getTable();
      $tab[18]['field']='depends';
      $tab[18]['name']=$LANG['plugin_projet'][55];
      $tab[18]['datatype']='bool';
      
      $tab[19]['table']=$this->getTable();
      $tab[19]['field']='realtime';
      $tab[19]['name']=$LANG['plugin_projet'][72];
      $tab[19]['datatype']='realtime';
      $tab[19]['massiveaction'] = false;
      
      $tab[21]['table']='glpi_plugin_projet_tasks_items';
      $tab[21]['field']='items_id';
      $tab[21]['name']=$LANG['plugin_projet'][69];
      $tab[21]['massiveaction'] = false;
      $tab[21]['forcegroupby']  =  true;
      $tab[21]['joinparams']    = array('jointype' => 'child');
      
      $tab[22]['table']='glpi_locations';
      $tab[22]['field']='name';
      $tab[22]['name']=$LANG['common'][15];
      
      $tab[23]['table']='glpi_plugin_projet_projets';
      $tab[23]['field']='id';
      $tab[23]['name']=$LANG['plugin_projet']['title'][1]." ID";
      $tab[23]['massiveaction'] = false;
      
      $tab[24]['table']='glpi_plugin_projet_projets';
      $tab[24]['field']='name';
      $tab[24]['name']=$LANG['plugin_projet']['title'][1];
      $tab[24]['massiveaction'] = false;
      
      $tab[25]['table']=$this->getTable();
      $tab[25]['field']='date_mod';
      $tab[25]['name']=$LANG['common'][26];
      $tab[25]['datatype']='datetime';
      $tab[25]['massiveaction'] = false;
      
      $tab[30]['table']=$this->getTable();
      $tab[30]['field']='id';
      $tab[30]['name']=$LANG['common'][2];
      $tab[30]['massiveaction'] = false;
      
      $tab[80]['table']='glpi_entities';
      $tab[80]['field']='completename';
      $tab[80]['name']=$LANG['entity'][0];
      $tab[80]['linkfield']='entities_id';
      
      return $tab;
   }
	
   /**
   * Clean object veryfing criteria (when a relation is is_deleted)
   *
   * @param $crit array of criteria (should be an index)
   */
   public function clean ($crit) {
      global $DB;
      
      foreach ($DB->request($this->getTable(), $crit) as $data) {
         $this->delete($data);
      }
   }
   
	function cleanDBonPurge() {
		
		$temp = new PluginProjetTask_Item();
		$temp->deleteByCriteria(array('plugin_projet_tasks_id' => $this->fields['id']));
		
		$temp = new PluginProjetTaskPlanning();
		$temp->deleteByCriteria(array('plugin_projet_tasks_id' => $this->fields['id']));
	}
	
   
	function prepareInputForAdd($input) {

      manageBeginAndEndPlanDates($input['plan']);
      
      if (isset($input['plan'])) {
         $input['_plan'] = $input['plan'];
         unset($input['plan']);
      }
      
      if ((isset($input['hour']) && $input["hour"]>0) 
         || (isset($input['minute']) && $input["minute"]>0)) {
         $input["realtime"] = $input["hour"]+$input["minute"]/60;
      }
      
      unset($input["minute"]);
      unset($input["hour"]);
      
      if (!isset($input['plugin_projet_projets_id']) || $input['plugin_projet_projets_id'] <= 0) {
         return false;
      }
		return $input;
	}
	
	function post_addItem() {
      global $CFG_GLPI;
      
      if (isset($this->input["_plan"])) {
         $this->input["_plan"]['plugin_projet_tasks_id'] = $this->fields['id'];
         $pt = new PluginProjetTaskPlanning();

         if (!$pt->add($this->input["_plan"])) {
            return false;
         }
      }
      
      $PluginProjetProjet = new PluginProjetProjet();
      if ($CFG_GLPI["use_mailing"]) {
         $options = array('tasks_id' => $this->fields["id"]);
         if ($PluginProjetProjet->getFromDB($this->fields["plugin_projet_projets_id"])) {
            NotificationEvent::raiseEvent("newtask",$PluginProjetProjet,$options);  
         }
      }
   }
	
	function prepareInputForUpdate($input) {
		global $LANG,$CFG_GLPI;
      
      manageBeginAndEndPlanDates($input['plan']);
      if (isset($input["hour"]) && isset($input["minute"])) {
         $input["realtime"] = $input["hour"]+$input["minute"]/60;
      }
      
      if (isset($input["plan"])) {
         $input["_plan"] = $input["plan"];
         unset($input["plan"]);
      }
	
		$this->getFromDB($input["id"]);
		$input["_old_name"]=$this->fields["name"];
		$input["_old_users_id"]=$this->fields["users_id"];
		$input["_old_groups_id"]=$this->fields["groups_id"];
		$input["_old_contacts_id"]=$this->fields["contacts_id"];
		$input["_old_plugin_projet_tasktypes_id"]=$this->fields["plugin_projet_tasktypes_id"];
		$input["_old_plugin_projet_taskstates_id"]=$this->fields["plugin_projet_taskstates_id"];
		$input["_old_realtime"]=$this->fields["realtime"];
		$input["_old_advance"]=$this->fields["advance"];
		$input["_old_priority"]=$this->fields["priority"];
		$input["_old_comment"]=$this->fields["comment"];
		$input["_old_sub"]=$this->fields["sub"];
		$input["_old_others"]=$this->fields["others"];
		$input["_old_affect"]=$this->fields["affect"];
		$input["_old_plugin_projet_tasks_id"]=$this->fields["plugin_projet_tasks_id"];
		$input["_old_plugin_projet_projets_id"]=$this->fields["plugin_projet_projets_id"];
		$input["_old_depends"]=$this->fields["depends"];
		$input["_old_show_gantt"]=$this->fields["show_gantt"];
		$input["_old_locations_id"]=$this->fields["locations_id"];
      
		return $input;
	}
	
	function post_updateItem($history=1) {
		global $CFG_GLPI,$LANG;
		
		if (isset($this->input["_plan"])) {
         $pt = new PluginProjetTaskPlanning();
         // Update case
         if (isset($this->input["_plan"]["id"])) {
            $this->input["_plan"]['plugin_projet_tasks_id'] = $this->input["id"];

            if (!$pt->update($this->input["_plan"])) {
               return false;
            }
            unset($this->input["_plan"]);
         // Add case
         } else {
            $this->input["_plan"]['plugin_projet_tasks_id'] = $this->input["id"];
            if (!$pt->add($this->input["_plan"])) {
               return false;
            }
            unset($this->input["_plan"]);
         }

      }
		if (!isset($this->input["withtemplate"]) || (isset($this->input["withtemplate"]) && $this->input["withtemplate"]!=1)) {
			if ($CFG_GLPI["use_mailing"]) {
            $options = array('tasks_id' => $this->fields["id"]);
            $PluginProjetProjet = new PluginProjetProjet();
            if ($PluginProjetProjet->getFromDB($this->fields["plugin_projet_projets_id"])) {
               NotificationEvent::raiseEvent("updatetask",$PluginProjetProjet,$options);  
            }
         }
      }
	}
	
	function pre_deleteItem() {
      global $CFG_GLPI;

      if ($CFG_GLPI["use_mailing"] && isset($this->input['delete'])) {
         $PluginProjetProjet = new PluginProjetProjet();
         $options = array('tasks_id' => $this->fields["id"]);
         if ($PluginProjetProjet->getFromDB($this->fields["plugin_projet_projets_id"])) {
            NotificationEvent::raiseEvent("deletetask",$PluginProjetProjet,$options);  
         }
      }
      return true;
   }
	
	//define header form
	function defineTabs($options=array()) {
		global $LANG;
		//principal
		$ong[1]=$LANG['title'][26];
		if ($this->fields['id'] > 0) {
         $ong[12]=$LANG['title'][38];
      }
		return $ong;
	}
	
	function addNewTasks($plugin_projet_projets_id) {
      global $LANG,$CFG_GLPI;
      
      $rand=mt_rand();
      
      $PluginProjetProjet=new PluginProjetProjet();
      $canedit = $PluginProjetProjet->can($plugin_projet_projets_id, 'w');
      if ($this->canCreate() && $canedit) {
      
         echo "<div align='center'>";
         echo "<a class=\"task-button\" href='".$CFG_GLPI["root_doc"]."/plugins/projet/front/task.form.php?plugin_projet_projets_id=".$plugin_projet_projets_id."' >".$LANG['plugin_projet'][11]."</a></div>";
         echo "</div>";
      }
   }
	
   function showForm ($ID, $options=array()) {
      global $CFG_GLPI, $LANG;

      if (!$this->canView()) return false;
      
      $plugin_projet_projets_id = -1;
      if (isset($options['plugin_projet_projets_id'])) {
         $plugin_projet_projets_id = $options['plugin_projet_projets_id'];
      }
      
      $PluginProjetProjet_Item=new PluginProjetProjet_Item();
      
      if ($ID > 0) {
         $this->check($ID,'r');
      } else {
         // Create item
         $input=array('plugin_projet_projets_id'=>$plugin_projet_projets_id);
         $this->check(-1,'w',$input);
      }
      $options["colspan"] = 4;
      $this->showTabs($options);
      $this->showFormHeader($options);
      
      if ($ID > 0) {
         $projet=$this->fields["plugin_projet_projets_id"];
      } else {
         $projet=$plugin_projet_projets_id;
      }
      
      $link = NOT_AVAILABLE;
      $item = new PluginProjetProjet();
      if ($item->getFromDB($projet)){
         $link=$item->getLink();
      }
      
      echo "<input type='hidden' name='plugin_projet_projets_id' value='$projet'>";
      
      echo "<tr class='tab_bg_2'>";
      echo "<td colspan='2'>".$LANG['plugin_projet']['title'][1]."&nbsp;:</td><td colspan='2'>";
      echo $link;
      echo "</td>";
      echo "<td>";
      echo $LANG['plugin_projet'][58].": </td><td>";
      $this->dropdownParent("plugin_projet_tasks_id", $this->fields["plugin_projet_tasks_id"],array('id' => $this->fields["id"],
                                 'plugin_projet_projets_id' => $projet));
      echo "</td>";
      echo "<td>";
      echo $LANG['plugin_projet'][55].": </td><td>";
      Dropdown::showYesNo("depends",$this->fields["depends"]);
      echo "&nbsp;";
      echo " <img alt='' src='".$CFG_GLPI["root_doc"]."/pics/aide.png' onmouseout=\"cleanhide('commentsup')\" onmouseover=\"cleandisplay('commentsup')\">";
      echo "<span class='over_link' id='commentsup'>".nl2br($LANG['plugin_projet'][56])."</span>";
      
      echo "</td>";
      
      echo "</tr>";
   
      $width_left=$width_right="50%";
      $cols=60;
      $rows=4;

      echo "<tr class='tab_bg_1'>";
      echo "<td colspan='2'>";
      echo $LANG['plugin_projet'][22]." : </td><td  colspan='2'>";
      autocompletionTextField($this,"name",array('size' => "30"));
      echo "<td >";
      echo $LANG['plugin_projet'][23].": </td><td>";
      Dropdown::show('PluginProjetTaskType',
                  array('value'  => $this->fields["plugin_projet_tasktypes_id"]));
      echo "</td>";
      echo "<td>";
      echo $LANG['plugin_projet'][19].": </td><td>";
      if ($ID > 0) {
         $this->dropdownState("plugin_projet_taskstates_id",$this->fields["plugin_projet_taskstates_id"],
                           array('depends' => $this->fields["depends"],
                                 'id' => $this->fields["id"],
                                 'plugin_projet_projets_id' => $projet));
      } else {
         Dropdown::show('PluginProjetTaskState',
                  array('value'  => $this->fields["plugin_projet_taskstates_id"]));
      }
      echo "</td>";
      
      echo "</tr>";
      
      echo "<tr class='tab_bg_1'>";
      
      echo "<td colspan='2'>";
      echo $LANG['common'][15].": </td><td  colspan='2'>";
      Dropdown::show('Location',
                  array('value'  => $this->fields["locations_id"]));
      echo "</td>";

      echo "<td>";
      echo $LANG['plugin_projet'][41].": </td><td>";
      Ticket::dropdownPriority("priority",$this->fields["priority"],false,true);
      echo "</td>";
      echo "<td>".$LANG['plugin_projet'][47].": </td><td>";
      $advance=floor($this->fields["advance"]);	
      echo "<select name='advance'>";
      if (empty($ID) || $this->fields["depends"]==0) {
         for ($i=0;$i<101;$i+=5) {
            echo "<option value='$i' ";
            if ($advance==$i) echo "selected";
               echo " >$i</option>";
         }
      } else if ($this->fields["depends"]!=0) {
            for ($i=0;$i<100;$i+=5) {
               echo "<option value='$i' ";
               if ($advance==$i) echo "selected";
                  echo " >$i</option>";
            }
      }
      
      echo "</select> ".$LANG['plugin_projet'][48];
      echo "</td>";			
      echo "</tr>";
      
      
      echo "<tr class='tab_bg_3'>";
      echo "<td colspan='4'>".$LANG['job'][5].": </td>";
      echo "<td colspan='4'>".$LANG['plugin_projet'][24].": </td>";
      echo "</tr>";
      
      echo "<tr class='tab_bg_1'>";
      echo "<td colspan='4' width='$width_left'>";
      echo "<table width='100%'>";
      echo "<tr>";
      echo "<td>".$LANG['common'][34].": </td><td>";
      $this->dropdownItems($this->fields["plugin_projet_projets_id"],"users_id",array(),$this->fields["users_id"],'User');
      echo "</td></tr>";
      echo "<tr><td>".$LANG['common'][35].": </td><td>";
      $this->dropdownItems($this->fields["plugin_projet_projets_id"],"groups_id",array(),$this->fields["groups_id"],'Group');
      echo "</td>";
      echo "</tr>";
      echo "<tr>";
      echo "<td>".$LANG['financial'][26].": </td><td>";
      $this->dropdownItems($this->fields["plugin_projet_projets_id"],"contacts_id",array(),$this->fields["contacts_id"],'Supplier');
      echo "</td>";
      echo "</tr>";
      echo "</table>";
      echo "</td>";	
      
      echo "<td colspan='4' width='$width_right' valign='top'>";	
      echo "<table width='100%'>";
      
      echo "<tr class='tab_bg_1'>";
      echo "<td>".$LANG['plugin_projet'][72]."&nbsp;:</td><td>";
      $hour = floor($this->fields["realtime"]);
      $minute = round(($this->fields["realtime"]-$hour)*60,0);
      Dropdown::showInteger('hour',$hour,0,100);
      echo "&nbsp;".$LANG['job'][21]."&nbsp;&nbsp;";
      Dropdown::showInteger('minute',$minute,0,59);
      echo "&nbsp;".$LANG['job'][22];
      echo "</td></tr>\n";

      echo "<tr class='tab_bg_1'>";
      echo "<td>".$LANG['job'][35]."</td>";
      echo "<td>";
      $plan = new PluginProjetTaskPlanning();
      $plan->showFormForTask($projet, $this);
      echo "</td></tr>";
      
      echo "</table>";
      echo "</td>";
      echo "</tr>";
      
      echo "<tr class='tab_bg_3'>";
      $colspan = '8';
      if (!empty($ID))
         $colspan = '4';
      echo "<td colspan='".$colspan."'>".$LANG['joblist'][6].": </td>";
      if (!empty($ID))
         echo "<td colspan='4'>".$LANG['plugin_projet'][18].": </td>";
      echo "</tr>";
      
      echo "<tr class='tab_bg_1'>";
      echo "<td colspan='".$colspan."' width='$width_left'>";
      echo "<table width='100%'>";
      echo "<tr>";
      echo "<td>";
      echo "<textarea name='comment' class='comment task' cols='$cols' rows='$rows'>".$this->fields["comment"]."</textarea>";
      echo "</td></tr>";
      echo "</table>";
      if (!empty($ID)) {
         echo "</td>";
         echo "<td colspan='4' width='$width_left'>";
         echo "<table width='100%'>";
         echo "<tr>";
         echo "<td>";
         echo "<textarea name='sub'  class='comment task' cols='$cols' rows='$rows'>".$this->fields["sub"]."</textarea>";
         echo "</td>";
         echo "</tr>";
         echo "</table>";
         echo "</td>";
      }
      echo "</tr>";
      
      echo "<tr class='tab_bg_3'>";
      echo "<td colspan='4'>".$LANG['plugin_projet'][39].": </td>";
      echo "<td colspan='4'>".$LANG['plugin_projet'][40].": </td>";
      echo "</tr>";
      
      echo "<tr class='tab_bg_1'>";
      echo "<td colspan='4' width='$width_left'>";
      echo "<table width='100%'>";
      echo "<tr>";
      echo "<td>";
      echo "<textarea name='others' cols='$cols' rows='2'>".$this->fields["others"]."</textarea>";
      echo "</td>";
      echo "</tr>";
      echo "</table>";
      echo "</td>";
      echo "<td colspan='4' width='$width_right' valign='top'>";
      echo "<table width='100%'>";
      echo "<tr>";
      echo "<td>";
      echo "<textarea name='affect' cols='$cols' rows='2'>".$this->fields["affect"]."</textarea>";
      echo "</td>";
      echo "</tr>";
      echo "</table>";
      echo "</td>";
      echo "</tr>";
      
      echo "<tr class='tab_bg_1'><td colspan='4' align='center'>".$LANG['plugin_projet'][64]." : ";
      Dropdown::showYesNo("show_gantt",$this->fields["show_gantt"]);
      echo "</td>";
      echo "<td colspan='4' align='center'>";
      $datestring = $LANG['common'][26].": ";
      $date = convDateTime($this->fields["date_mod"]);
      echo $datestring.$date."</td>";
      echo "</tr>";

		$this->showFormButtons($options);
      $this->addDivForTabs();
      
      return true;	
	}
	
	function findChilds($DB,$projet,$parent) {
    
      $queryBranch='';
      // Recherche les enfants
      $queryChilds= "SELECT `id` 
               FROM `".$this->getTable()."` 
               WHERE `plugin_projet_projets_id` = '$projet' 
               AND `plugin_projet_tasks_id` = '$parent' 
               AND `is_template` = '0' 
               AND `is_deleted` = '0' ";
      if ($resultChilds = $DB->query($queryChilds)) {
         while ($dataChilds = $DB->fetch_array($resultChilds)) {
            $child=$dataChilds["id"];
            $queryBranch .= ",$child";
            // Recherche les petits enfants r?cursivement
            $queryBranch .= $this->findChilds($DB,$projet,$child);
         }
      }
      return $queryBranch;
   }


   //interne a un projet (tache parente)
   function dropdownParent($name, $value=0, $options=array()) {
      global $DB;
      
      echo "<select name='$name'>";
      echo "<option value='0'>".DROPDOWN_EMPTY_VALUE."</option>";
      
      $restrict = " `is_template` = '0' AND `is_deleted` = '0'";
      $restrict.= " AND `plugin_projet_projets_id` = '".$options["plugin_projet_projets_id"]."'";
      if (!empty($options["id"])) {
         $restrict.= " AND `id` != '".$options["id"]."' AND `plugin_projet_tasks_id` NOT IN ('".$options["id"]."' ";
         $restrict.= $this->findChilds($DB,$options["plugin_projet_projets_id"],$options["id"]);
         $restrict.= ") ";
      }
      $restrict.=getEntitiesRestrictRequest(" AND ",$this->getTable(),'','',$this->maybeRecursive()); 
      $restrict.= "ORDER BY `name` ASC ";
      $tasks = getAllDatasFromTable($this->getTable(),$restrict);
      
      if (!empty($tasks)) {
         foreach ($tasks as $task) {
            echo "<option value='".$task["id"]."' ".($value==$task["id"]?" selected ":"").">".$task["name"];
            if (empty($task["name"]) || $_SESSION["glpiis_ids_visible"] == 1 ) { 
               echo " (";
               echo $task["id"].")";
            }
            echo "</option>";
         }
      }
      echo "</select>";	
   }
	
	function dropdownItems($ID,$name,$used=array(),$value=0,$item=false) {
      global $DB,$CFG_GLPI, $LANG;

      $restrict = "`plugin_projet_projets_id` = '$ID'";
      if ($item)
         $restrict.= " AND `itemtype` = '$item'";
      $projets = getAllDatasFromTable("glpi_plugin_projet_projets_items",$restrict);

      echo "<select name='$name'>";
      echo "<option value='0' selected>".DROPDOWN_EMPTY_VALUE."</option>";

      if (!empty($projets)) {

        foreach ($projets as $projet) {
            
            $table = getTableForItemType($projet["itemtype"]);
            
            if ($projet["itemtype"]=='Supplier') {
               $table = getTableForItemType('Contact');
               $class = new Contact();
               $query = "SELECT `".$table."`.* "
               ." FROM `glpi_plugin_projet_projets_items`, `".$table
               ."` LEFT JOIN `glpi_contacts_suppliers` ON (`glpi_contacts_suppliers`.`contacts_id` = `".$table."`.`id`) "
               ." LEFT JOIN `glpi_entities` ON (`glpi_entities`.`id` = `".$table."`.`entities_id`) "
               ." WHERE `glpi_contacts_suppliers`.`suppliers_id` = `glpi_plugin_projet_projets_items`.`items_id` 
               AND `glpi_plugin_projet_projets_items`.`itemtype` = '".$projet["itemtype"]."' 
               AND `glpi_plugin_projet_projets_items`.`items_id` = '".$projet["items_id"]."' "
               . getEntitiesRestrictRequest(" AND ",$table,'','',$class->maybeRecursive()); 
            } else { 
               $query = "SELECT `".$table."`.*
                        FROM `glpi_plugin_projet_projets_items`
                        INNER JOIN `".$table."` ON (`".$table."`.`id` = `glpi_plugin_projet_projets_items`.`items_id`)
                        WHERE `glpi_plugin_projet_projets_items`.`itemtype` = '".$projet["itemtype"]."'
                        AND `glpi_plugin_projet_projets_items`.`items_id` = '".$projet["items_id"]."' ";
            }
            if (count($used)) {
               $query .= " AND `".$table."`.`id` NOT IN (0";
               foreach ($used as $ID)
                  $query .= ",$ID";
               $query .= ")";
            }
            $query .= " GROUP BY `".$table."`.`name`";
            $query .= " ORDER BY `".$table."`.`name`";
            $result_linked=$DB->query($query);

            if ($DB->numrows($result_linked)) {
               
               while ($data=$DB->fetch_assoc($result_linked)) {
                  $name=$data["name"];
                  if ($projet["itemtype"]=='User')
                     $name=getUserName($data["id"]);
                  if ($item=='Supplier' || $projet["itemtype"]=='Supplier') {
                     $temp=$data["name"];
                     $firstname=$data["firstname"];
                     if (strlen($firstname)>0) {
                        if ($CFG_GLPI["names_format"]==FIRSTNAME_BEFORE) {
                           $temp=$firstname." ".$temp;
                        } else {
                           $temp.=" ".$firstname;
                        }
                     }
                     $name=$temp;
                  }
                  if ($item)
                     echo "<option value='".$data["id"]."' ".($value=="".$data["id"].""?" selected ":"").">".$name;
                  else
                     echo "<option value='".$data["id"].",".$projet["itemtype"]."'>".$name;
                  if (empty($data["name"]) || $_SESSION["glpiis_ids_visible"] == 1 ) {
                     echo " (";
                     echo $data["id"].")";
                     }
                  echo "</option>";
               }
            }
         }
      }
      echo "</select>";
   }
   
   /*const PROJET_TASK_STATUS_PROGRESS = 1;
	const PROJET_TASK_STATUS_PLANNED = 2;
	const PROJET_TASK_STATUS_WAITING = 3;
	const PROJET_TASK_STATUS_FINISH = 4;
	const PROJET_TASK_STATUS_ABORT = 5;*/
   
   /**
   * Dropdown of task state
   *
   * @param $name select name
   * @param $value default value
   *
   * @return string id of the select
   */
   function dropdownState($name, $value=0, $options=array()) {
      global $LANG,$DB;
      
      $id = "select_$name".mt_rand();
      echo "<select id='$id' name='$name'>";
      echo "<option value='0'>".DROPDOWN_EMPTY_VALUE."</option>";
      
      $condition= " 1 = 1 ORDER BY `name` ASC";
      $option = getAllDatasFromTable("glpi_plugin_projet_taskstates",$condition);
         
      if ($options["id"]!=0 && $options["depends"]!=0) {
         $restrict = "`id` != '".$options["id"]."' AND `plugin_projet_projets_id` = '".$options["plugin_projet_projets_id"]."'";
         
         $finished = " `for_dependency` = '1' ";
         $states = getAllDatasFromTable("glpi_plugin_projet_taskstates",$finished);
         $tab = array();
         if (!empty($states)) {
            foreach ($states as $state) {
               $tab[]= $state['id'];
            }
         }
         if (!empty($tab)) {
            $restrict.= "AND `plugin_projet_taskstates_id` NOT IN (".implode(',',$tab).")";
         }
         
         $restrict.= " AND `plugin_projet_tasks_id` IN ('".$options["id"]."'";
         $restrict.= $this->findChilds($DB,$options["plugin_projet_projets_id"],$options["id"]);
         $restrict.= ") ";
         $restrict.= "ORDER BY `name` ASC ";
         $tasks = getAllDatasFromTable($this->getTable(),$restrict);
         
         if (!empty($tasks) && !empty($tab)) {
            
            foreach($tab as $t=>$v) {
               unset($option[$v]);
            }
         }
      }
      
      if (!empty($option)) {
         foreach($option as $opt)
         echo "<option value='".$opt["id"]."' ".($value==$opt["id"]?" selected ":"").">".$opt["name"]."</option>";
      }
      echo "</select>";

      return $id;
   }
   
   /**
    * get the task status list
    *
    * @param $withmetaforsearch boolean
    * @return an array
    */
   /*static function getAllStatusArray() {
      global $LANG;

      $tab = array(self::PROJET_TASK_STATUS_PROGRESS   => $LANG['plugin_projet'][20],
                   self::PROJET_TASK_STATUS_PLANNED   => $LANG['plugin_projet'][26],
                   self::PROJET_TASK_STATUS_WAITING   => $LANG['plugin_projet'][53],
                   self::PROJET_TASK_STATUS_FINISH   => $LANG['plugin_projet'][6],
                   self::PROJET_TASK_STATUS_ABORT   => $LANG['plugin_projet'][49]);

      return $tab;
   }*/
   
   /*static function getStatus($value) {
      global $LANG;

      $tab = self::getAllStatusArray();
      if ($value > 0)
         return (isset($tab[$value]) ? $tab[$value] : '');
      else
         return " ";
   }*/
   
   /**
    * Get task status color
    *
    * @param $value status ID
    */
  /* static function getStatusTaskColor($value) {
      
      switch ($value) {
         case self::PROJET_TASK_STATUS_PROGRESS :
            return "#CCCCCC";
            break;
         case self::PROJET_TASK_STATUS_PLANNED :
            return "#FFCC00";
            break;
         case self::PROJET_TASK_STATUS_WAITING :
            return "#FFC65D";
            break;
         case self::PROJET_TASK_STATUS_FINISH :
            return "#A2BB8D";
            break;
         case self::PROJET_TASK_STATUS_ABORT :
            return "#cf9b9b";
            break;
         default :
            return "";
            break;
      }	
   }*/
   
   function taskLegend($id = null) {
      global $LANG, $DB;
      
      echo "<div align='center'><table><tr>";

      $states = getAllDatasFromTable("glpi_plugin_projet_taskstates");
      
      if ($id != null)
      {
          $id = 'id=' + $id + '&';
      }
      else {
          $id = '';
      }
      
      if (!empty($states)) {
          
          $query = "SELECT `glpi_plugin_projet_tasks`.`entities_id`
FROM `glpi_plugin_projet_tasks` LEFT JOIN `glpi_plugin_projet_taskplannings` ON (`glpi_plugin_projet_taskplannings`.`plugin_projet_tasks_id` = `glpi_plugin_projet_tasks`.`id`) LEFT JOIN `glpi_plugin_projet_taskstates` ON (`glpi_plugin_projet_tasks`.`plugin_projet_taskstates_id` = `glpi_plugin_projet_taskstates`.`id` ) 
WHERE `glpi_plugin_projet_tasks`.`plugin_projet_projets_id` = '".$id."' AND `glpi_plugin_projet_tasks`.`is_deleted` = '0'";
          
          $result = $DB->query($query);
          $numrows =  $DB->numrows($result);
          
            echo "<td style='background-color:black;'>"
                    ."<a href='javascript:reloadTab(\"status=-1\")'>".$LANG['buttons'][40]."(".$numrows.")</a></td>";
            foreach ($states as $state) {
          $query = "SELECT `glpi_plugin_projet_tasks`.`entities_id`
FROM `glpi_plugin_projet_tasks` LEFT JOIN `glpi_plugin_projet_taskplannings` ON (`glpi_plugin_projet_taskplannings`.`plugin_projet_tasks_id` = `glpi_plugin_projet_tasks`.`id`) LEFT JOIN `glpi_plugin_projet_taskstates` ON (`glpi_plugin_projet_tasks`.`plugin_projet_taskstates_id` = `glpi_plugin_projet_taskstates`.`id` ) 
WHERE `glpi_plugin_projet_tasks`.`plugin_projet_projets_id` = '".$id."' AND `glpi_plugin_projet_tasks`.`is_deleted` = '0' AND `glpi_plugin_projet_taskstates`.`id` = ".$state['id'];
          
          $result = $DB->query($query);
          $numrows =  $DB->numrows($result);
                
                echo "<td bgcolor=\"".PluginProjetTaskState::getStatusColor($state["id"])."\">"
                    //."<a href='/plugins/projet/front/task.php?is_deleted=0&field%5B0%5D=".$state["id"]."6&searchtype%5B0%5D=equals&contains%5B0%5D=6&itemtype=PluginProjetTask&start=0'>"
                    //."<a href='/projet/front/projet.form.php?".$id."status=".$state["id"]."'>"
                    ."<a href='javascript:reloadTab(\"status=".$state["id"]."\")'>"
                        .$state["name"]." (".$numrows.") </a></td>";
             }
      }
      echo "</tr></table></div>";

   }
   
   //$parents=0 -> childs
   //$parents=1 -> parents
   function showHierarchy($instID,$parents=0) {
      global $DB,$CFG_GLPI, $LANG;
      
      $first=false;
      $query = "SELECT `".$this->gettable()."`.*  ";
      if ($parents!=0)
         $query.= " ,`parent_table`.`name` AS plugin_projet_tasks_id,`parent_table`.`id` AS task_id_id ";
         
      $query.= " FROM `".$this->gettable()."`";
      if ($parents!=0){
         $query.= " LEFT JOIN `".$this->gettable()."` AS parent_table ON (`parent_table`.`plugin_projet_tasks_id` = `".$this->gettable()."`.`id`)";
         $query.= " WHERE `parent_table`.`id` = '$instID' ";
      } else {
         $query.= " WHERE `".$this->gettable()."`.`plugin_projet_tasks_id` = '$instID' ";
      }
      if ($this->maybeTemplate()) {
         $LINK= " AND " ;
         if ($first) {$LINK=" ";$first=false;}
         $query.= $LINK."`".$this->getTable()."`.`is_template` = '0' ";
      }
      // Add is_deleted if item have it
      if ($this->maybeDeleted()) {
         $LINK= " AND " ;
         if ($first) {$LINK=" ";$first=false;}
         $query.= $LINK."`".$this->getTable()."`.`is_deleted` = '0' ";
      }   

      $query.= " ORDER BY `".$this->gettable()."`.`name`";
      
      $result = $DB->query($query);
      $number = $DB->numrows($result);
      $i = 0;
      
      if (isMultiEntitiesMode()) {
         $colsup=1;
      } else {
         $colsup=0;
      }
         
      if ($number !="0") {

         echo "<div align='center'><table class='tab_cadre_fixe'>";
         
         $title = $LANG['plugin_projet'][46];
         if ($parents!=0)
            $title = $LANG['plugin_projet'][58];
         
         echo "<tr><th colspan='".(5+$colsup)."'>".$title."</th></tr>";
         
         echo "<tr><th>".$LANG['plugin_projet'][0]."</th>";
         echo "<th>".$LANG['plugin_projet'][47]."</th>";
         echo "<th>".$LANG['common'][34]."</th>";
         echo "<th>".$LANG['common'][35]."</th>";
         echo "<th>".$LANG['plugin_projet'][19]."</th>";
         echo "<th>".$LANG['job'][35]."</th>";
         echo "</tr>";

         while ($data=$DB->fetch_array($result)) {
            $start = 0;
            $output_type=HTML_OUTPUT;
            $del=false;
            if($data["is_deleted"]=='0')
               echo "<tr class='tab_bg_1'>";
            else
               echo "<tr class='tab_bg_1".($data["is_deleted"]=='1'?"_2":"")."'>";

            echo Search::showItem($output_type,"<a href=\"./task.form.php?id=".$data["id"]."\">".$data["name"].($_SESSION["glpiis_ids_visible"]||empty($data["name"])?' ('.$data["id"].') ':'')."</a>",$item_num,$i-$start+1,'');
            echo Search::showItem($output_type,$data["advance"]." ".$LANG['plugin_projet'][48],$item_num,$i-$start+1,"align='center'");
            echo Search::showItem($output_type,getUserName($data['users_id']),$item_num,$i-$start+1,'');
            echo Search::showItem($output_type,Dropdown::getDropdownName("glpi_groups",$data['groups_id']),$item_num,$i-$start+1,'');
            echo Search::showItem($output_type,Dropdown::getDropdownName("glpi_plugin_projet_taskstates",$data['plugin_projet_taskstates_id']),$item_num,$i-$start+1,"bgcolor='".PluginProjetTaskState::getStatusColor($data['plugin_projet_taskstates_id'])."' align='center'");
            
            $restrict = " `plugin_projet_tasks_id` = '".$data['id']."' ";
            $plans = getAllDatasFromTable("glpi_plugin_projet_taskplannings",$restrict);
            
            if (!empty($plans)) {
               foreach ($plans as $plan) {
                  $display = convDateTime($plan["begin"]) . "&nbsp;->&nbsp;" .
                  convDateTime($plan["end"]);
               }
            } else {
               $display = $LANG['job'][32];
            }
            echo Search::showItem($output_type,$display,$item_num,$i-$start+1,"align='center'");
               
            echo "</tr>";
         }
         echo "</table></div><br>";
      }
   }
   
   function showCentral($who) {
      global $DB,$CFG_GLPI, $LANG;

      echo "<table class='tab_cadre_central'><tr><td>";
      
      if ($this->canView()) {
         $who=getLoginUserID();
         
         if (isMultiEntitiesMode()) {
            $colsup=1;
         } else {
            $colsup=0;
         }
            
         $ASSIGN="";
         if ($who>0) {
            $ASSIGN=" AND ((`".$this->getTable()."`.`users_id` = '$who')";
         }
         //if ($who_group>0) {
         $ASSIGN.=" OR (`".$this->getTable()."`.`groups_id` IN (SELECT `groups_id` 
                                                      FROM `glpi_groups_users` 
                                                      WHERE `users_id` = '$who') )";
         //}
         $query = "SELECT `".$this->getTable()."`.`id` AS plugin_projet_tasks_id, `".$this->getTable()."`.`name` AS name_task, `".$this->getTable()."`.`plugin_projet_tasktypes_id`,`".$this->getTable()."`.`is_deleted`, ";
         $query.= "`".$this->getTable()."`.`users_id` AS users_id_task, `glpi_plugin_projet_projets`.`id`, `glpi_plugin_projet_projets`.`name`, `glpi_plugin_projet_projets`.`entities_id`, `glpi_plugin_projet_projets`.`plugin_projet_projetstates_id`, `glpi_plugin_projet_projets`.`users_id` ";
         $query.= " FROM `".$this->getTable()."`,`glpi_plugin_projet_projets` ";
         $query.= " WHERE `".$this->getTable()."`.`plugin_projet_projets_id` = `glpi_plugin_projet_projets`.`id` ";
         //not show finished tasks
         $finished = " `for_dependency` = '1' ";
         $states = getAllDatasFromTable("glpi_plugin_projet_taskstates",$finished);
         $tab = array();
         if (!empty($states)) {
            foreach ($states as $state) {
               $tab[]= $state['id'];
            }
         }
         if (!empty($tab)) {
            $query.= "AND `plugin_projet_taskstates_id` NOT IN (".implode(',',$tab).")";
         }
         $query.= " $ASSIGN ) 
               AND `glpi_plugin_projet_projets`.`is_template` = '0' 
               AND `".$this->getTable()."`.`is_deleted` = '0' 
               AND `glpi_plugin_projet_projets`.`is_deleted` = '0'";
         $PluginProjetProjet = new PluginProjetProjet();
         $itemtable = "glpi_plugin_projet_projets";
         if ($PluginProjetProjet->isEntityAssign()) {
            $LINK= " AND " ;
            $query.=getEntitiesRestrictRequest($LINK,$itemtable);
         }

         $query .= "  ORDER BY `glpi_plugin_projet_projets`.`name` DESC LIMIT 10;";
         $result = $DB->query($query);
         $number = $DB->numrows($result);
         
         echo "<table class='tab_cadre_central'><tr><td>";
         
         if ($number > 0) {
            
            initNavigateListItems($this->getType());
                                  
            echo "<div align='center'>";

            echo "<table class='tab_cadre' style='text-align:center' width='100%'>";
            echo "<tr><th colspan='".(7+$colsup)."'>".$LANG['plugin_projet']['title'][1]." : ".$LANG['plugin_projet'][12]." <a href='".$CFG_GLPI["root_doc"]."/plugins/projet/front/task.php'>".$LANG['plugin_projet'][74]."</a></th></tr>";
            
            echo "<tr><th>".$LANG['plugin_projet'][30]."</th>";
            if (isMultiEntitiesMode())
               echo "<th>".$LANG['entity'][0]."</th>";
            echo "<th>".$LANG['plugin_projet'][23]."</th>";
            echo "<th>".$LANG['job'][35]."</th>";
            echo "<th>".$LANG['plugin_projet'][29]."</th>";
            echo "<th>".$LANG['plugin_projet'][19]."</th>";
            echo "<th>".$LANG['plugin_projet'][9]."</th>";
            echo "<th>".$LANG['common'][34]."</th>";
            
            echo "</tr>";

            while ($data=$DB->fetch_array($result)) {
               
               addToNavigateListItems($this->getType(),$data['plugin_projet_tasks_id']);
               
               echo "<tr class='tab_bg_1".($data["is_deleted"]=='1'?"_2":"")."'>";
               echo "<td align='center'><a href='".$CFG_GLPI["root_doc"]."/plugins/projet/front/task.form.php?id=".$data["plugin_projet_tasks_id"]."'>".$data["name_task"];
               if ($_SESSION["glpiis_ids_visible"]) echo " (".$data["plugin_projet_tasks_id"].")";
               echo "</a></td>";
               
               if (isMultiEntitiesMode())
                  echo "<td class='center'>".Dropdown::getDropdownName("glpi_entities",$data['entities_id'])."</td>";		
               echo "<td align='center'>".Dropdown::getDropdownName("glpi_plugin_projet_tasktypes",$data["plugin_projet_tasktypes_id"])."</td>";
               echo "<td align='center'>";
               $restrict = " `plugin_projet_tasks_id` = '".$data['plugin_projet_tasks_id']."' ";
               $plans = getAllDatasFromTable("glpi_plugin_projet_taskplannings",$restrict);
               
               if (!empty($plans)) {
                  foreach ($plans as $plan) {
                     echo convDateTime($plan["begin"]) . "&nbsp;->&nbsp;" .
                     convDateTime($plan["end"]);
                  }
               } else {
                  echo $LANG['job'][32];
               }
               echo "</td>";
               echo "<td align='center'><a href='".$CFG_GLPI["root_doc"]."/plugins/projet/front/projet.form.php?id=".$data["id"]."'>".$data["name"];
               if ($_SESSION["glpiis_ids_visible"]) echo " (".$data["id"].")";
               echo "</a></td>";
               echo "<td align='center'>".Dropdown::getDropdownName("glpi_plugin_projet_projetstates",$data['plugin_projet_projetstates_id'])."</td>";
               
               echo "<td align='center'>".getUserName($data["users_id"])."</td>";
               
               echo "<td align='center'>".getUserName($data["users_id_task"])."</td>";
                        
               echo "</tr>";

            }
            echo "</table>";
            echo "</div>";
         }
         
         echo "</td></tr></table>";
      }
      
      echo "</td></tr></table>";
   }

	static function showTaskTreeGantt($options=array()) {
      
      $restrict = " `plugin_projet_projets_id` = '".$options["plugin_projet_projets_id"]."' ";
      $restrict.= " AND `is_deleted` = '0'";
      $restrict.= " AND `is_template` = '0'";
      $restrict.= " AND `show_gantt` = '1'";
      //Only Parent
      $restrict.= " AND `plugin_projet_tasks_id` = '0'";
      $restrict.= " ORDER BY `plugin_projet_taskstates_id` DESC";
      
      $tasks = getAllDatasFromTable("glpi_plugin_projet_tasks",$restrict);
      
      if (!empty($tasks)) {
         foreach ($tasks as $task) {
            $params=array('plugin_projet_projets_id'=>$options["plugin_projet_projets_id"],
                           'plugin_projet_tasks_id'=>$task["id"],
                           'prefix'=>'');
            self::showTaskGantt($params);
         }
      }
   }

   static function showTaskGantt($options=array()) {
      global $gdata;    
      
      
      $restrict = " `plugin_projet_projets_id` = '".$options["plugin_projet_projets_id"]."' ";
      if ($options["plugin_projet_tasks_id"])
         $restrict.= " AND `id` = '".$options["plugin_projet_tasks_id"]."' ";
      $restrict.= " AND `is_deleted` = '0'";
      $restrict.= " AND `is_template` = '0'";
      $restrict.= " AND `show_gantt` = '1'";
      $restrict.= " ORDER BY `plugin_projet_taskstates_id` DESC";
      
      $tasks = getAllDatasFromTable("glpi_plugin_projet_tasks",$restrict);
      
      $prefix = $options["prefix"];
      
      if (!empty($tasks)) {
         foreach ($tasks as $task) {
         
            $prefix.= "-";

            //nom
            $gantt_t_name= $prefix." ".$task["name"];
            //color
            $int = hexdec(PluginProjetTaskState::getStatusColor($task["plugin_projet_taskstates_id"]));
            $gantt_t_bgcolor = array(0xFF & ($int >> 0x10), 0xFF & ($int >> 0x8), 0xFF & $int);
            
            $gantt_t_date_begin=date("Y-m-d");
            $gantt_t_date_end=date("Y-m-d");
            $plan = new PluginProjetTaskPlanning();
            $plan->getFromDBbyTask($task["id"]);
            
            if (!empty($plan->fields["begin"])) {
               $gantt_t_date_begin=$plan->fields["begin"];
            }
            if (!empty($plan->fields["end"])) {
               $gantt_t_date_end=$plan->fields["end"];
            }
            
            $gdata[]=array("type"=>'phase',
                           "task"=>$task["id"],
                           "projet"=>$options["plugin_projet_projets_id"],
                           "name"=>$gantt_t_name,
                           "begin"=>$gantt_t_date_begin,
                           "end"=>$gantt_t_date_end,
                           "advance"=>$task["advance"],
                           "bg_color"=>$gantt_t_bgcolor,
                           );
                           
           if ($task["depends"]==1) {
               $gdata[]=array("type"=>'dependency',
                                       "projet"=>$options["plugin_projet_projets_id"],
                                       "name"=>$gantt_t_name,
                                       "date_begin"=>$gantt_t_date_begin);
            }
            
            $restrictchild = " `plugin_projet_tasks_id` = '".$task["id"]."' ";
            $restrictchild.= " AND `id` != '".$task["id"]."'";
            $restrictchild.= " AND `plugin_projet_projets_id` = '".$options["plugin_projet_projets_id"]."'";
            $restrictchild.= " AND `is_deleted` = '0'";
            $restrictchild.= " AND `is_template` = '0'";
            $restrictchild.= " AND `show_gantt` = '1'";
            $restrictchild.= " ORDER BY `plugin_projet_taskstates_id` DESC";

            $childs = getAllDatasFromTable("glpi_plugin_projet_tasks",$restrictchild);
            
            if (!empty($childs)) {
               foreach ($childs as $child) {
                  $params=array('plugin_projet_projets_id'=>$options["plugin_projet_projets_id"],
                                 'plugin_projet_tasks_id'=>$child["id"],
                                 'parent'=>$task["plugin_projet_tasks_id"],
                                 'prefix'=>$prefix);
                  self::showTaskGantt($params);
               }
            }
         }
      }        
   }
   
   function showMinimalList($params) {
      global $DB,$CFG_GLPI,$LANG;
      
      $itemtype = $this->getType();
      $itemtable = $this->getTable();
      $searchopt=array();
      $searchopt=$this->getSearchOptions();
      
      // Default values of parameters
      $p['link']        = array();//
      $p['field']       = array();//
      $p['contains']    = array();//
      $p['searchtype']  = array();//
      $p['sort']        = null; //
      $p['order']       = 'ASC';//
      $p['start']       = 0;//
      $p['is_deleted']  = 0;
      $p['id']  = 0;
      $p['export_all']  = 0;
      $p['link2']       = '';//
      $p['contains2']   = '';//
      $p['field2']      = '';//
      $p['itemtype2']   = '';
      $p['searchtype2']  = '';
      $p['status'] = null;
      
      foreach ($params as $key => $val) {
            $p[$key]=$val;
      }

      if ($p['export_all']) {
         $p['start']=0;
      }
      
      $PluginProjetProjet = new PluginProjetProjet();
      $PluginProjetProjet->getFromDB($p['id']);
      $canedit = $PluginProjetProjet->can($p['id'], 'w');
      
      // Manage defautll seachtype value : for bookmark compatibility
      if (count($p['contains'])) {
         foreach ($p['contains'] as $key => $val) {
            if (!isset($p['searchtype'][$key])) {
               $p['searchtype'][$key]='contains';
            }
         }
      }
      if (is_array($p['contains2']) && count($p['contains2'])) {
         foreach ($p['contains2'] as $key => $val) {
            if (!isset($p['searchtype2'][$key])) {
               $p['searchtype2'][$key]='contains';
            }
         }
      }

      $target= getItemTypeSearchURL($itemtype);

      $limitsearchopt=Search::getCleanedOptions($itemtype);
      
      $LIST_LIMIT=$_SESSION['glpilist_limit'];
      
      // Set display type for export if define
      $output_type=HTML_OUTPUT;
      if (isset($_GET['display_type'])) {
         $output_type=$_GET['display_type'];
         // Limit to 10 element
         if ($_GET['display_type']==GLOBAL_SEARCH) {
            $LIST_LIMIT=GLOBAL_SEARCH_DISPLAY_COUNT;
         }
      }
      
      $entity_restrict = $this->isEntityAssign();
      
      // Get the items to display
      $toview=Search::addDefaultToView($itemtype);
      
      // Add items to display depending of personal prefs
      $displaypref=DisplayPreference::getForTypeUser($itemtype,getLoginUserID());
      if (count($displaypref)) {
         foreach ($displaypref as $val) {
            array_push($toview,$val);
         }
      }
      
      // Add searched items
      if (count($p['field'])>0) {
         foreach($p['field'] as $key => $val) {
            if (!in_array($val,$toview) && $val!='all' && $val!='view') {
               array_push($toview,$val);
            }
         }
      }

      // Add order item
      if (!in_array($p['sort'],$toview)) {
         array_push($toview,$p['sort']);
      }
      
      // Clean toview array
      $toview=array_unique($toview);
      foreach ($toview as $key => $val) {
         if (!isset($limitsearchopt[$val])) {
            unset($toview[$key]);
         }
      }

      $toview_count=count($toview);
      
      //// 1 - SELECT
      $query = "SELECT ".Search::addDefaultSelect($itemtype);

      // Add select for all toview item
      foreach ($toview as $key => $val) {
         $query.= Search::addSelect($itemtype,$val,$key,0);
      }
      
      $query .= "`".$itemtable."`.`id` AS id ";
      
      //// 2 - FROM AND LEFT JOIN
      // Set reference table
      $query.= " FROM `".$itemtable."`";

      // Init already linked tables array in order not to link a table several times
      $already_link_tables=array();
      // Put reference table
      array_push($already_link_tables,$itemtable);

      // Add default join
      $COMMONLEFTJOIN = Search::addDefaultJoin($itemtype,$itemtable,$already_link_tables);
      $query .= $COMMONLEFTJOIN;

      $searchopt=array();
      $searchopt[$itemtype]=&Search::getOptions($itemtype);
      // Add all table for toview items
      foreach ($toview as $key => $val) {
         $query .= Search::addLeftJoin($itemtype, $itemtable, $already_link_tables,
                                    $searchopt[$itemtype][$val]["table"],
                                    $searchopt[$itemtype][$val]["linkfield"], 0, 0,
                                    $searchopt[$itemtype][$val]["joinparams"]);
      }

      // Search all case :
      if (in_array("all",$p['field'])) {
         foreach ($searchopt[$itemtype] as $key => $val) {
            // Do not search on Group Name
            if (is_array($val)) {
               $query .= Search::addLeftJoin($itemtype, $itemtable, $already_link_tables,
                                          $searchopt[$itemtype][$key]["table"],
                                          $searchopt[$itemtype][$key]["linkfield"], 0, 0,
                                          $searchopt[$itemtype][$key]["joinparams"]);
            }
         }
      }
      
      $query.= " WHERE `".$itemtable."`.`plugin_projet_projets_id` = '".$p['id']."'";
      $query.= " AND `".$itemtable."`.`is_deleted` = '".$p['is_deleted']."' ";
      
      //echo $p['status'].'|||';
      if (isset($p['status']) && $p['status'] != -1)
      {
          $query.= " AND `glpi_plugin_projet_taskstates`.`id` = ".$p["status"]." ";
      }
      else
      {
          $query.= " AND `glpi_plugin_projet_taskstates`.`id` <> 5 ";
      }
      
      //// 7 - Manage GROUP BY
      $GROUPBY = "";
      // Meta Search / Search All / Count tickets
      if (in_array('all',$p['field'])) {
         $GROUPBY = " GROUP BY `".$itemtable."`.`id`";
      }

      if (empty($GROUPBY)) {
         foreach ($toview as $key2 => $val2) {
            if (!empty($GROUPBY)) {
               break;
            }
            if (isset($searchopt[$itemtype][$val2]["forcegroupby"])) {
               $GROUPBY = " GROUP BY `".$itemtable."`.`id`";
            }
         }
      }
      $query.=$GROUPBY;
      //// 4 - ORDER
      //$ORDER=" ORDER BY `id` ";
      //echo $p['sort'].'-'.$p['status'];
      if ($p['sort'] != null) {
          foreach($toview as $key => $val) {
            if ($p['sort']==$val) {
               $ORDER= Search::addOrderBy($itemtype,$p['sort'],$p['order'],$key);
            }
         }
      }
      else
      {
          $ORDER=" ORDER BY `date_mod` DESC";
      }
        
      //$ORDER=" ORDER BY `date_mod` DESC";
      $query.=$ORDER;
      //echo $query;

      // Get it from database	
      
      if ($result = $DB->query($query)) {
         $numrows =  $DB->numrows($result);
         
         $globallinkto = Search::getArrayUrlLink("field",$p['field']).
                        Search::getArrayUrlLink("link",$p['link']).
                        Search::getArrayUrlLink("contains",$p['contains']).
                        Search::getArrayUrlLink("field2",$p['field2']).
                        Search::getArrayUrlLink("contains2",$p['contains2']).
                        Search::getArrayUrlLink("itemtype2",$p['itemtype2']).
                        Search::getArrayUrlLink("link2",$p['link2']);

         $parameters = "sort=".$p['sort']."&amp;order=".$p['order'].$globallinkto;
         
         if ($output_type==GLOBAL_SEARCH) {
            if (class_exists($itemtype)) {
               echo "<div class='center'><h2>".$this->getTypeName();
               // More items
               if ($numrows>$p['start']+GLOBAL_SEARCH_DISPLAY_COUNT) {
                  echo " <a href='$target?$parameters'>".$LANG['common'][66]."</a>";
               }
               echo "</h2></div>\n";
            } else {
               return false;
            }
         }
           
         if ($p['start']<$numrows) {
            
            if ($output_type==HTML_OUTPUT && !$p['withtemplate']) {
               echo "<div align='center'>";
               echo "<a href='".$CFG_GLPI["root_doc"]."/plugins/projet/front/task.php?contains%5B0%5D=".
               $p['id']."&field%5B0%5D=23&sort=1&is_deleted=0&start=0'>".$LANG['buttons'][0]."</a><br>";
               echo "</div>";
            }
           
            // Pager
            if ($output_type==HTML_OUTPUT) {
               printAjaxPager("",$p['start'],$numrows);
               echo "<br>";
            }
           
            //massive action
            $sel="";
            if (isset($_GET["select"])&&$_GET["select"]=="all") $sel="checked";

            if ($this->canCreate() && $canedit && $output_type==HTML_OUTPUT && $p['withtemplate']!=2) {
               echo "<form method='post' name='massiveaction_form' id='massiveaction_form' action=\"../ajax/massiveactionTask.php\">";
            }
            
            $this->taskLegend($p['id']);

            // Add toview elements
            $nbcols=$toview_count;

            if ($output_type==HTML_OUTPUT) { // HTML display - massive modif
               $nbcols++;
            }

            // Define begin and end var for loop
            // Search case
            $begin_display=$p['start'];
            $end_display=$p['start']+$LIST_LIMIT;

            // Export All case
            if ($p['export_all']) {
               $begin_display=0;
               $end_display=$numrows;
            }

            // Display List Header
            echo Search::showHeader($output_type,$end_display-$begin_display+1,$nbcols,1);
            
            $header_num=1;
            // Display column Headers for toview items
            echo Search::showNewLine($output_type);
            
            if ($output_type==HTML_OUTPUT) { // HTML display - massive modif
               $search_config="";
               if ($this->canCreate() && $canedit) {
                  $tmp = " class='pointer' onClick=\"var w = window.open('".$CFG_GLPI["root_doc"].
                        "/front/popup.php?popup=search_config&amp;itemtype=".$itemtype."' ,'glpipopup', ".
                        "'height=400, width=1000, top=100, left=100, scrollbars=yes' ); w.focus();\"";

                  $search_config = "<img alt='".$LANG['setup'][252]."' title='".$LANG['setup'][252].
                                    "' src='".$CFG_GLPI["root_doc"]."/pics/options_search.png' ";
                  $search_config .= $tmp.">";
               }
               echo Search::showHeaderItem($output_type,$search_config,$header_num,"",0,$p['order']);
            }
           
            // Display column Headers for toview items
            foreach ($toview as $key => $val) {
                if ($val == 9)
                    continue;
                
               $linkto='';
               if (!isset($searchopt[$itemtype][$val]['nosort'])
                     || !$searchopt[$itemtype][$val]['nosort']) {
                  $linkto = "javascript:reloadTab('sort=".$val."&amp;order=".($p['order']=="ASC"?"DESC":"ASC").
                           "&amp;start=".$p['start'].$globallinkto.
                           "&amp;status=5')";
               }
               echo Search::showHeaderItem($output_type,$searchopt[$itemtype][$val]["name"],
                                          $header_num,$linkto,$p['sort']==$val,$p['order']);
            }
            
            // End Line for column headers		
            echo Search::showEndLine($output_type);

            $DB->data_seek($result,$p['start']);
           
            // Define begin and end var for loop
            // Search case
            $i=$begin_display;

            // Init list of items displayed
            if ($output_type==HTML_OUTPUT) {
               initNavigateListItems($itemtype, $LANG['plugin_projet']['title'][1]." = ".
                                  (empty($PluginProjetProjet->fields['name']) ? "(".$p['id'].")" : $PluginProjetProjet->fields['name']));
            }

            // Num of the row (1=header_line)
            $row_num=1;
            // Display Loop
            while ($i < $numrows && $i<($end_display)) {
               
               $item_num=1;
               $data=$DB->fetch_array($result);
               $i++;
               $row_num++;
               
               echo Search::showNewLine($output_type,($i%2));
               
               addToNavigateListItems($itemtype,$data['id']);

               if ($this->canCreate() && $canedit && $output_type==HTML_OUTPUT && $p['withtemplate']!=2) {
                  $sel="";
                  $tmpcheck="<input type='checkbox' name='item[".$data["id"]."]' value='1' $sel>";
                  echo Search::showItem($output_type,$tmpcheck,$item_num,$row_num,"width='10'");
               }
               
               //$description_length_max = 30;
               foreach ($toview as $key => $val) {
                  if ($val == 9)
                    continue;
                  $item = Search::giveItem($itemtype,$val,$data,$key);
                  /*
                  if ($itemtype == 'PluginProjetTask' && $key == 3)
                  {
                      if (utf8_strlen($item) > $description_length_max) {
                          $item = utf8_substr($item, 0, $description_length_max) + '...';
                      }
                  }
                   * 
                   */
                  
                  echo Search::showItem($output_type,$item,$item_num,
                                       $row_num,
                           Search::displayConfigItem($itemtype,$val,$data,$key));
               }
           
               echo Search::showEndLine($output_type);
            }
            // Close Table
            $title="";
            // Create title
            if ($output_type==PDF_OUTPUT_PORTRAIT|| $output_type==PDF_OUTPUT_LANDSCAPE) {
               $title.=$LANG['plugin_projet'][55];
            }
           
            // Display footer
            echo Search::showFooter($output_type,$title);
           
            //massive action
            if ($this->canCreate() && $canedit && $output_type==HTML_OUTPUT && $p['withtemplate']!=2) {
               openArrowMassive("massiveaction_form",true);
               $this->dropdownMassiveAction($data["id"],$p['is_deleted'],$p['id']);
               closeArrowMassive();

               // End form for delete item
               echo "</form>\n";
            }

            // Pager
            if ($output_type==HTML_OUTPUT) {
               echo "<br>";			
               printPager($p['start'],$numrows,$target,$parameters);
            }
         } else {
            echo Search::showError($output_type);
         }
      }
   }
   
   function dropdownMassiveAction($ID,$is_deleted,$plugin_projet_projets_id) {
      global $LANG,$CFG_GLPI;

      echo "<select name=\"massiveaction\" id='massiveaction'>";
      echo "<option value=\"-1\" selected>".DROPDOWN_EMPTY_VALUE."</option>";
      if ($is_deleted==1) {
         if ($this->canCreate()) {
            echo "<option value=\"purge\">".$LANG['buttons'][22]."</option>";
            echo "<option value=\"restore\">".$LANG['buttons'][21]."</option>";
         }
      } else {
         if ($this->canCreate()) {
            echo "<option value=\"update\">".$LANG['buttons'][14]."</option>";
            echo "<option value=\"install\">".$LANG['plugin_projet']['setup'][17]."</option>";
            echo "<option value=\"desinstall\">".$LANG['plugin_projet']['setup'][18]."</option>";
            echo "<option value=\"duplicate\">".$LANG['plugin_projet'][15]."</option>";
            echo "<option value=\"delete\">".$LANG['buttons'][6]."</option>";
         }
      }
      echo "</select>";

      $params=array('action'=>'__VALUE__',
         'itemtype' => $this->getType(),
        'is_deleted'=>$is_deleted,
        'plugin_projet_projets_id'=>$plugin_projet_projets_id,
        'id'=>$ID,
        );
    
      ajaxUpdateItemOnSelectEvent("massiveaction","show_massiveaction",$CFG_GLPI["root_doc"]."/plugins/projet/ajax/dropdownMassiveActionTask.php",$params);
    
      echo "<span id='show_massiveaction'>&nbsp;</span>\n";
   }
   
   /**
    * Show for PDF an projet - Hierarchy
    * 
    * @param $pdf object for the output
    * @param $ID of the projet
    */
   function TaskPdf($pdf, $item) {
      global $DB,$CFG_GLPI, $LANG;
      
      $ID = $item->getField('id');
      
      if (!$this->canView())	return false;

      $PluginProjetProjet=new PluginProjetProjet();
      if (!$PluginProjetProjet->getFromDB($ID)) return false;

      $pdf->setColumnsSize(100);
      
      $pdf->displayTitle('<b>'.$LANG['plugin_projet']['mailing'][16].'</b>');

      $first=false;
      $query = "SELECT *  ";
      $query.= " FROM `".$this->gettable()."`";
      $query.= " WHERE `plugin_projet_projets_id` = '$ID' ";
      if ($this->maybeTemplate()) {
         $LINK= " AND " ;
         if ($first) {$LINK=" ";$first=false;}
         $query.= $LINK."`is_template` = '0' ";
      }
      // Add is_deleted if item have it
      if ($this->maybeDeleted()) {
         $LINK= " AND " ;
         if ($first) {$LINK=" ";$first=false;}
         $query.= $LINK."`is_deleted` = '0' ";
      }   
      $LINK= " AND " ;    
      $query.=getEntitiesRestrictRequest(" AND ",$this->gettable(),'','',$this->maybeRecursive());
            
      $query.= " ORDER BY `name`";
      $result = $DB->query($query);
      $number = $DB->numrows($result);
      
      if (!$number) {
         $pdf->displayLine($LANG['search'][15]);						
      } else {
         if (isMultiEntitiesMode()) {
            $pdf->setColumnsSize(17,17,17,17,16,16);
            $pdf->displayTitle(
               '<b><i>'.$LANG['plugin_projet'][0],
               $LANG['entity'][0],
               $LANG['plugin_projet'][47],
               $LANG['plugin_projet'][19],
               $LANG['job'][35]
               .'</i></b>'
               );
         } else {
            $pdf->setColumnsSize(20,17,17,17,17);
            $pdf->displayTitle(
               '<b><i>'.$LANG['plugin_projet'][0],
               $LANG['common'][16],
               $LANG['plugin_projet'][47],
               $LANG['plugin_projet'][19],
               $LANG['job'][35]
               .'</i></b>'
               );
         }
         
         while ($data=$DB->fetch_array($result)) {
         
            $items_id_display="";
            if ($_SESSION["glpiis_ids_visible"]||empty($data["name"])) $items_id_display= " (".$data["id"].")";
            $name=$data["name"].$items_id_display;
            
            $entity=html_clean(Dropdown::getDropdownName("glpi_entities",$data['entities_id']));
            
            $restrict = " `plugin_projet_tasks_id` = '".$data['id']."' ";
            $plans = getAllDatasFromTable("glpi_plugin_projet_taskplannings",$restrict);
            
            if (!empty($plans)) {
               foreach ($plans as $plan) {
                  $planification = convDateTime($plan["begin"]) . "&nbsp;->&nbsp;" .
                  convDateTime($plan["end"]);
               }
            } else {
               $planification = $LANG['job'][32];
            }
               
            if (isMultiEntitiesMode()) {
               $pdf->setColumnsSize(17,17,17,17,16,16);
               $pdf->displayLine(
                  $name,
                  $entity,
                  PluginProjetProjet::displayProgressBar('100',$data["advance"],array("simple"=>true)),
                  Dropdown::getDropdownName("glpi_plugin_projet_taskstates",$this->fields['plugin_projet_taskstates_id']),
                  html_clean($planification)
                  );
            } else {
               $pdf->setColumnsSize(20,17,17,17,17);
               $pdf->displayTitle(
                  $name,
                  PluginProjetProjet::displayProgressBar('100',$data["advance"],array("simple"=>true)),
                  Dropdown::getDropdownName("glpi_plugin_projet_taskstates",$this->fields['plugin_projet_taskstates_id']),
                  html_clean($planification)
                  );
            }
         }
         $pdf->displaySpace();
      }
   }
   
   // Cron action
   static function cronInfo($name) {
      global $LANG;
       
      switch ($name) {
         case 'ProjetTask':
            return array (
               'description' => $LANG['plugin_projet']['mailing'][15]);   // Optional
            break;
      }
      return array();
   }

   /**
    * Cron action on tasks : ExpiredTasks
    *
    * @param $task for log, if NULL display
    *
    **/
   static function cronProjetTask($task=NULL) {
      global $DB,$CFG_GLPI,$LANG;
      
      if (!$CFG_GLPI["use_mailing"]) {
         return 0;
      }

      $message=array();
      $cron_status = 0;
      
      $projettask = new self();
      $query_expired = $projettask->queryAlert();
      
      $querys = array(Alert::END=>$query_expired);
      
      $task_infos = array();
      $task_messages = array();

      foreach ($querys as $type => $query) {
         $task_infos[$type] = array();
         foreach ($DB->request($query) as $data) {
            $entity = $data['entities_id'];
            $message = $data["name"]."<br>\n";
            $task_infos[$type][$entity][] = $data;

            if (!isset($tasks_infos[$type][$entity])) {
               $task_messages[$type][$entity] = $LANG['plugin_projet']['mailing'][15]."<br />";
            }
            $task_messages[$type][$entity] .= $message;
         }
      }
      
      foreach ($querys as $type => $query) {
      
         foreach ($task_infos[$type] as $entity => $tasks) {
            Plugin::loadLang('projet');

            if (NotificationEvent::raiseEvent("AlertExpiredTasks",
                                              new PluginProjetProjet(),
                                              array('entities_id'=>$entity,
                                                    'tasks'=>$tasks))) {
               $message = $task_messages[$type][$entity];
               $cron_status = 1;
               if ($task) {
                  $task->log(Dropdown::getDropdownName("glpi_entities",
                                                       $entity).":  $message\n");
                  $task->addVolume(1);
               } else {
                  addMessageAfterRedirect(Dropdown::getDropdownName("glpi_entities",
                                                                    $entity).":  $message");
               }

            } else {
               if ($task) {
                  $task->log(Dropdown::getDropdownName("glpi_entities",$entity).
                             ":  Send tasks alert failed\n");
               } else {
                  addMessageAfterRedirect(Dropdown::getDropdownName("glpi_entities",$entity).
                                          ":  Send tasks alert failed",false,ERROR);
               }
            }
         }
      }
      
      return $cron_status;
   }
   
   function queryAlert() {

      $date=date("Y-m-d");
      $query = "SELECT `".$this->getTable()."`.*, `glpi_plugin_projet_projets`.`entities_id`
            FROM `".$this->getTable()."`
            LEFT JOIN `glpi_plugin_projet_taskplannings` ON (`glpi_plugin_projet_taskplannings`.`plugin_projet_tasks_id` = `".$this->getTable()."`.`id`)
            LEFT JOIN `glpi_plugin_projet_projets` ON (`glpi_plugin_projet_projets`.`id` = `".$this->getTable()."`.`plugin_projet_projets_id`)
            WHERE `glpi_plugin_projet_taskplannings`.`end` IS NOT NULL 
            AND `glpi_plugin_projet_taskplannings`.`end` <= '".$date."' 
            AND `glpi_plugin_projet_projets`.`is_template` = '0' 
            AND `glpi_plugin_projet_projets`.`is_deleted` = '0' 
            AND `".$this->getTable()."`.`is_deleted` = '0'";
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
               $query.= "AND `plugin_projet_taskstates_id` NOT IN (".implode(',',$tab).")";
            }

      return $query;
   }
}

?>