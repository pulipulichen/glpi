<?php
/*
 * @version $Id: ruledictionnarycomputermodelcollection.class.php 14684 2011-06-11 06:32:40Z remi $
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2011 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI; if not, write to the Free Software Foundation, Inc.,
 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 --------------------------------------------------------------------------
 */

// ----------------------------------------------------------------------
// Original Author of file: Walid Nouh
// Purpose of file:
// ----------------------------------------------------------------------

class RuleDictionnaryComputerModelCollection extends RuleDictionnaryDropdownCollection {

   // From RuleCollection
   //public $rule_class_name = 'RuleDictionnaryComputerModel';

   // Specific ones
   /// dropdown table
   var $item_table = "";

   /**
    * Constructor
   **/
   function __construct() {

      $this->item_table="glpi_computermodels";
      //Init cache system values
      $this->initCache("glpi_rulecachecomputermodels", array("name"         => "old_value",
                                                             "manufacturer" => "manufacturer"));
      $this->menu_option="model.computer";
   }


   function getTitle() {
      global $LANG;

      return $LANG['rulesengine'][50];
   }

}
?>
