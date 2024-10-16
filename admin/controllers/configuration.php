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

jimport('joomla.application.component.controller');

use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;

class LogicalDOCControllerConfiguration extends BaseController {

    public function display($cachable = false,$urlparams = false) {
        parent::display();
    }

    public function buscar() {
        require_once (JPATH_COMPONENT . '/tables/configuration.php');
        $row = Table::getInstance('Configuration', 'Table');
    
        // Load the data from the database
        $idConfiguration = Factory::getApplication()->input->getInt('idConfiguration', 0);
    
        if ($idConfiguration) {
            $row->load($idConfiguration);
            $password = $row->password;
            $accessPassword = $row->accessPassword;
        }
    
        // Get the data from the request
        $postData = Factory::getApplication()->input->post->getArray();

        // Bind the data to the table object
        if (!$row->bind($postData)) {
            Factory::getApplication()->enqueueMessage($row->getError(), 'error');
        }
    
        // If the password is not provided in the request, restore the original value
        if ($idConfiguration) {
            $passwordBind = $row->password;
            if ($passwordBind == '') {
                $row->password = $password;
            }
    
            $accessPasswordBind = $row->accessPassword;
            if ($accessPasswordBind == '') {
                $row->accessPassword = $accessPassword;
            }
        }
    
        // Store the data in the database
        if (!$row->store()) {
            Factory::getApplication()->enqueueMessage($row->getError(), 'error');
        }
    
        $this->setRedirect('index.php?option=com_logicaldoc&view=configuration&layout=listconfiguration', Text::_('COM_LOGICALDOC_UPDATED'));
    }
    

    public function delete() {
        require_once (JPATH_COMPONENT . '/tables/configuration.php');
        $row = Table::getInstance('Configuration', 'Table');
        $row->idConfiguration = Factory::getApplication()->input->get('id');
        if (!$row->delete()) {
            Factory::getApplication()->enqueueMessage($row->getError(), 'error');
        }
        $this->setRedirect('index.php?option=com_logicaldoc&view=configuration&layout=listconfiguration', Text::_('COM_LOGICALDOC_DELETED'));
    }

    public function edit() {
        Factory::getApplication()->input->set('view', 'configuration');
        Factory::getApplication()->input->set('layout', 'formconfiguration');
        $this->display();
    }

    public function test() {
        require_once (JPATH_COMPONENT . '/tables/configuration.php');
        $row = Table::getInstance('Configuration', 'Table');
        $id = Factory::getApplication()->input->get('id');
        $row->load($id);
        $user = $row->username;
        $password = $row->password;
        $url = $row->url;
        $message = "";
        try {
            $LDAuth = new SoapClient($url . '/services/Auth?wsdl');
            // Login
            $loginResp = $LDAuth->login(array('username' => $user, 'password' => $password));
            $token = $loginResp->return;
            $LDAuth->logout(array('sid' => $token));
            $message = Text::_('COM_LOGICALDOC_CONNECTION_SUCCEEDED');
        } catch (Exception $e) {
            $message = Text::_('COM_LOGICALDOC_CANNOT_ESTABLISH_A_CONNECTION');
        }
        $this->setRedirect('index.php?option=com_logicaldoc&view=configuration&layout=listconfiguration', $message);
    }

    public function accessLevel() {
        require_once (JPATH_COMPONENT . '/tables/configuration.php');
        $row = Table::getInstance('Configuration', 'Table');
        $id = Factory::getApplication()->input->get('id');
        $row->load($id);
        if ($row->accessLevel == 'Private') {
            $row->accessLevel = 'Public';
        } else {
            $row->accessLevel = 'Private';
        }
        if (!$row->store()) {
            Factory::getApplication()->enqueueMessage($row->getError(), 'error');
        }
        $this->setRedirect('index.php?option=com_logicaldoc&view=configuration&layout=listconfiguration', Text::_('COM_LOGICALDOC_GUARDED'));
    }

    public function cancel() {
        $this->setRedirect('index.php?option=com_logicaldoc&view=configuration&layout=listconfiguration');
    }

}

?>
