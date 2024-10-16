<?php

/**
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

jimport('joomla.application.component.view');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\HtmlView;

class LogicalDOCViewExplorer extends HtmlView
{
    public function display($tpl = null)
    {
        $layout = Factory::getApplication()->input->get('layout');
        $app = Factory::getApplication();
        $params = $app->getParams();
        $name = $params->get('name');

        require_once(JPATH_COMPONENT . '/models/configuration.php');
        $modelConfiguration = new LogicalDOCModelConfiguration();
        $rowsCongiguracion = $modelConfiguration->getObject($name);
        $rowConfiguration = $rowsCongiguracion[0];
        $url = $rowConfiguration->url;
        $user = $rowConfiguration->username;
        $password = $rowConfiguration->password;
        $accessLevel = $rowConfiguration->accessLevel;
        $ldFolderID = $rowConfiguration->ldFolderID;
        $this->rowConfiguration = $rowConfiguration;
        $error = 0;
        $entrar = 0;

        if ($layout == 'view') {
            if ($accessLevel == 'Private') {
                $entrar = Factory::getApplication()->input->get("entrar");
                if ($entrar == null) {
                    $entrar = 0;
                }
            } else {
                $entrar = 1;
            }
            if ($entrar == 1) {
                try {
                    // Register WSDL
                    $LDAuth = new SoapClient($url . '/services/Auth?wsdl');

                    // Login
                    $loginResp = $LDAuth->login(array('username' => $user, 'password' => $password));
                    $token = $loginResp->return;
                    $this->token =  $token;

                    $LDDocument = new SoapClient($url . '/services/Document?wsdl');
                    $LDFolder = new SoapClient($url . '/services/Folder?wsdl');

                    $folderID = Factory::getApplication()->input->get('folderID');
                    if ($folderID == '' || $folderID == $ldFolderID) {
                        $folderID = 4;
                    }

                    $session = Factory::getSession();
                    $session->set('folderID', $folderID);

                    $this->LDAuth = $LDAuth;
                    $this->LDDocument = $LDDocument;
                    $this->LDFolder = $LDFolder;

                    $this->folderID = $folderID;
                    $this->error = $error;
                    $this->session = $session;
                } catch (Exception $e) {
                    $error = 1;
                    $this->error = $error;
                }
            }//fin if entrar
            $mensaje = Factory::getApplication()->input->get('mensaje');
            $this->mensaje = $mensaje;
            $this->entrar = $entrar;
        }
        parent::display($tpl);
    }

}

?>
