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

jimport('joomla.application.component.controller');

class LogicalDOCControllerExplorer extends JControllerLegacy
{
    public function display($cachable = false, $urlparams = false)
    {
        parent::display();
    }

    public function folder()
    {
        JRequest::setVar('view', 'explorer');
        JRequest::setVar('layout', 'view');
        $entrar = 1;
        JRequest::setVar('entrar', $entrar);
        $this->display();
    }

    public function enviar()
    {
        require_once(JPATH_COMPONENT . DS . 'tables' . DS . 'configuration.php');
        $rowConfiguration = &JTable::getInstance('Configuration', 'Table');
        $id = JRequest::getVar('id');
        $rowConfiguration->load($id);
        $accessPassword = $rowConfiguration->accessPassword;
        $acceder = JRequest::getVar('accessPassword');
        JRequest::setVar('view', 'explorer');
        JRequest::setVar('layout', 'view');
        $entrar = 0;
        $mensaje = JText::_('COM_LOGICALDOC_INCORRECT_PASSWORD');
        if (substr_compare($accessPassword, $acceder, 0) == 0) {
            $entrar = 1;
            $mensaje = JText::_('COM_LOGICALDOC_CORRECT_PASSWORD');
        }
        JRequest::setVar('entrar', $entrar);
        JRequest::setVar('mensaje', $mensaje);
        $this->display();
    }

    public function download()
    {
        JRequest::setVar('view', 'explorer');
        JRequest::setVar('layout', 'download');
        $this->display();
    }

    public function searchBasic()
    {
        error_log('explorer.php searchBasic()');
        JRequest::setVar('view', 'search');
        JRequest::setVar('layout', 'result');
        JRequest::setVar('contenido', JRequest::getVar('contenido'));
        JRequest::setVar('documento', JRequest::getVar('documento'));
        JRequest::setVar('carpeta', JRequest::getVar('carpeta'));
        $this->display();
    }

    public function returnDesktop()
    {
        JRequest::setVar('view', 'explorer');
        JRequest::setVar('layout', 'view');
        $entrar = 1;
        JRequest::setVar('entrar', $entrar);
        $this->display();
    }

}

?>
