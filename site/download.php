<?php

/**
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
 
define('_JEXEC', 1); //make j! happy
require_once('clase.php');
require_once('IconSelector.php');
$idCondiguracion = $_GET['id'];
$docID = $_GET['documentID'];

$modelConfiguration = new Configuration();
$modelConfiguration->Configuration($idCondiguracion);

$user = $modelConfiguration->getUsuario();
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

header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header('Pragma: no-cache');

$mimeType = IconSelector::get_mime_type($properties->type);
header('Content-Type: ' . $mimeType);
header('Content-Disposition: attachment; filename="' . $properties->fileName . '"');
echo $content;
?>
