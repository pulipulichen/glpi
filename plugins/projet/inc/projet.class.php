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

class PluginProjetProjet extends CommonDBTM {

   public $dohistory=true;
	
	static function getTypeName() {
      global $LANG;

      return $LANG['plugin_projet']['title'][1];
   }
   
   function canCreate() {
      return plugin_projet_haveRight('projet', 'w');
   }

   function canView() {
      return plugin_projet_haveRight('projet', 'r');
   }
	
	//clean if projet are deleted
   function cleanDBonPurge() {

		$temp = new PluginProjetProjet_Item();
		$temp->deleteByCriteria(array('plugin_projet_projets_id' => $this->fields['id']));
      
      $temp = new PluginProjetTask();
      $temp->deleteByCriteria(array('plugin_projet_projets_id' => $this->fields['id']),1);
      
	}
	
	/*
    * Return the SQL command to retrieve linked object
    *
    * @return a SQL command which return a set of (itemtype, items_id)
    */
   function getSelectLinkedItem () {
      return "SELECT `itemtype`, `items_id`
              FROM `glpi_plugin_projet_projets_items`
              WHERE `plugin_projet_projets_id`='" . $this->fields['id']."'";
   }
   
   /**
    * Type than could be linked to a project
    *
    * @param $all boolean, all type, or only allowed ones
    *
    * @return array of types
   **/
   static function getTypes($all=false) {

      static $types = array('Computer','Monitor','NetworkEquipment','Peripheral',
         'Phone', 'Printer', 'Software', 'Group','User','Supplier');

      $plugin = new Plugin();
      if ($plugin->isActivated("appliances")) {
         $types[]='PluginAppliancesAppliance';
      }

      if ($all) {
         return $types;
      }

      // Only allowed types
      foreach ($types as $key=>$type) {
         if (!class_exists($type)) {
            continue;
         }

         $item = new $type();
         if (!$item->canView()) {
            unset($types[$key]);
         }
      }
      return $types;
   }
	
	function getSearchOptions() {
      global $LANG;

      $tab = array();
    
      $tab['common'] = $LANG['plugin_projet']['title'][1];

      $tab[1]['table']=$this->getTable();
      $tab[1]['field']='name';
      $tab[1]['name']=$LANG['plugin_projet'][0];
      $tab[1]['datatype']='itemlink';
      $tab[1]['itemlink_type'] = $this->getType();
      
      $tab[2]['table']=$this->getTable();
      $tab[2]['field']='date_begin';
      $tab[2]['name']=$LANG['search'][8];
      $tab[2]['datatype']='date';
      
      $tab[3]['table']=$this->getTable();
      $tab[3]['field']='date_end';
      $tab[3]['name']=$LANG['search'][9];
      $tab[3]['datatype']='date';
      
      $tab[4]['table']='glpi_users';
      $tab[4]['field']='name';
      $tab[4]['name']=$LANG['common'][34];
      
      $tab[5]['table']='glpi_groups';
      $tab[5]['field']='name';
      $tab[5]['name']=$LANG['common'][35];
      
      $tab[6]['table']='glpi_plugin_projet_projetstates';
      $tab[6]['field']='name';
      $tab[6]['name']=$LANG['plugin_projet'][19];
      
      $tab[7]['table']='parentid_table';
      $tab[7]['field']='name';
      $tab[7]['linkfield']='id';
      $tab[7]['name']=$LANG['plugin_projet'][44];
      $tab[7]['massiveaction'] = false;
      $tab[7]['joinparams'] = array('jointype' => 'item_item');
      
      $tab[8]['table']=$this->getTable();
      $tab[8]['field']='advance';
      $tab[8]['name']=$LANG['plugin_projet'][47];
      $tab[8]['datatype']='integer';
      
      $tab[9]['table']=$this->getTable();
      $tab[9]['field']='show_gantt';
      $tab[9]['name']=$LANG['plugin_projet'][70];
      $tab[9]['datatype']='bool';
      
      $tab[11]['table']=$this->getTable();
      $tab[11]['field']='comment';
      $tab[11]['name']=$LANG['plugin_projet'][2];
      $tab[11]['datatype']='text';
      
      $tab[12]['table']=$this->getTable();
      $tab[12]['field']='description';
      $tab[12]['name']=$LANG['plugin_projet'][10];
      $tab[12]['datatype']='text';
      
      $tab[13]['table']=$this->getTable();
      $tab[13]['field']='is_recursive';
      $tab[13]['name']=$LANG['entity'][9];
      $tab[13]['datatype']='bool';
      $tab[13]['massiveaction'] = false;
      
      $tab[14]['table']=$this->getTable();
      $tab[14]['field']='date_mod';
      $tab[14]['name']=$LANG['common'][26];
      $tab[14]['datatype']='datetime';
      $tab[14]['massiveaction'] = false;
      
      $tab[15]['table']=$this->getTable();
      $tab[15]['field']='is_helpdesk_visible';
      $tab[15]['name']=$LANG['software'][46];
      $tab[15]['datatype']='bool';
      
      $tab[16]['table']='glpi_plugin_projet_projets_items';
      $tab[16]['field']='items_id';
      $tab[16]['name']=$LANG['plugin_projet'][69];
      $tab[16]['massiveaction'] = false;
      $tab[16]['forcegroupby']  =  true;
      $tab[16]['joinparams']    = array('jointype' => 'child');
      
      $tab[31]['table']=$this->getTable();
      $tab[31]['field']='id';
      $tab[31]['name']=$LANG['common'][2];
      $tab[31]['massiveaction'] = false;
      
      $tab[80]['table']='glpi_entities';
      $tab[80]['field']='completename';
      $tab[80]['name']=$LANG['entity'][0];
      
      return $tab;
   }
   
	function defineTabs($options=array()) {
		global $LANG;
      
      $ong=array();
      
		$ong[1]=$LANG['title'][26];
		if ($this->fields['id'] > 0) {
			if (!isset($options['withtemplate']) || empty($options['withtemplate'])) {
				$ong[3]=$LANG['plugin_projet']['title'][5];
         }
			$ong[4]=$LANG['plugin_projet']['title'][2];
			
			if (haveRight("document","r")) {
				$ong[5]=$LANG['Menu'][27];
			}
				
			$ong[6]=$LANG['plugin_projet'][17];
			
			if (haveRight("show_all_ticket","1") && !isset($options['withtemplate']) || empty($options['withtemplate'])) {
				$ong[7]=$LANG['title'][28];
			}
			
			if (plugin_projet_haveRight("task","r")) {
            $ong[8]=$LANG['plugin_projet']['title'][3];
			}
			
			if (!isset($options['withtemplate']) || empty($options['withtemplate'])) {
				$ong[12]=$LANG['title'][38];
         }
			
		}

		return $ong;		
	}
	
	function prepareInputForAdd($input) {

		if (isset($input['date_begin']) && empty($input['date_begin'])) $input['date_begin']='NULL';
		if (isset($input['date_end']) && empty($input['date_end'])) $input['date_end']='NULL';
		
		if (isset($input["id"]) && $input["id"]>0) {
         $input["_oldID"]=$input["id"];
      }
      unset($input['id']);
      //unset($input['withtemplate']);

		return $input;
	}

	function post_addItem() {
		global $CFG_GLPI;
		
		// Manage add from template
		if (isset($this->input["_oldID"])) {
			// ADD Documents
			$docitem=new Document_Item();
			$restrict = "`items_id` = '".$this->input["_oldID"]."' AND `itemtype` = '".$this->getType()."'";
         $docs = getAllDatasFromTable("glpi_documents_items",$restrict);
         if (!empty($docs)) {
            foreach ($docs as $doc) {
               $docitem->add(array('documents_id' => $doc["documents_id"],
                        'itemtype' => $this->getType(),
                        'items_id' => $this->fields['id']));
            }
			}
			
			// ADD Contracts
			$contractitem=new Contract_Item();
			$restrict = "`items_id` = '".$this->input["_oldID"]."' AND `itemtype` = '".$this->getType()."'";
         $contracts = getAllDatasFromTable("glpi_contracts_items",$restrict);
         if (!empty($contracts)) {
            foreach ($contracts as $contract) {
               $contractitem->add(array('contracts_id' => $contract["contracts_id"],
                        'itemtype' => $this->getType(),
                        'items_id' => $this->fields['id']));
            }
			}
			
			// ADD items
			$PluginProjetProjet_Item= new PluginProjetProjet_Item();
			$restrict = "`plugin_projet_projets_id` = '".$this->input["_oldID"]."'";
         $items = getAllDatasFromTable("glpi_plugin_projet_projets_items",$restrict);
         if (!empty($items)) {
            foreach ($items as $item) {
               $PluginProjetProjet_Item->add(array('plugin_projet_projets_id' => $this->fields['id'],
                        'itemtype' => $item["itemtype"],
                        'items_id' => $item["items_id"]));
            }
			}

			// ADD tasks
			$PluginProjetTask = new PluginProjetTask();
			$PluginProjetTask_Item = new PluginProjetTask_Item();
			
			$restrict = "`plugin_projet_projets_id` = '".$this->input["_oldID"]."'";
         $tasks = getAllDatasFromTable("glpi_plugin_projet_tasks",$restrict);
         if (!empty($tasks)) {
            foreach ($tasks as $task) {
               $values=$task;
               $taskid = $values["id"];
               unset($values["id"]);
               $values["plugin_projet_projets_id"]=$this->fields['id'];
               $values["name"] = addslashes($task["name"]);
					$values["comment"] = addslashes($task["comment"]);
					$values["sub"] = addslashes($task["sub"]);
					$values["others"] = addslashes($task["others"]);
					$values["affect"] = addslashes($task["affect"]);
               
               $newid = $PluginProjetTask->add($values);
               
               $restrictitems = "`plugin_projet_tasks_id` = '".$taskid."'";
               $tasksitems = getAllDatasFromTable("glpi_plugin_projet_tasks_items",$restrictitems);
               if (!empty($tasksitems)) {
                  foreach ($tasksitems as $tasksitem) {
                     $PluginProjetTask_Item->add(array('plugin_projet_tasks_id' => $newid,
                        'itemtype' => $tasksitem["itemtype"],
                        'items_id' => $tasksitem["items_id"]));
                  }
               }
            }
         }
		}
		if ($this->input["withtemplate"]!=1) {
			if ($CFG_GLPI["use_mailing"]) {
            NotificationEvent::raiseEvent("new",$this);
         }
		}
	}
	
	function prepareInputForUpdate($input) {
		global $LANG,$CFG_GLPI;
      
      if (isset($input['date_begin'])&&empty($input['date_begin'])) $input['date_begin']='NULL';
		if (isset($input['date_end'])&&empty($input['date_end'])) $input['date_end']='NULL';
		
		$this->getFromDB($input["id"]);
		
		$input["_old_name"]=$this->fields["name"];
		$input["_old_date_begin"]=$this->fields["date_begin"];
		$input["_old_date_end"]=$this->fields["date_end"];
		$input["_old_users_id"]=$this->fields["users_id"];
		$input["_old_groups_id"]=$this->fields["groups_id"];
		$input["_old_plugin_projet_projetstates_id"]=$this->fields["plugin_projet_projets_id"];
		$input["_old_plugin_projet_projets_id"]=$this->fields["plugin_projet_projets_id"];
		$input["_old_advance"]=$this->fields["advance"];
		$input["_old_show_gantt"]=$this->fields["show_gantt"];
		$input["_old_comment"]=$this->fields["comment"];
		$input["_old_description"]=$this->fields["description"];

		return $input;
	}
	
	function post_updateItem($history=1) {
		global $CFG_GLPI,$LANG;
		
		if (count($this->updates) && isset($this->input["withtemplate"]) && $this->input["withtemplate"]!=1) {
         if ($CFG_GLPI["use_mailing"]) {
            NotificationEvent::raiseEvent("update",$this);
         }
      }
	}
	
	function pre_deleteItem() {
      global $CFG_GLPI;
      
      if ($CFG_GLPI["use_mailing"] && $this->fields["is_template"]!=1 && isset($this->input['delete'])) {
         NotificationEvent::raiseEvent("delete",$this);
      }
      
      return true;
   }
	
	function showForm($ID, $options=array()) {
		global $CFG_GLPI, $LANG;
		
		if (!plugin_projet_haveRight("projet","r")) return false;
		
		if (!$this->canView()) return false;
    
      if ($ID > 0) {
			$this->check($ID,'r');
		} else {
			// Create item 
			$this->check(-1,'w');
			$this->getEmpty();
		}
		
		if (isset($options['withtemplate']) && $options['withtemplate'] == 2) {
         $template = "newcomp";
         $datestring = $LANG['computers'][14]." : ";
         $date = convDateTime($_SESSION["glpi_currenttime"]);
      } else if (isset($options['withtemplate']) && $options['withtemplate'] == 1) {
         $template = "newtemplate";
         $datestring = $LANG['computers'][14]." : ";
         $date = convDateTime($_SESSION["glpi_currenttime"]);
      } else {
         $datestring = $LANG['common'][26].": ";
         $date = convDateTime($this->fields["date_mod"]);
         $template = false;
      }
    
      $this->showTabs($options);
      $this->showFormHeader($options);

      echo "<tr class='tab_bg_1'><td>".$LANG['plugin_projet'][0].": </td>";
      echo "<td>";
      autocompletionTextField($this,"name");	
      echo "</td>";

      //Projet parent
      echo "<td>".$LANG['plugin_projet'][44].": </td>";
      echo "<td>";
      $this->dropdownParent("plugin_projet_projets_id", $this->fields["plugin_projet_projets_id"],array('id' => $this->fields["id"]));
      echo "</td></tr>";
      
      echo "<tr class='tab_bg_3'><td colspan='2'>".$LANG['plugin_projet'][9]."</td>";
      echo "<td colspan='2'>".$LANG['plugin_projet'][24]."</td></tr>";
      
      echo "<tr class='tab_bg_1'><td>".$LANG['common'][34].": </td><td>";
      User::dropdown(array('value' => $this->fields["users_id"],
                           'entity' => $this->fields["entities_id"],
                           'right' => 'all'));
      echo "</td>";
      echo "<td>".$LANG['search'][8].": </td><td>";
      showDateFormItem("date_begin",$this->fields["date_begin"],true,true);
      echo "</td></tr>";
      
      echo "<tr class='tab_bg_1'><td>".$LANG['common'][35].": </td><td>";
      Dropdown::show('Group', array('value' => $this->fields["groups_id"],
                                    'entity' => $this->fields["entities_id"]));
      echo "</td>";
      echo "<td>".$LANG['search'][9].": </td><td>";
      showDateFormItem("date_end",$this->fields["date_end"],true,true);
      echo "</td></tr>";
      
      //// START PROVECTIO
      echo "<tr class='tab_bg_2'><td>" . $LANG['plugin_projet'][75].":&nbsp;";
      showToolTip(nl2br($LANG['plugin_projet'][76]));
      echo "</td>";
      echo "<td>" . $this->getProjectForecast($ID) . "</td>";
      echo "<td>" . $LANG['plugin_projet'][72].":&nbsp;";
      showToolTip(nl2br($LANG['plugin_projet'][77]));
      echo "</td>";
      echo "<td>". $this->getProjectDuration($ID) . "</td></tr>";
      //// END PROVECTIO 

      //status
      echo "<tr class='tab_bg_1'><td>".$LANG['plugin_projet'][19].":</td><td>";
      Dropdown::show('PluginProjetProjetState',
                  array('value'  => $this->fields["plugin_projet_projetstates_id"]));
      echo "</td>";
      echo "<td>".$LANG['plugin_projet'][70].": </td><td>";
      Dropdown::showYesNo("show_gantt",$this->fields["show_gantt"]);
      echo "</td></tr>";
      
      //advance
      echo "<tr class='tab_bg_1'><td>".$LANG['plugin_projet'][47].":</td><td>";
      $advance=floor($this->fields["advance"]);
      echo "<select name='advance'>";
      for ($i=0;$i<101;$i+=5) {
         echo "<option value='$i' ";
         if ($advance==$i) echo "selected";
            echo " >$i</option>";
      }
      echo "</select> ".$LANG['plugin_projet'][48];	
      echo "<td>".$LANG['software'][46].": </td><td>";
      Dropdown::showYesNo('is_helpdesk_visible',$this->fields['is_helpdesk_visible']);
      echo "</td></tr>";
      
      echo "<tr class='tab_bg_1'><td colspan='4'>".$LANG['plugin_projet'][2].": </td></tr>";

      echo "<tr class='tab_bg_1'><td colspan='4'>";			
      echo "<textarea cols='130' rows='4' name='comment' >".$this->fields["comment"]."</textarea>";
      echo "<input type='hidden' name='withtemplate' value='".$options['withtemplate']."'>";
      echo "</td></tr>";
      
      echo "<tr class='tab_bg_1'><td colspan='4'>".$LANG['plugin_projet'][14].": </td></tr>";

      echo "<tr class='tab_bg_1'><td colspan='4'>";			
      echo "<textarea cols='130' rows='4' name='description' >".$this->fields["description"]."</textarea>";
      echo "</td></tr>";
      
      echo "<tr class='tab_bg_1 center'><td colspan='4'>";
      $datestring = $LANG['common'][26].": ";
      $date = convDateTime($this->fields["date_mod"]);
      echo $datestring.$date."</td>";
      echo "</tr>";
      
      $this->showFormButtons($options);
      $this->addDivForTabs();
      return true;
		
	}
	
	function listTemplates($target,$add=0) {
      global $LANG;
      
      $restrict = "`is_template` = '1'";
      $restrict.=getEntitiesRestrictRequest(" AND ",$this->getTable(),'','',$this->maybeRecursive());
      $restrict.=" ORDER BY `name`";
      $templates = getAllDatasFromTable($this->getTable(),$restrict);
      
      if (isMultiEntitiesMode()) {
         $colsup=1;
      } else {
         $colsup=0;
      }
         
      echo "<div align='center'><table class='tab_cadre' width='50%'>";
      if ($add) {
         echo "<tr><th colspan='".(2+$colsup)."'>".$LANG['common'][7]." - ".$LANG['plugin_projet']['title'][1].":</th>";
      } else {
         echo "<tr><th colspan='".(2+$colsup)."'>".$LANG['common'][14]." - ".$LANG['plugin_projet']['title'][1]." :</th>";
      }
      
      echo "</tr>";
      if ($add) {

         echo "<tr>";
         echo "<td colspan='".(2+$colsup)."' class='center tab_bg_1'>";
         echo "<a href=\"$target?id=-1&amp;withtemplate=2\">&nbsp;&nbsp;&nbsp;" . $LANG['common'][31] . "&nbsp;&nbsp;&nbsp;</a></td>";
         echo "</tr>";
      }
      
      foreach ($templates as $template) {

         $templname = $template["template_name"];
         if ($_SESSION["glpiis_ids_visible"]||empty($template["template_name"]))
         $templname.= "(".$template["id"].")";

         echo "<tr>";
         echo "<td class='center tab_bg_1'>";
         if (!$add) {
            echo "<a href=\"$target?id=".$template["id"]."&amp;withtemplate=1\">&nbsp;&nbsp;&nbsp;$templname&nbsp;&nbsp;&nbsp;</a></td>";
            
            if (isMultiEntitiesMode()) {
               echo "<td class='center tab_bg_2'>";
               echo Dropdown::getDropdownName("glpi_entities",$template['entities_id']);
               echo "</td>";
            }
            echo "<td class='center tab_bg_2'>";
            echo "<b><a href=\"$target?id=".$template["id"]."&amp;purge=purge&amp;withtemplate=1\">".$LANG['buttons'][6]."</a></b>";
            echo "</td>";
            
         } else {
            echo "<a href=\"$target?id=".$template["id"]."&amp;withtemplate=2\">&nbsp;&nbsp;&nbsp;$templname&nbsp;&nbsp;&nbsp;</a></td>";
            
            if (isMultiEntitiesMode()) {
               echo "<td class='center tab_bg_2'>";
               echo Dropdown::getDropdownName("glpi_entities",$template['entities_id']);
               echo "</td>";
            }
         }
         echo "</tr>";
      }
      if (!$add) {
         echo "<tr>";
         echo "<td colspan='".(2+$colsup)."' class='tab_bg_2 center'>";
         echo "<b><a href=\"$target?withtemplate=1\">".$LANG['common'][9]."</a></b>";
         echo "</td>";
         echo "</tr>";
      }
      echo "</table></div>";
   }
   
   /**
    * Display a simple progress bar
    * @param $width Width of the progress bar
    * @param $percent Percent of the progress bar
    * @param $options array options :
    *            - title : string title to display (default Progesssion)
    *            - simple : display a simple progress bar (no title / only percent)
    *            - forcepadding : boolean force str_pad to force refresh (default true)
    * @return nothing
    *
    *
    **/
   static function displayProgressBar($width,$percent,$options=array()) {
      global  $CFG_GLPI,$LANG;
      
      $param['simple']=false;
      if (is_array($options) && count($options)) {
         foreach ($options as $key => $val) {
            $param[$key]=$val;
         }
      }
   
      $percentwidth=floor($percent*$width/100);
      
      if ($param['simple']) {
         $output=$percent."%";
      } else {
         $output="<div class='center'><table class='tab_cadre' width='".($width+20)."px'>";

         $output.="<tr><td>
                <table><tr><td class='center' style='background:url(".$CFG_GLPI["root_doc"].
                "/pics/loader.png) repeat-x; padding: 0px;font-size: 10px;' width='".$percentwidth."px' height='12px'>";

         $output.=$percent."%";

         $output.="</td></tr></table></td>";
         $output.="</tr></table>";
         $output.="</div>";
      }
      return $output;
   }
   
	function findChilds($DB, $parent) {
      global $CFG_GLPI;

      $queryBranch='';
      // Recherche les enfants
      $queryChilds= "SELECT `id` 
                     FROM `".$this->gettable()."` 
                     WHERE `plugin_projet_projets_id` = '$parent' 
                     AND `is_template` = '0' 
                     AND `is_deleted` = '0' "
                  . getEntitiesRestrictRequest(" AND ",$this->gettable(),'','',$this->maybeRecursive());

      if ($resultChilds = $DB->query($queryChilds)) {
         while ($dataChilds = $DB->fetch_array($resultChilds)) {
            $child=$dataChilds["id"];
            $queryBranch .= ",$child";
            // Recherche les petits enfants r?cursivement
            $queryBranch .= $this->findChilds($DB, $child);
         }
      }
      return $queryBranch;
   }

   function dropdownParent($name,$value=0, $options=array()) {
      global $DB;
      
      echo "<select name='$name'>";
      echo "<option value='0'>".DROPDOWN_EMPTY_VALUE."</option>";
      
      $restrict = " `is_template` = '0' AND `is_deleted` = '0'";
      $restrict.= getEntitiesRestrictRequest(" AND ",$this->gettable(),'','',$this->maybeRecursive());
     if (!empty($options["id"])) {
         $restrict.= " AND `id` != '".$options["id"]."' AND `plugin_projet_projets_id` NOT IN ('".$options["id"]."' ";
         $restrict.= $this->findChilds($DB,$options["id"]);
         $restrict.= ") ";
      }
      $restrict.= "ORDER BY `name` ASC ";
      $projets = getAllDatasFromTable($this->getTable(),$restrict);
      
      if (!empty($projets)) {
         $prev=-1;
         foreach ($projets as $projet) {
            if ($projet["entities_id"]!=$prev) {
               if ($prev>=0) {
                  echo "</optgroup>";
               }
               $prev=$projet["entities_id"];
               echo "<optgroup label=\"". Dropdown::getDropdownName("glpi_entities", $prev) ."\">";
            }
            $output = $projet["name"];
            echo "<option value='".$projet["id"]."' ".($value=="".$projet["id"].""?" selected ":"")." title=\"$output\">".substr($output,0,$_SESSION["glpidropdown_chars_limit"])."</option>";
         }
         if ($prev>=0) {
            echo "</optgroup>";
         }
      }
      echo "</select>";	
   }

	//$parents=0 -> childs
   //$parents=1 -> parents
   function showHierarchy($instID,$parents=0) {
      global $DB,$CFG_GLPI, $LANG;
      
      $first=false;
      $query = "SELECT `".$this->gettable()."`.*  ";
      if ($parents!=0)
         $query.= " ,`parent_table`.`name` AS plugin_projet_projets_id,`parent_table`.`id` AS projet_id_id ";
         
      $query.= " FROM `".$this->gettable()."`";
      if ($parents!=0){
         $query.= " LEFT JOIN `".$this->gettable()."` AS parent_table ON (`parent_table`.`plugin_projet_projets_id` = `".$this->gettable()."`.`id`)";
         $query.= " WHERE `parent_table`.`id` = '$instID' ";
      } else {
         $query.= " WHERE `".$this->gettable()."`.`plugin_projet_projets_id` = '$instID' ";
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
      $LINK= " AND " ;    
      $query.=getEntitiesRestrictRequest(" AND ",$this->gettable(),'','',$this->maybeRecursive());
            
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
         
         $title = $LANG['plugin_projet'][45];
         if ($parents!=0)
            $title = $LANG['plugin_projet'][44];
         
         echo "<tr><th colspan='".(7+$colsup)."'>".$title."</th></tr>";
         
         echo "<tr><th>".$LANG['plugin_projet'][0]."</th>";
         if (isMultiEntitiesMode())
            echo "<th>".$LANG['entity'][0]."</th>";
         echo "<th>".$LANG['plugin_projet'][47]."</th>";
         echo "<th>".$LANG['common'][34]."</th>";
         echo "<th>".$LANG['common'][35]."</th>";
         echo "<th>".$LANG['plugin_projet'][19]."</th>";
         echo "<th>".$LANG['search'][8]."</th>";
         echo "<th>".$LANG['search'][9]."</th>";
         echo "</tr>";

         while ($data=$DB->fetch_array($result)) {
            $start = 0;
            $output_type=HTML_OUTPUT;
            $del=false;
            if($data["is_deleted"]=='0')
               echo "<tr class='tab_bg_1'>";
            else
               echo "<tr class='tab_bg_1".($data["is_deleted"]=='1'?"_2":"")."'>";

            echo Search::showItem($output_type,"<a href=\"./projet.form.php?id=".$data["id"]."\">".$data["name"].($_SESSION["glpiis_ids_visible"]||empty($data["name"])?' ('.$data["id"].') ':'')."</a>",$item_num,$i-$start+1,'');
            
            if (isMultiEntitiesMode())
               echo "<td class='center'>".Dropdown::getDropdownName("glpi_entities",$data['entities_id'])."</td>";
            
            echo Search::showItem($output_type,PluginProjetProjet::displayProgressBar('100',$data["advance"],array("simple"=>true)),$item_num,$i-$start+1,"align='center'");
            echo Search::showItem($output_type,getUserName($data['users_id']),$item_num,$i-$start+1,'');
            echo Search::showItem($output_type,Dropdown::getDropdownName("glpi_groups",$data['groups_id']),$item_num,$i-$start+1,'');
            echo Search::showItem($output_type,Dropdown::getDropdownName("glpi_plugin_projet_projetstates",$data['plugin_projet_projetstates_id']),$item_num,$i-$start+1,"bgcolor='".PluginProjetProjetState::getStatusColor($data['plugin_projet_projetstates_id'])."' align='center'");
            echo Search::showItem($output_type,convdate($data["date_begin"]),$item_num,$i-$start+1,"align='center'");
            $display = convdate($data["date_end"]);
            if ($data["date_end"] <= date('Y-m-d'))
               $display = "<span class='plugin_projet_date_end'>".convdate($data["date_end"])."</span>";

            echo Search::showItem($output_type,$display,$item_num,$i-$start+1,"align='center'");
               
            echo "</tr>";
         }
         echo "</table></div>";
      }
   }
   
   function dropdownProjet($name,$entity_restrict=-1,$used=array()) {
      global $DB,$CFG_GLPI, $LANG;

      $where=" WHERE `".$this->gettable()."`.`is_deleted` = '0' 
            AND `".$this->gettable()."`.`is_template` = '0'";
      
      if (isset($entity_restrict)&&$entity_restrict>=0) {
         $where.=getEntitiesRestrictRequest("AND",$this->gettable(),'',$entity_restrict,true);
      } else {
         $where.=getEntitiesRestrictRequest("AND",$this->gettable(),'','',true);
      }
      
      if (isset($used)) {
      $where .=" AND `".$this->gettable()."`.`id` NOT IN (0";

      foreach($used as $val)
         $where .= ",$val";
      $where .= ") ";
      }

      $query = "SELECT * 
            FROM `".$this->gettable()."` 
            $where 
            ORDER BY `entities_id`,`name`";
      $result=$DB->query($query);
      $number = $DB->numrows($result);
      $i = 0;
      
      echo "<select name=\"".$name."\">";

      echo "<option value=\"0\">".DROPDOWN_EMPTY_VALUE."</option>";
      
      if ($DB->numrows($result)) {
         $prev=-1;
         while ($data=$DB->fetch_array($result)) {
            if ($data["entities_id"]!=$prev) {
               if ($prev>=0) {
                  echo "</optgroup>";
               }
               $prev=$data["entities_id"];
               echo "<optgroup label=\"". Dropdown::getDropdownName("glpi_entities", $prev) ."\">";
            }
            $output = $data["name"];
            echo "<option value=\"".$data["id"]."\" title=\"$output\">".substr($output,0,$_SESSION["glpidropdown_chars_limit"])."</option>";
         }
         if ($prev>=0) {
            echo "</optgroup>";
         }
      }
      echo "</select>";
      
   }
	
	function showUsers($itemtype,$ID) {
      global $DB,$CFG_GLPI, $LANG;
      
      $item = new $itemtype();
      $canread = $item->can($ID,'r');
      $canedit = $item->can($ID,'w');
      
      $query = "SELECT `".$this->gettable()."`.* FROM `".$this->gettable()."` "
      ." LEFT JOIN `glpi_entities` ON (`glpi_entities`.`id` = `".$this->gettable()."`.`entities_id`) ";
      if ($itemtype=='User')
         $query.= " WHERE `".$this->gettable()."`.`users_id` = '".$ID."' ";
      else
         $query.= " WHERE `".$this->gettable()."`.`groups_id` = '".$ID."' ";
      $query.= "AND `".$this->gettable()."`.`is_template` = 0 "
      . getEntitiesRestrictRequest(" AND ",$this->gettable(),'','',$this->maybeRecursive());
      
      $result = $DB->query($query);
      $number = $DB->numrows($result);
      
      if (isMultiEntitiesMode()) {
         $colsup=1;
      } else {
         $colsup=0;
      }
      
      if ($number>0){
         echo "<form method='post' action=\"".$CFG_GLPI["root_doc"]."/plugins/projet/front/projet.form.php\">";
         echo "<div align='center'><table class='tab_cadre_fixe'>";
         echo "<tr><th colspan='".(4+$colsup)."'>".$LANG['plugin_projet'][52].":</th></tr>";
         echo "<tr><th>".$LANG['plugin_projet'][0]."</th>";
         if (isMultiEntitiesMode()) 
            echo "<th>".$LANG['entity'][0]."</th>";
         echo "<th>".$LANG['plugin_projet'][10]."</th>";
         echo "<th>".$LANG['plugin_projet'][47]."</th>";
         echo "</tr>";

         while ($data=$DB->fetch_array($result)) {

            echo "<tr class='tab_bg_1".($data["is_deleted"]=='1'?"_2":"")."'>";

            if ($canread && (in_array($data['entities_id'],$_SESSION['glpiactiveentities']) || $data["recursive"])) {
               echo "<td class='center'><a href='".$CFG_GLPI["root_doc"]."/plugins/projet/front/projet.form.php?id=".$data["id"]."'>".$data["name"];
               if ($_SESSION["glpiis_ids_visible"]) echo " (".$data["id"].")";
               echo "</a></td>";
            } else {
               echo "<td class='center'>".$data["name"];
               if ($_SESSION["glpiis_ids_visible"]) echo " (".$data["id"].")";
               echo "</td>";
            }
            if (isMultiEntitiesMode()) 
               echo "<td class='center'>".Dropdown::getDropdownName("glpi_entities",$data['entities_id'])."</td>";
            echo "<td align='center'>".$data["description"]."</td>";
            echo "<td align='center'>".$data["advance"]." ".$LANG['plugin_projet'][48]."</td>";
            echo "</tr>";
         }
         echo "</table></div>";
         echo "</form><br>";
      } else {
         echo "<div align='center'><table class='tab_cadre_fixe' style='text-align:center'>";
         echo "<tr><th><strong>".$LANG['plugin_projet'][52]."</strong>";
         echo "</th></tr></table></div><br>";
      }
   }
   
   //// START PROVECTIO
	/**
	* Compute project real duration
	*
	*@param $ID ID of the project
	*@return text duration of project
	**/
	function getProjectDuration($ID) {
		global $DB;
		
		$query = "SELECT SUM(`actiontime`) 
				FROM `glpi_tickets` 
				WHERE `items_id`  = '$ID' 
					AND `itemtype` = 'PluginProjetProjet';";
		
		if ($result = $DB->query($query)) {
			$sum=$DB->result($result,0,0);
			if (is_null($sum)) return '--';
			
			return Ticket::getActionTime($sum);
		} else {
			return '--';
		}
	}
	
	/**
   * Compute forecast duration
   *
   *@param $ID ID of the project
   *@return text duration of project
   */
   function getProjectForecast ($ID) {
		global $DB;
		
		$query = "SELECT SUM(`realtime`) 
				FROM `glpi_plugin_projet_tasks` 
				WHERE `plugin_projet_projets_id` = '$ID' ";
		
		if ($result = $DB->query($query)) {
			$sum=$DB->result($result,0,0);
		if (is_null($sum)) return '--';
			return self::getActionTime($sum);
		} else {
			return '--';
		}
   }
   
	static function getActionTime($actiontime) {
       global $LANG;

       $output = "";
       $hour = floor($actiontime);
       if ($hour>0) {
          $output .= $hour." ".$LANG['job'][21]." ";
       }
       $output .= round((($actiontime-floor($actiontime))*60))." ".$LANG['job'][22];
       return $output;

      //return timestampToString($actiontime, false);
   }
	 //// END PROVECTIO

	static function showGlobalGantt() {
      global $LANG,$CFG_GLPI,$gtitle,$gdata,$nbgdata,$gconst,$gdate_begin,$gdate_end;    
      
      //not show archived projects
      $archived = " `type` = '1' ";
      $states = getAllDatasFromTable("glpi_plugin_projet_projetstates",$archived);
      
      $restrict= " `is_deleted` = '0'";
      
      $tab = array();
      if (!empty($states)) {
         foreach ($states as $state) {
            $tab[]= $state['id'];
         }
      }
      if (!empty($tab)) {
         $restrict.= "AND `plugin_projet_projetstates_id` NOT IN (".implode(',',$tab).")";
      }
      
      $restrict.= " AND `is_template` = '0'";
      $restrict.= " AND `show_gantt` = '1'";
      $restrict.=getEntitiesRestrictRequest(" AND ","glpi_plugin_projet_projets",'','',true);
      $restrict.= " ORDER BY `date_begin` DESC";
      
      $projets = getAllDatasFromTable("glpi_plugin_projet_projets",$restrict);
      
      if (!empty($projets)) {
         echo "<div align='center'><table border='0' class='tab_cadre'>";
         echo "<tr><th align='center' >".$LANG['plugin_projet']['title'][5];
         echo "</th></tr>";
         
         $gdata=array();
         foreach ($projets as $projet) {
            
            if (isMultiEntitiesMode())
               $gantt_p_name=Dropdown::getDropdownName("glpi_entities",$projet['entities_id'])." - ".$projet["name"];
            else
               $gantt_p_name=$projet["name"];
               
            $int = hexdec(PluginProjetProjetState::getStatusColor($projet["plugin_projet_projetstates_id"]));
            $gantt_p_bgcolor = array(0xFF & ($int >> 0x10), 0xFF & ($int >> 0x8), 0xFF & $int);
            
            $gantt_p_date_begin=date("Y-m-d");
            $gantt_p_date_end=date("Y-m-d");
            if (!empty($projet["date_begin"])) {
               $gantt_p_date_begin=$projet["date_begin"];
            }
            if (!empty($projet["date_end"])) {
               $gantt_p_date_end=$projet["date_end"];
            }
            
            $gdata[]=array("type"=>'group',
                           "projet"=>$projet["id"],
                           "name"=>$gantt_p_name,
                           "date_begin"=>$gantt_p_date_begin,
                           "date_end"=>$gantt_p_date_end,
                           "advance"=>$projet["advance"],
                           "bg_color"=>$gantt_p_bgcolor);
         }

         echo "<tr><td width='100%'>";
         echo "<div align='center'>";
         if (!empty($gdate_begin) && !empty($gdate_end)) {
            $gtitle=$gtitle."<DateBeg> / <DateEnd>";
            $gdate_begin=date("Y",$gdate_begin)."-".date("m",$gdate_begin)."-".date("d",$gdate_begin);
            $gdate_end=date("Y",$gdate_end)."-".date("m",$gdate_end)."-".date("d",$gdate_end);
         }
         $ImgName=self::writeGantt($gtitle,$gdata,$gconst,$gdate_begin,$gdate_end);
         echo "<img src='".$CFG_GLPI["root_doc"]."/front/pluginimage.send.php?plugin=projet&amp;name=".$ImgName."&amp;clean=1' alt='Gantt'/>";//afficher graphique
         echo "</div>";
         echo "</td></tr></table></div>";
      }
   }
   
   static function showProjetTreeGantt($options=array()) {
      global $LANG,$CFG_GLPI,$gtitle,$gdata,$gconst,$gdate_begin,$gdate_end;
      
      self::showProjetGantt($options);
      
      echo "<div align='center'><table border='0' class='tab_cadre'>";
      echo "<tr><th align='center' >".$LANG['plugin_projet']['title'][5];
      echo "</th></tr>";
      echo "<tr><td width='100%'>";
      echo"<div align='center'>";
      if (!empty($gdate_begin) && !empty($gdate_end)) {
         $gtitle=$gtitle."<DateBeg> / <DateEnd>";
         $gdate_begin=date("Y",$gdate_begin)."-".date("m",$gdate_begin)."-".date("d",$gdate_begin);
         $gdate_end=date("Y",$gdate_end)."-".date("m",$gdate_end)."-".date("d",$gdate_end);
      }
      $ImgName=self::writeGantt($gtitle,$gdata,$gconst,$gdate_begin,$gdate_end);
      echo "<img src='".$CFG_GLPI["root_doc"]."/front/pluginimage.send.php?plugin=projet&amp;name=".$ImgName."&amp;clean=1' alt='Gantt' />";//afficher graphique

      echo"</div>";
      echo "</td></tr></table></div>";
            
   }
   
   static function showProjetGantt($options=array()) {
      global $gdata;
      
      $restrict = " `id` = '".$options["plugin_projet_projets_id"]."' ";
      $restrict.= " AND `is_deleted` = '0'";
      $restrict.= " AND `is_template` = '0'";
      
      $projets = getAllDatasFromTable("glpi_plugin_projet_projets",$restrict);
      
      $prefixp = $options["prefixp"];
      
      if (!empty($projets)) {
         
         foreach ($projets as $projet) {
            
            if ($options["parent"] > 0)
               $prefixp.= "-";
            //nom
            if ($options["parent"] > 0)
               $gantt_p_name= $prefixp." ".$projet["name"];
            else
               $gantt_p_name= $projet["name"];

            
            $int = hexdec(PluginProjetProjetState::getStatusColor($projet["plugin_projet_projetstates_id"]));
            $gantt_p_bgcolor = array(0xFF & ($int >> 0x10), 0xFF & ($int >> 0x8), 0xFF & $int);
            
            $gantt_p_date_begin=date("Y-m-d");
            $gantt_p_date_end=date("Y-m-d");
            if (!empty($projet["date_begin"])) {
               $gantt_p_date_begin=$projet["date_begin"];
            }
            if (!empty($projet["date_end"])) {
               $gantt_p_date_end=$projet["date_end"];
            }
            
            $gdata[]=array("type"=>'group',
                           "projet"=>$options["plugin_projet_projets_id"],
                           "name"=>$gantt_p_name,
                           "date_begin"=>$gantt_p_date_begin,
                           "date_end"=>$gantt_p_date_end,
                           "advance"=>$projet["advance"],
                           "bg_color"=>$gantt_p_bgcolor);

            PluginProjetTask::showTaskTreeGantt(array('plugin_projet_projets_id'=>$projet["id"]));
            
            $restrictchild = " `plugin_projet_projets_id` = '".$projet["id"]."' ";
            $restrictchild.= " AND `id` != '".$projet["id"]."'";
            $restrictchild.= " AND `is_deleted` = '0'";
            $restrictchild.= " AND `is_template` = '0'";
            $restrictchild.= " ORDER BY `plugin_projet_projetstates_id`,`date_begin` DESC";

            $childs = getAllDatasFromTable("glpi_plugin_projet_projets",$restrictchild);
            
            if (!empty($childs)) {
               foreach ($childs as $child) {
                  $params=array('plugin_projet_projets_id'=>$child["id"],
                                 'parent'=>1,
                                 'prefixp'=>$prefixp);
                  self::showProjetGantt($params);
                  
               }
            }
         }
      }        
   }
   
   static function dropAccent($chaine) {

      $chaine=utf8_decode($chaine);
      $chaine=strtr( $chaine, 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ', 'AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn' );
      return $chaine;

   }

   static function writeGantt($title,$gdata,$gconst,$gantt_date_begin,$gantt_date_end) {
      global $CFG_GLPI;
      
      include_once (GLPI_ROOT."/plugins/projet/inc/gantt.class.php");
      
      if (isset($gantt_date_begin)) $definitions['limit']['start'] = mktime(0,0,0,substr($gantt_date_begin, 5, 2),substr($gantt_date_begin, 8, 2),substr($gantt_date_begin, 0, 4));

      if (isset($gantt_date_end))   $definitions['limit']['end']   = mktime(0,0,0,substr($gantt_date_end, 5, 2),substr($gantt_date_end, 8, 2),substr($gantt_date_end, 0, 4));

      $definitions['locale'] = substr($CFG_GLPI["language"],0,2);
      $definitions['today']['data']= time();        
      $definitions['title_string'] = self::dropAccent((strlen($title)>60) ? substr($title,0,58)."..." : $title);

      for ($i=0 ; $i<count($gdata) ; $i++) {            

         if ($gdata[$i]["type"]=='group') { // Groupe 
            $definitions['groups']['group'][$gdata[$i]["projet"]]['name'] = self::dropAccent((strlen($gdata[$i]["name"])>60) ? substr($gdata[$i]["name"],0,58)."..." : $gdata[$i]["name"]);
            $definitions['groups']['group'][$gdata[$i]["projet"]]['bg_color'] = $gdata[$i]["bg_color"];
            $definitions['groups']['group'][$gdata[$i]["projet"]]['start'] = mktime(0,0,0,substr($gdata[$i]["date_begin"], 5, 2),substr($gdata[$i]["date_begin"], 8, 2),substr($gdata[$i]["date_begin"], 0, 4));
            $definitions['groups']['group'][$gdata[$i]["projet"]]['end'] = mktime(0,0,0,substr($gdata[$i]["date_end"], 5, 2),substr($gdata[$i]["date_end"], 8, 2),substr($gdata[$i]["date_end"], 0, 4));
            if (isset($gdata[$i]["advance"])) 
               $definitions['groups']['group'][$gdata[$i]["projet"]]['progress'] = $gdata[$i]["advance"];
            
         } else if ($gdata[$i]["type"]=='phase') { // Tache
            $definitions['groups']['group'][$gdata[$i]["projet"]]['phase'][$gdata[$i]["task"]] = $gdata[$i]["task"];
            $definitions['planned']['phase'][$gdata[$i]["task"]]['name'] = self::dropAccent((strlen($gdata[$i]["name"])>60) ? substr($gdata[$i]["name"],0,58)."..." : $gdata[$i]["name"]);

            $definitions['planned']['phase'][$gdata[$i]["task"]]['start'] = mktime(0,0,0,substr($gdata[$i]["begin"], 5, 2),substr($gdata[$i]["begin"], 8, 2),substr($gdata[$i]["begin"], 0, 4));
            $definitions['planned']['phase'][$gdata[$i]["task"]]['end'] = mktime(0,0,0,substr($gdata[$i]["end"], 5, 2),substr($gdata[$i]["end"], 8, 2),substr($gdata[$i]["end"], 0, 4));
            $definitions['planned']['phase'][$gdata[$i]["task"]]['bg_color']=$gdata[$i]["bg_color"];
            /*if ($gdata[$i]["planned"]!='1') {
               $definitions['planned_adjusted']['phase'][$gdata[$i]["task"]]['start'] = mktime(0,0,0,substr($gdata[$i]["date_begin"], 5, 2),substr($gdata[$i]["date_begin"], 8, 2),substr($gdata[$i]["date_begin"], 0, 4));
               $definitions['planned_adjusted']['phase'][$gdata[$i]["task"]]['end'] = mktime(0,0,0,substr($gdata[$i]["date_end"], 5, 2),substr($gdata[$i]["date_end"], 8, 2),substr($gdata[$i]["date_end"], 0, 4));
               $definitions['planned_adjusted']['phase'][$gdata[$i]["task"]]['color']=$gdata[$i]["bg_color"];
            }*/
            //if (isset($gdata[$i]["realstart"])) $definitions['real']['phase'][$gdata[$i]["projet"]]['start'] = mktime(0,0,0,substr($gdata[$i][9], 5, 2),substr($gdata[$i][9], 8, 2),substr($gdata[$i][9], 0, 4));
            //if (isset($gdata[$i]["realend"])) $definitions['real']['phase'][$gdata[$i]["projet"]]['end'] = mktime(0,0,0,substr($gdata[$i][10], 5, 2),substr($gdata[$i][10], 8, 2),substr($gdata[$i][10], 0, 4));
            if (isset($gdata[$i]["advance"])) 
                  $definitions['progress']['phase'][$gdata[$i]["task"]]['progress']=$gdata[$i]["advance"];
                  
         } else if ($gdata[$i]["type"]=='milestone') { // Point Important
            $definitions['groups']['group'][$gdata[$i]["projet"]]['phase'][$gdata[$i]["task"]]=$gdata[$i]["task"];
            $definitions['milestone']['phase'][$gdata[$i]["task"]]['title']=self::dropAccent((strlen($gdata[$i]["name"])>27) ? substr($gdata[$i]["name"],0,24)."..." : $gdata[$i]["name"]);
            $definitions['milestone']['phase'][$gdata[$i]["task"]]['data']= mktime(0,0,0,substr($gdata[$i]["date_begin"], 5, 2),substr($gdata[$i]["date_begin"], 8, 2),substr($gdata[$i]["date_begin"], 0, 4));
         } else if ($gdata[$i]["type"]=='dependency') { // Dependance
            $definitions['dependency'][$gdata[$i]["projet"]]['type']= 1;
            $definitions['dependency'][$gdata[$i]["projet"]]['phase_from']=$gdata[$i]["date_begin"];
            $definitions['dependency'][$gdata[$i]["projet"]]['phase_to']=$gdata[$i]["name"];
         }
      }

      $ImgName = sprintf("gantt-%08x.png", rand());

      $definitions['image']['type']= 'png'; 
      $definitions['image']['filename'] = GLPI_PLUGIN_DOC_DIR."/projet/".$ImgName;

      new gantt($definitions);

      return $ImgName;

   }
   
   /**
    * Show for PDF an projet
    * 
    * @param $pdf object for the output
    * @param $ID of the projet
    */
   function mainPdf ($pdf, $ID) {
      global $LANG;
      
      if (!$this->getFromDB($ID)) return false;
      
      $pdf->setColumnsSize(100);
      $col1 = '<b>'.$LANG["common"][2].' '.$this->fields['id'].'</b>';
      $pdf->displayTitle($col1);
      
      $pdf->displayLine(
         '<b><i>'.$LANG['plugin_projet'][0].' :</i></b> '.$this->fields['name']);
      $pdf->setColumnsSize(50,50);
      $pdf->displayLine(
         '<b><i>'.$LANG['common'][34].' :</i></b> '.html_clean(getUserName($this->fields["users_id"])),
         '<b><i>'.$LANG['common'][35].' :</i></b> '.html_clean(Dropdown::getDropdownName('glpi_groups',$this->fields["groups_id"])));
      
      $pdf->displayLine(
         '<b><i>'.$LANG['search'][8].' :</i></b> '.convDate($this->fields["date_begin"]),
         '<b><i>'.$LANG['search'][9].' :</i></b> '.convDate($this->fields["date_end"]));
      
      $pdf->displayLine(
         '<b><i>'.$LANG['plugin_projet'][19].' :</i></b> '.Dropdown::getDropdownName("glpi_plugin_projet_projetstates",$this->fields['plugin_projet_projetstates_id']),
         '<b><i>'.$LANG['plugin_projet'][47].' :</i></b> '.PluginProjetProjet::displayProgressBar('100',$this->fields["advance"],array("simple"=>true)));

      $pdf->setColumnsSize(100);

      $pdf->displayText('<b><i>'.$LANG['plugin_projet'][2].' :</i></b>', $this->fields['comment']);
      
      $pdf->setColumnsSize(100);

      $pdf->displayText('<b><i>'.$LANG['plugin_projet'][10].' :</i></b>', $this->fields['description']);
      
      $pdf->displaySpace();
   }
   
   /**
    * Show for PDF an projet
    * 
    * @param $pdf object for the output
    * @param $ID of the projet
    */
   function GanttPdf ($pdf, $ID) {
       global $LANG,$CFG_GLPI,$gtitle,$gdata,$gconst,$gdate_begin,$gdate_end;
      
      if (!$this->getFromDB($ID)) return false;
      
      //nom
      $gantt_p_name= $this->fields["name"];
      //type de gantt    
      $int = hexdec(PluginProjetProjetState::getStatusColor($this->fields["plugin_projet_projetstates_id"]));
      $gantt_p_bgcolor = array(0xFF & ($int >> 0x10), 0xFF & ($int >> 0x8), 0xFF & $int);
            
      $gantt_p_date_begin=date("Y-m-d");
      $gantt_p_date_end=date("Y-m-d");
      if (!empty($this->fields["date_begin"])) {
         $gantt_p_date_begin=$this->fields["date_begin"];
      }
      if (!empty($this->fields["date_end"])) {
         $gantt_p_date_end=$this->fields["date_end"];
      }
      
      $gdata[]=array("type"=>'group',
                     "projet"=>$ID,
                     "name"=>$gantt_p_name,
                     "date_begin"=>$gantt_p_date_begin,
                     "date_end"=>$gantt_p_date_end,
                     "advance"=>$this->fields["advance"],
                     "bg_color"=>$gantt_p_bgcolor);

      PluginProjetTask::showTaskTreeGantt(array('plugin_projet_projets_id'=>$ID));
      
      if (!empty($gdate_begin) && !empty($gdate_end)) {
         $gtitle=$gtitle."<DateBeg> / <DateEnd>";
         $gdate_begin=date("Y",$gdate_begin)."-".date("m",$gdate_begin)."-".date("d",$gdate_begin);
         $gdate_end=date("Y",$gdate_end)."-".date("m",$gdate_end)."-".date("d",$gdate_end);
      }
      $ImgName=self::writeGantt($gtitle,$gdata,$gconst,$gdate_begin,$gdate_end);

      $image = GLPI_PLUGIN_DOC_DIR."/projet/".$ImgName;

      $pdf->newPage();

      $pdf->setColumnsSize(100);
      $pdf->displayTitle('<b>'.$LANG['plugin_projet']['title'][5].'</b>');
      $size = GetImageSize($image);
      $src_w = $size[0];
      $src_h = $size[1];
      $pdf->addPngFromFile($image,$src_w/2,$src_h/2);
      $pdf->newPage();
      unlink($image);

   }
   
   /**
    * Show for PDF an projet - Hierarchy
    * 
    * @param $pdf object for the output
    * @param $ID of the projet
    */
   function HierarchyPdf($pdf, $item,$parents=0) {
      global $DB,$CFG_GLPI, $LANG;
      
      $ID = $item->getField('id');
      
      if (!$this->canView())	return false;

      $PluginProjetProjet=new PluginProjetProjet();
      if (!$PluginProjetProjet->getFromDB($ID)) return false;

      $pdf->setColumnsSize(100);
      if ($parents) {
         $pdf->displayTitle('<b>'.$LANG['plugin_projet'][44].'</b>');
      } else {
         $pdf->displayTitle('<b>'.$LANG['plugin_projet'][45].'</b>');
      }

      $first=false;
      $query = "SELECT `".$this->gettable()."`.*  ";
      if ($parents!=0)
         $query.= " ,`parent_table`.`name` AS plugin_projet_projets_id,`parent_table`.`id` AS projet_id_id ";
         
      $query.= " FROM `".$this->gettable()."`";
      if ($parents!=0){
         $query.= " LEFT JOIN `".$this->gettable()."` AS parent_table ON (`parent_table`.`plugin_projet_projets_id` = `".$this->gettable()."`.`id`)";
         $query.= " WHERE `parent_table`.`id` = '$ID' ";
      } else {
         $query.= " WHERE `".$this->gettable()."`.`plugin_projet_projets_id` = '$ID' ";
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
      $LINK= " AND " ;    
      $query.=getEntitiesRestrictRequest(" AND ",$this->gettable(),'','',$this->maybeRecursive());
            
      $query.= " ORDER BY `".$this->gettable()."`.`name`";
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
               $LANG['search'][8],
               $LANG['search'][9].'</i></b>'
               );
         } else {
            $pdf->setColumnsSize(20,17,17,17,17);
            $pdf->displayTitle(
               '<b><i>'.$LANG['plugin_projet'][0],
               $LANG['common'][16],
               $LANG['plugin_projet'][47],
               $LANG['plugin_projet'][19],
               $LANG['search'][8],
               $LANG['search'][9].'</i></b>'
               );
         }
         
         while ($data=$DB->fetch_array($result)) {
         
            $items_id_display="";
            if ($_SESSION["glpiis_ids_visible"]||empty($data["name"])) $items_id_display= " (".$data["id"].")";
            $name=$data["name"].$items_id_display;
            
            $entity=html_clean(Dropdown::getDropdownName("glpi_entities",$data['entities_id']));
               
            if (isMultiEntitiesMode()) {
               $pdf->setColumnsSize(17,17,17,17,16,16);
               $pdf->displayLine(
                  $name,
                  $entity,
                  PluginProjetProjet::displayProgressBar('100',$data["advance"],array("simple"=>true)),
                  Dropdown::getDropdownName("glpi_plugin_projet_projetstates",$data['plugin_projet_projetstates_id']),
                  convdate($data["date_begin"]),
                  convdate($data["date_end"])
                  );
            } else {
               $pdf->setColumnsSize(20,17,17,17,17);
               $pdf->displayTitle(
                  $name,
                  PluginProjetProjet::displayProgressBar('100',$data["advance"],array("simple"=>true)),
                  Dropdown::getDropdownName("glpi_plugin_projet_projetstates",$data['plugin_projet_projetstates_id']),
                  convdate($data["date_begin"]),
                  convdate($data["date_end"])
                  );
            }
         }
      }
      $pdf->displaySpace();
   }
}

?>