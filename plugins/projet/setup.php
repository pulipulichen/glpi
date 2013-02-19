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

// Init the hooks of the plugins -Needed
function plugin_init_projet() {
	global $PLUGIN_HOOKS,$CFG_GLPI,$LANG;
	
	$PLUGIN_HOOKS['change_profile']['projet'] = array('PluginProjetProfile','changeProfile');
	$PLUGIN_HOOKS['assign_to_ticket']['projet'] = true;
	
	if (class_exists('PluginProjetProjet_Item')) { // only if plugin activated
      $PLUGIN_HOOKS['pre_item_purge']['projet'] = array('Profile'=>array('PluginProjetProfile', 'purgeProfiles'));
      $PLUGIN_HOOKS['item_purge']['projet'] = array();
      foreach (PluginProjetProjet::getTypes(true) as $type) {
         $PLUGIN_HOOKS['item_purge']['projet'][$type] = 'plugin_item_purge_projet';
      }
   }
   
	// Params : plugin name - string type - number - class - table - form page
	Plugin::registerClass('PluginProjetProjet', array(
		'linkgroup_types' => true,
		'linkuser_types' => true,
		'doc_types' => true,
		'contract_types' => true,
		'helpdesk_types'         => true,
		'helpdesk_visible_types' => true,
		'notificationtemplates_types' => true
   ));
   
   Plugin::registerClass('PluginProjetTaskPlanning', array(
         'planning_types' => true
      ));
	
	if (getLoginUserID()) {
		
		// Display a menu entry ?
		if (plugin_projet_haveRight("projet","r")) {
			$PLUGIN_HOOKS['menu_entry']['projet'] = 'front/projet.php';
			$PLUGIN_HOOKS['submenu_entry']['projet']['search'] = 'front/projet.php';
			$PLUGIN_HOOKS['headings_actionpdf']['projet'] = 'plugin_headings_actionpdf_projet';
			$PLUGIN_HOOKS['redirect_page']['projet'] = "front/projet.form.php";	
		}
		if (plugin_projet_haveRight("projet","r") || haveRight("config","w")) {
			$PLUGIN_HOOKS['headings']['projet'] = 'plugin_get_headings_projet';
         $PLUGIN_HOOKS['headings_action']['projet'] = 'plugin_headings_actions_projet';
		}

		if (plugin_projet_haveRight("projet","w")) {
			$PLUGIN_HOOKS['submenu_entry']['projet']['add'] = 'front/setup.templates.php?add=1';
         $PLUGIN_HOOKS['submenu_entry']['projet']['template'] = 'front/setup.templates.php?add=0';
         $PLUGIN_HOOKS['submenu_entry']['projet']["<img  src='".$CFG_GLPI["root_doc"]."/pics/menu_showall.png' title='".$LANG['plugin_projet'][68]."' alt='".$LANG['plugin_projet'][68]."'>"] = 'front/task.php';
			$PLUGIN_HOOKS['use_massive_action']['projet']=1;
		}
		
		// Config page
		/*if (plugin_projet_haveRight("projet","w") || haveRight("config","w")) {
			$PLUGIN_HOOKS['config_page']['projet'] = 'front/config.form.php';			
         $PLUGIN_HOOKS['submenu_entry']['projet']['config'] = 'front/config.form.php';
      }*/
		
	}
	
	// Add specific files to add to the header : javascript or css
   //$PLUGIN_HOOKS['add_javascript']['example']="example.js";
   $PLUGIN_HOOKS['add_css']['projet']="projet.css";
   $PLUGIN_HOOKS['plugin_pdf']['PluginProjetProjet']='projet';
		
	//Planning hook
	$PLUGIN_HOOKS['planning_populate']['projet']=array('PluginProjetTaskPlanning','populatePlanning');
	$PLUGIN_HOOKS['display_planning']['projet']=array('PluginProjetTaskPlanning','displayPlanningItem');
}

// Get the name and the version of the plugin - Needed
function plugin_version_projet() {
	global $LANG;

	return array (
		'name' => $LANG['plugin_projet']['title'][1],
		'version' => '1.2.0',
		'license' => 'GPLv2+',
		'author'=>'Xavier Caillaud & <a href="mailto:d.durieux@siprossii.com">David DURIEUX</a>',
		'homepage'=>'https://forge.indepnet.net/projects/show/projet',
		'minGlpiVersion' => '0.80',// For compatibility / no install in version < 0.80
	);
}

// Optional : check prerequisites before install : may print errors or add to message after redirect
function plugin_projet_check_prerequisites() {
	if (version_compare(GLPI_VERSION,'0.80','lt') || version_compare(GLPI_VERSION,'0.81','ge')) {
      echo "This plugin requires GLPI >= 0.80";
      return false;
   }
   return true;
}

// Uninstall process for plugin : need to return true if succeeded : may display messages or add to message after redirect
function plugin_projet_check_config(){
	return true;
}

//////////////////////////////// Define rights for the plugin types

function plugin_projet_haveRight($module,$right) {
	$matches=array(
			""  => array("","r","w"), // ne doit pas arriver normalement
			"r" => array("r","w"),
			"w" => array("w"),
			"1" => array("1"),
			"0" => array("0","1"), // ne doit pas arriver non plus
		      );
	if (isset($_SESSION["glpi_plugin_projet_profile"][$module])
         &&in_array($_SESSION["glpi_plugin_projet_profile"][$module],$matches[$right]))
		return true;
	else return false;
}

?>