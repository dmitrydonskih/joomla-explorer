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
use Joomla\CMS\Language\Text;
use Joomla\CMS\Table\Table;
use Joomla\CMS\MVC\Controller\BaseController;

class LogicalDOCControllerExplorer extends BaseController
{
    public function folder()
    {
        Factory::getApplication()->input->set('view', 'explorer');
        Factory::getApplication()->input->set('layout', 'view');
        $entrar = 1;
        Factory::getApplication()->input->set('entrar', $entrar);
        $this->display();
    }

    public function display($cachable = false, $urlparams = false)
    {
        parent::display();
    }
    
    public function downloadLong()
    {
        require_once(JPATH_COMPONENT . '/clase.php');
        require_once(JPATH_COMPONENT . '/IconSelector.php');

        $configID = Factory::getApplication()->input->get('id');
        $docID = Factory::getApplication()->input->get('documentID');

        $modelConfiguration = new Configuration($configID);
        $user = $user = $modelConfiguration->getUsuario();
        $password = $modelConfiguration->getPassword();
        $url = $modelConfiguration->getURL();

        // Register WSDL
        $LDAuth = new SoapClient($url . '/services/Auth?wsdl');

        // Login
        $loginResp = $LDAuth->login(array('username' => $user, 'password' => $password));
        $token = $loginResp->return;
        $LDDocument = new SoapClient($url . '/services/Document?wsdl');
        $getPropertiesResp = $LDDocument->getDocument(array('sid' => $token, 'docId' => $docID));
        $properties = $getPropertiesResp->document;
        $getContent = $LDDocument->getContent(array('sid' => $token, 'docId' => $docID));
        $content = $getContent->return;
        $fileSize = $properties->fileSize;

        ob_end_clean();

        header("Expires: 0"); // Date in the past
        header("Cache-Control: must-revalidate"); // HTTP/1.1
        header('Pragma: public');
        header('Content-Description: File Transfer');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        header('Content-length: ' . $fileSize);

        $mimeType = IconSelector::get_mime_type($properties->type);
        header('Content-Type: ' . $mimeType);
        header('Content-Disposition: attachment; filename="' . $properties->fileName . '"');

        echo $content;
        exit();
    }

    public function download()
    {
        ob_end_clean();
        require_once(JPATH_COMPONENT . '/download.php');
        exit();
    }

    public function enviar()
    {
        require_once(JPATH_COMPONENT . '/tables/configuration.php');
        $rowConfiguration = Table::getInstance('Configuration', 'Table');
        $id = Factory::getApplication()->input->get('id');
        $rowConfiguration->load($id);
        $accessPassword = $rowConfiguration->accessPassword;
        $acceder = Factory::getApplication()->input->get('accessPassword');
        Factory::getApplication()->input->set('view', 'explorer');
        Factory::getApplication()->input->set('layout', 'view');
        $entrar = 0;
        $mensaje = Text::_('COM_LOGICALDOC_INCORRECT_PASSWORD');
        if (substr_compare($accessPassword, $acceder, 0) == 0) {
            $entrar = 1;
            $mensaje = Text::_('COM_LOGICALDOC_CORRECT_PASSWORD');
        }
        Factory::getApplication()->input->set('entrar', $entrar);
        Factory::getApplication()->input->set('mensaje', $mensaje);
        $this->display();
    }

    public function searchBasic()
    {
        Factory::getApplication()->input->set('view', 'search');
        Factory::getApplication()->input->set('layout', 'result');
        Factory::getApplication()->input->set('contenido', Factory::getApplication()->input->get('contenido','','string'));
        Factory::getApplication()->input->set('documento', Factory::getApplication()->input->get('documento'));
        Factory::getApplication()->input->set('carpeta', Factory::getApplication()->input->get('carpeta'));
        $this->display();
    }

    public function returnDesktop()
    {
        Factory::getApplication()->input->set('view', 'explorer');
        Factory::getApplication()->input->set('layout', 'view');
        $entrar = 1;
        Factory::getApplication()->input->set('entrar', $entrar);
        $this->display();
    }
}

?>

