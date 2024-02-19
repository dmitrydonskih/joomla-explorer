<?php

/**
 *  
 * Copyright (c) 2006-2024 LogicalDOC
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

jimport('joomla.application.component.controller');

class LogicalDOCControllerExplorer extends JControllerLegacy {

    public function display($cachable = false, $urlparams = false) {
        parent::display();
    }

    public function folder() {
        JFactory::getApplication()->input->set('view', 'explorer');
        JFactory::getApplication()->input->set('layout', 'view');
        $entrar = 1;
        JFactory::getApplication()->input->set('entrar', $entrar);
        $this->display();
    }

    public function enviar() {
        require_once (JPATH_COMPONENT . DS . 'tables' . DS . 'configuration.php');
        $rowConfiguration = &JTable::getInstance('Configuration', 'Table');
        $id = JFactory::getApplication()->input->get('id');
        $rowConfiguration->load($id);
        $accessPassword = $rowConfiguration->accessPassword;
        $acceder = JFactory::getApplication()->input->get('accessPassword');
        JFactory::getApplication()->input->set('view', 'explorer');
        JFactory::getApplication()->input->set('layout', 'view');
        $entrar = 0;
        $mensaje = JText::_('COM_LOGICALDOC_INCORRECT_PASSWORD');
        if (substr_compare($accessPassword, $acceder, 0) == 0) {
            $entrar = 1;
            $mensaje = JText::_('COM_LOGICALDOC_CORRECT_PASSWORD');
        }
        JFactory::getApplication()->input->set('entrar', $entrar);
        JFactory::getApplication()->input->set('mensaje', $mensaje);
        $this->display();
    }

    public function download() {
        JFactory::getApplication()->input->set('view', 'explorer');
        JFactory::getApplication()->input->set('layout', 'download');
        $this->display();
    }

    public function searchBasic() {
        error_log('explorer.php searchBasic()');  
        JFactory::getApplication()->input->set('view', 'search');
        JFactory::getApplication()->input->set('layout', 'result');
        JFactory::getApplication()->input->set('contenido', JRequest::getVar('contenido'));
        JFactory::getApplication()->input->set('documento', JRequest::getVar('documento'));
        JFactory::getApplication()->input->set('carpeta', JRequest::getVar('carpeta'));
        $this->display();
    }

    public function returnDesktop() {
        JFactory::getApplication()->input->set('view', 'explorer');
        JFactory::getApplication()->input->set('layout', 'view');
        $entrar = 1;
        JFactory::getApplication()->input->set('entrar', $entrar);
        $this->display();
    }

}

?>
