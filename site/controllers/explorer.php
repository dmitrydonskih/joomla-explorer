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

class LogicalDOCControllerExplorer extends JControllerLegacy
{
    public function folder()
    {
        JFactory::getApplication()->input->set('view', 'explorer');
        JFactory::getApplication()->input->set('layout', 'view');
        $entrar = 1;
        JFactory::getApplication()->input->set('entrar', $entrar);
        $this->display();
    }

    public function display($cachable = false, $urlparams = false)
    {
        parent::display();
    }
    
    public function document()
    {
        // require_once('clase.php');
        // require_once('IconSelector.php');
        $idCondiguracion = $_GET['id'];
        $docID = $_GET['documentID'];
        // echo $docID;exit;
        // $modelConfiguration = new Configuration();
        if ($idCondiguracion != 0) {
            $db = JFactory::getDbo();
            $query = "SELECT idConfiguration, name, username, password, url FROM jos_logicaldoc_configuration WHERE idConfiguration = " . $idCondiguracion;
            $db->setQuery($query);
            $row = $db->loadRow();
            $this->idConfiguration = $row[0];
            $this->name = $row[1];
            $this->username = $row[2];
            $this->password = $row[3];
            $this->url = $row[4];
        }

        // $modelConfiguration->Configuration($idCondiguracion);
        // $user = $modelConfiguration->getUsuario();
        // $password = $modelConfiguration->getPassword();
        // $url = $modelConfiguration->getURL();
        $user = $this->username;
        $password = $this->password;
        $url = $this->url;

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
        /* echo "<pre>"; print_r($properties); exit; */
        error_reporting(0);
        /* ini_set('display_errors', false); */
        ob_end_clean();

        header("Expires: 0"); // Date in the past
        header("Cache-Control: must-revalidate"); // HTTP/1.1
        header('Pragma: public');
        $mimeType = "application/octet-stream";

        if (!empty($properties->type)) {
            $properties->type = strtolower($properties->type);
        }
        // our list of mime types
        $mime_types = array("pdf" => "application/pdf", "txt" => "text/plain", "gif" => "image/gif", "png" => "image/png", "jpeg,jpg" => "image/jpg", "doc" => "application/msword", "docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "xls" => "application/vnd.ms-excel", "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "ppt" => "application/vnd.ms-powerpoint", "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation", "zip" => "application/zip", "htm,html" => "text/html", "xml" => "application/xml", "eml" => "message/rfc822", "msg" => "application/vnd.ms-outlook", "mp3" => "audio/mpeg", "wav" => "audio/x-wav", "mpeg,mpg,mpe" => "video/mpeg", "mov" => "video/quicktime", "avi" => "video/x-msvideo", "css" => "text/css", "js" => "application/javascript", "php" => "text/html", "exe" => "application/octet-stream"
        );
        foreach ($mime_types as $key => $value) {
            if (strpos($key, $properties->type) !== false) {
                $mimeType = $value;
                break;
            }
        }
        header('Content-Description: File Transfer');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        header('Content-length: ' . $fileSize);
        // $mimeType = IconSelector::get_mime_type($properties->type);
        header('Content-Type: ' . $mimeType);
        header('Content-Disposition: attachment; filename="' . $properties->fileName . '"');
        flush();
        echo $content;
    } 
    
    public function enviar()
    {
        require_once(JPATH_COMPONENT . DS . 'tables' . DS . 'configuration.php');
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

    public function download()
    {
        JFactory::getApplication()->input->set('view', 'explorer');
        JFactory::getApplication()->input->set('layout', 'download');
        $this->display();
    }

    public function searchBasic()
    {
        error_log('explorer.php searchBasic()');
        JFactory::getApplication()->input->set('view', 'search');
        JFactory::getApplication()->input->set('layout', 'result');
        JFactory::getApplication()->input->set('contenido', JFactory::getApplication()->input->get('contenido'));
        JFactory::getApplication()->input->set('documento', JFactory::getApplication()->input->get('documento'));
        JFactory::getApplication()->input->set('carpeta', JFactory::getApplication()->input->get('carpeta'));
        $this->display();
    }

    public function returnDesktop()
    {
        JFactory::getApplication()->input->set('view', 'explorer');
        JFactory::getApplication()->input->set('layout', 'view');
        $entrar = 1;
        JFactory::getApplication()->input->set('entrar', $entrar);
        $this->display();
    }
}

?>

