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

class LogicalDOCControllerSearch extends JControllerLegacy {

    public function display($cachable = false, $urlparams = false) {
        parent::display();
    }

    public function searchAdvanced() {
        JFactory::getApplication()->input->set('view', 'search');
        JFactory::getApplication()->input->set('layout', 'result');
        JFactory::getApplication()->input->set('contenido', JFactory::getApplication()->input->get('contenido'));
        JFactory::getApplication()->input->set('nombre', JFactory::getApplication()->input->get('nombre'));
        JFactory::getApplication()->input->set('palabraClave', JFactory::getApplication()->input->get('palabraClave'));
        JFactory::getApplication()->input->set('documento', JFactory::getApplication()->input->get('documento'));
        JFactory::getApplication()->input->set('carpeta', JFactory::getApplication()->input->get('carpeta'));
        JFactory::getApplication()->input->set('correoElectronico', JFactory::getApplication()->input->get('correoElectronico'));
        JFactory::getApplication()->input->set('tipoDocumento', JFactory::getApplication()->input->get('tipoDocumento'));
        $this->display();
    }

    public function returnDesktop() {

        //$exitemid = JRequest::getVar('Itemid');
        //error_log("exitemid: " .$exitemid);

        JFactory::getApplication()->input->set('view', 'explorer');
        JFactory::getApplication()->input->set('layout', 'view');
        $entrar = 1;
        JFactory::getApplication()->input->set('entrar', $entrar);
        $this->display();
    }

}

?>
