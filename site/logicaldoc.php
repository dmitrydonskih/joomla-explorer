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

use Joomla\CMS\Factory;
?>
<!--Estilo para la tabla-->
<link type="text/css"
      href="<?= JURI::base(true) . '/components/com_logicaldoc/assets/css/datatables/datatables.ui.css' ?>"
      rel="stylesheet"/>

<link type="text/css"
      href="<?= JURI::base(true) . '/components/com_logicaldoc/assets/css/themes/jquery-ui-1.8.23.custom.css' ?>"
      rel="stylesheet"/>
<!--Estilo para la validacion-->
<link type="text/css"
      href="<?= JURI::base(true) . '/components/com_logicaldoc/assets/css/validationEngine.jquery.css' ?>"
      rel="stylesheet"/>

<!--Script de jquery-->
<script type="text/javascript"
        src="<?= JURI::base(true) . '/components/com_logicaldoc/assets/js/jquery-1.8.0.min.js' ?>"></script>
<script type="text/javascript"
        src="<?= JURI::base(true) . '/components/com_logicaldoc/assets/js/jquery-ui-1.8.23.custom.min.js' ?>"></script>
<script type="text/javascript"
        src="<?= JURI::base(true) . '/components/com_logicaldoc/assets/js/jquery.ui.datepicker-es.js' ?>"></script>
<!--Tabs-->

<!--script para la validacion-->
<script type="text/javascript"
        src="<?= JURI::base(true) . '/components/com_logicaldoc/assets/js/validador/jquery.validationEngine-en.js' ?>"></script>
<script type="text/javascript"
        src="<?= JURI::base(true) . '/components/com_logicaldoc/assets/js/validador/jquery.validationEngine.js' ?>"></script>
<script type="text/javascript"
        src="<?= JURI::base(true) . '/components/com_logicaldoc/assets/js/validador/jquery.numeric.js' ?>"></script>
<!--script para la tabla-->
<script type="text/javascript"
        src="<?= JURI::base(true) . '/components/com_logicaldoc/assets/js/jquery.dataTables-1.9.4.js' ?>"></script>

<?php
$controller = Factory::getApplication()->input->get('view');
switch ($controller) {
    case 'explorer':
        require_once(JPATH_COMPONENT . '/controllers/' . $controller . '.php');
        $controllerName = 'LogicalDOCController' . $controller;
        $controller = new $controllerName();
        $controller->execute(Factory::getApplication()->input->get('task'));
        $controller->redirect();
        break;
    case 'search':
        require_once(JPATH_COMPONENT . '/controllers/'  . $controller . '.php');
        $controllerName = 'LogicalDOCController' . $controller;
        $controller = new $controllerName();
        $controller->execute(Factory::getApplication()->input->get('task'));
        $controller->redirect();
        break;
    default:
        require_once(JPATH_COMPONENT . '/controllers/' . $controller . '.php');
        $controllerName = 'LogicalDOCController' . $controller;
        $controller = new $controllerName();
        $controller->execute(Factory::getApplication()->input->get('task'));
        $controller->redirect();
}
?>
