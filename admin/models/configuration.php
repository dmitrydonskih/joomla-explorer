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

jimport('joomla.application.component.model');

use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class LogicalDOCModelConfiguration extends BaseDatabaseModel {

    private $_data = null;

    public function getObjects() {
        $query = "SELECT * FROM #__logicaldoc_configuration";
        $this->_data = $this->_getList($query);
        return $this->_data;
    }

    public function getObject($name) {
        $query = "SELECT * FROM #__logicaldoc_configuration WHERE name = '" . $name . "'";
        $this->_data = $this->_getList($query);
        return $this->_data;
    }

}

?>
