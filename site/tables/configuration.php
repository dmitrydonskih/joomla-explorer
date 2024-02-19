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

class TableConfiguration extends JTable
{
    public $idConfiguration;
    public $name;
    public $username;
    public $password;
    public $url;
    public $ldFolderID;
    public $accessLevel;
    public $accessPassword;
    public $icon = 0;
    public $size = 0;
    public $updateDate = 0;
    public $author = 0;
    public $version = 0;
    public $showEntries;

    public function __construct(&$db)
    {
        parent::__construct('jos_logicaldoc_configuration', 'idConfiguration', $db);
    }

}

?>