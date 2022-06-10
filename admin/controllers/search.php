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

class LogicalDOCControllerSearch extends JControllerLegacy {

    public function display($cachable = false, $urlparams = false) {
        parent::display();
    }

    public function searchAdvanced() {
        JRequest::setVar('view', 'search');
        JRequest::setVar('layout', 'result');
        JRequest::setVar('contenido', JRequest::getVar('contenido'));
        JRequest::setVar('nombre', JRequest::getVar('nombre'));
        JRequest::setVar('palabraClave', JRequest::getVar('palabraClave'));
        JRequest::setVar('documento', JRequest::getVar('documento'));
        JRequest::setVar('carpeta', JRequest::getVar('carpeta'));
        JRequest::setVar('correoElectronico', JRequest::getVar('correoElectronico'));
        JRequest::setVar('tipoDocumento', JRequest::getVar('tipoDocumento'));
        $this->display();
    }

    public function returnDesktop() {

        //$exitemid = JRequest::getVar('Itemid');
        //error_log("exitemid: " .$exitemid);

        JRequest::setVar('view', 'explorer');
        JRequest::setVar('layout', 'view');
        $entrar = 1;
        JRequest::setVar('entrar', $entrar);
        $this->display();
    }

}

?>
