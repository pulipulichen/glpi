RENAME TABLE `glpi_plugin_project`  TO `glpi_plugin_projet`;
RENAME TABLE `glpi_plugin_project_items`  TO `glpi_plugin_projet_items`;
RENAME TABLE `glpi_plugin_project_tasks`  TO `glpi_plugin_projet_tasks`;
RENAME TABLE `glpi_plugin_project_tasks_items`  TO `glpi_plugin_projet_tasks_items`;
RENAME TABLE `glpi_dropdown_plugin_project_status`  TO `glpi_dropdown_plugin_projet_status`;
RENAME TABLE `glpi_dropdown_plugin_project_tasks_type`  TO `glpi_dropdown_plugin_projet_tasks_type`;
RENAME TABLE `glpi_dropdown_plugin_project_task_status`  TO `glpi_dropdown_plugin_projet_task_status`;
RENAME TABLE `glpi_plugin_project_mailing`  TO `glpi_plugin_projet_mailing`;
RENAME TABLE `glpi_plugin_project_profiles`  TO `glpi_plugin_projet_profiles`;
UPDATE `glpi_plugin_projet_mailing` SET `type` = 'projet' WHERE `type` = 'project';
ALTER TABLE `glpi_plugin_projet_items` CHANGE `FK_project` `FK_projet` int(11) NOT NULL default '0';
ALTER TABLE `glpi_plugin_projet_tasks` CHANGE `project` `FK_projet` int(4) NOT NULL default '0';
ALTER TABLE `glpi_plugin_projet_items` DROP INDEX `FK_project`, ADD INDEX `FK_projet` ( `FK_projet` );
ALTER TABLE `glpi_plugin_projet_items` DROP INDEX `FK_device`, ADD INDEX `FK_device` ( `FK_device` , `FK_projet` );
ALTER TABLE `glpi_plugin_projet` ADD `recursive` tinyint(1) NOT NULL default '0' AFTER `FK_entities`;