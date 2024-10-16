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

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;

class LogicalDOCControllerSearch extends BaseController
{
    public function searchAdvanced()
    {
        Factory::getApplication()->input->set('view', 'search');
        Factory::getApplication()->input->set('layout', 'result');
        Factory::getApplication()->input->set('contenido', Factory::getApplication()->input->get('contenido','','string'));
        Factory::getApplication()->input->set('nombre', Factory::getApplication()->input->get('nombre'));
        Factory::getApplication()->input->set('palabraClave', Factory::getApplication()->input->get('palabraClave'));
        Factory::getApplication()->input->set('documento', Factory::getApplication()->input->get('documento'));
        Factory::getApplication()->input->set('carpeta', Factory::getApplication()->input->get('carpeta'));
        Factory::getApplication()->input->set('correoElectronico', Factory::getApplication()->input->get('correoElectronico'));
        Factory::getApplication()->input->set('tipoDocumento', Factory::getApplication()->input->get('tipoDocumento','','string'));
        $this->display();
    }

    public function display($cachable = false, $urlparams = false)
    {
        parent::display();
    }

    public function returnDesktop()
    {
        Factory::getApplication()->input->set('view', 'explorer');
        Factory::getApplication()->input->set('layout', 'view');
        $entrar = 1;
        Factory::getApplication()->input->set('entrar', $entrar);
        $this->display();
    }

    public function download()
    {
        //error_reporting(0);
        ob_end_clean();
        require_once(JPATH_COMPONENT . '/download.php');
        exit();
    }

}

?>
