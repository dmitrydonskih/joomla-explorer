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
use Joomla\CMS\Table\Table;

class LogicalDOCViewSearch extends HtmlView
{
    public function display($tpl = null)
    {
        $layout = Factory::getApplication()->input->get('layout');
        $error = 0;
        require_once(JPATH_COMPONENT . '/tables/configuration.php');

        $rowConfiguration = Table::getInstance('Configuration', 'Table');
        $id = Factory::getApplication()->input->get('id');
        $rowConfiguration->load($id);
        $url = $rowConfiguration->url;
        $user = $rowConfiguration->username;
        $password = $rowConfiguration->password;
        $this->rowConfiguration = $rowConfiguration;
        if ($layout == 'result') {
            try {
                $contenido = Factory::getApplication()->input->get('contenido','','string');
                $nombre = Factory::getApplication()->input->get('nombre');
                $palabraClave = Factory::getApplication()->input->get('palabraClave');
                $documento = Factory::getApplication()->input->get('documento');
                $carpeta = Factory::getApplication()->input->get('carpeta');
                $tipoDocumento = Factory::getApplication()->input->get('tipoDocumento','','string');

                $sessionSearch = Factory::getSession();
                $sessionSearch->set('contenido', $contenido);
                $sessionSearch->set('nombre', $nombre);
                $sessionSearch->set('palabraClave', $palabraClave);
                $sessionSearch->set('documento', $documento);
                $sessionSearch->set('carpeta', $carpeta);
                $sessionSearch->set('tipoDocumento', $tipoDocumento);
                $this->sessionSearch = $sessionSearch;

                // Register WSDL
                $LDAuth = new SoapClient($url . '/services/Auth?wsdl');

                // Login
                $loginResp = $LDAuth->login(array('username' => $user, 'password' => $password));
                $token = $loginResp->return;

                // Register WSDL
                $LDSearch = new SoapClient($url . '/services/Search?wsdl');

                $soptions = new SearchOptions();

                $scontent = Factory::getApplication()->input->get('contenido');
                $soptions->expression = $scontent;

                // Setup the startfolder (limit the search to just the sub-tree starting from the configured folder)
                $startFolder = $this->rowConfiguration->ldFolderID;

                $sfields = Factory::getApplication()->input->get('sfields', array(), 'array');

                if (!empty($sfields)) {
                    $soptions->fields = $sfields;
                } else {
                    // user searched from the simple search (just filling the field contenido)
                    $soptions->fields = array('content', 'title', 'tags');
                    Factory::getApplication()->input->post->set('sfields', $soptions->fields);
                }

                $findResp = $LDSearch->find(array('sid' => $token, 'options' => $soptions));

                if (!empty($findResp->searchResult->hits)) {
                    $resultArray = $findResp->searchResult->hits;

                    //filter the result in the array based on Document Type        
                    if (!empty($tipoDocumento)) {
                        $resultArray = array();
                        $fdocs = $findResp->searchResult->hits;

                        if (!is_array($fdocs)) {
                            $fdocs = array();
                            $fdocs[] = $findResp->searchResult->hits;
                        }

                        for ($i = 0; $i < count($fdocs); $i++) {
                            $docext = $fdocs[$i]->type;
                            if (!empty($docext)) {
                                $docext = strtolower($docext);
                                if (strpos($tipoDocumento, $docext) !== false) {
                                    $resultArray[] = $fdocs[$i];
                                }
                            }
                        }
                    }
                }

                $LDAuth->logout(array('sid' => $token));
                $this->resultArray = $resultArray ?? array();
                $this->error = $error;
            } catch (Exception $e) {
                $error = 1;
                $this->error = $error;
            }
        }
        parent::display($tpl);
    }

}

class SearchOptions
{

    var $type = 0; // 0 is full-text query
    var $expression = '';
    var $expressionLanguage = 'en';
    var $maxHits = 50;
    //var $language = 'en'; // search documents in english
    var $retrieveAliases = 0; // requested but not used
    var $caseSensitive = 0; // requested but not used
    //var $fields = array ('title','tags','content');
    var $fields = array();
    var $searchInSubPath = true;
    var $folderId = 4; // Default workspace ID
}


?>
