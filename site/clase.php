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

define('JPATH_BASE_LDJE', dirname(__DIR__, 2));

require_once(JPATH_BASE_LDJE . '/includes/defines.php');
require_once(JPATH_BASE_LDJE . '/includes/framework.php');

use Joomla\CMS\Factory;
use Joomla\CMS\Log\Log;

class Configuration
{
    private $idConfiguration;
    private $name;
    private $username;
    private $password;
    private $url;
    private $ldFolderID;
    private $accessLevel;
    private $accessPassword;
    private $icon = 0;
    private $size = 0;
    private $updateDate = 0;
    private $author = 0;
    private $version = 0;
    private $showEntries;

    public function __construct($id = 0)
    {
        // declara el constructor, si trae el numero de cliente lo busca , si no, trae todos los clientes
        if ($id != 0) {

			try {
				// Get a db connection.
				$db = Factory::getDbo();

				// Select one record from table #__logicaldoc_configuration where idConfiguration = $id
				// Order it by the ordering field.
				$query = "SELECT idConfiguration, name, username, password, url FROM #__logicaldoc_configuration WHERE idConfiguration = " . $id;

				// Reset the query using our newly populated query object.
				$db->setQuery($query);

				// Load the results as a list of stdClass objects (see later for more options on retrieving data).
				$row = $db->loadRow();

				$this->idConfiguration = $row[0];
				$this->name = $row[1];
				$this->username = $row[2];
				$this->password = $row[3];
				$this->url = $row[4];
			} catch (Throwable $t) {
				echo $t->getTraceAsString();
                Log::add($t->getMessage(), Log::ERROR);
			}
        }
    }

    public function getUsuario()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getURL()
    {
        return $this->url;
    }

}
?>
