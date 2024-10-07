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
defined('_JEXEC') or die('Restricted access');

class Com_LogicalDOCInstallerScript
{
    /**
     * Method to run before an install/update/uninstall method.
     *
     * @param string                        $type    The type of change (install, update, discover_install)
     * @param JAdapterInstance $parent The class calling this method
     *
     * @return void
     */
    public function preflight($type, $parent)
    {
        // Check if the SoapClient class exists
        if (!class_exists('SoapClient')) {
            // Display a warning message if SoapClient is not found
            JFactory::getApplication()->enqueueMessage('Warning: php-soap not installed. It is needed for this extension to operate correctly.', 'warning');
        }
    }
}
