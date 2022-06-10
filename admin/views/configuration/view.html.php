<?php

/**
 *  
 * Copyright (c) 2006-2022 LogicalDOC
 * WebSites: www.logicaldoc.com
 * 
 * No bytes were intentionally harmed during the development of this application.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class LogicalDOCViewConfiguration extends JViewLegacy {

    public function display($tpl = null) {
        $layout = JRequest::getVar('layout');
        if ($layout == 'formconfiguration') {
            require_once (JPATH_COMPONENT . DS . 'tables' . DS . 'configuration.php');
            $row = JTable::getInstance('Configuration', 'Table');
            $row->load(JRequest::getVar('id'));
            $this->assignRef('row', $row);

            require_once (JPATH_COMPONENT . DS . 'models' . DS . 'configuration.php');
            $modelConfiguration = new LogicalDOCModelConfiguration();
            $rows = $modelConfiguration->getObjects();
            $this->assignRef('rows', $rows);
        } else if ($layout == 'listconfiguration') {
            require_once (JPATH_COMPONENT . DS . 'models' . DS . 'configuration.php');
            $modelConfiguration = new LogicalDOCModelConfiguration();
            $rows = $modelConfiguration->getObjects();
            $this->assignRef('rows', $rows);
        }
        JToolBarHelper::title('Configuration');
        parent::display($tpl);
    }

}

?>
