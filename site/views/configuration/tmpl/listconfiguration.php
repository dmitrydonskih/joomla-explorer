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
?>
<script type="text/javascript">

    $(document).ready(function() {

        var oTable = $('#tablaConfiguration').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayLength": 25,
            "bFilter": true,
            "aoColumns": [
                {"bSortable": true},
                {"bSortable": true},
                {"bSortable": true},
                {"bSortable": true},
                {"bSortable": true},
                {"bSortable": false, "bSearchable": false},
                {"bSortable": false, "bSearchable": false},
                {"bSortable": false, "bSearchable": false}
            ],
            "aaSorting": [[0, "asc"]],
            "oLanguage": {
                "sProcessing": "<?php echo JText::_('COM_LOGICALDOC_PLEASE_WAIT') ?>",
                "sLengthMenu": "<?php echo JText::_('COM_LOGICALDOC_SHOW') ?>_MENU_ <?php echo JText::_('COM_LOGICALDOC_ENTRIES') ?>",
                "sZeroRecords": "<?php echo JText::_('COM_LOGICALDOC_NOTHING_FOUND_SORRY') ?>",
                "sInfo": "<?php echo JText::_('COM_LOGICALDOC_SHOWING') ?>_START_ <?php echo JText::_('COM_LOGICALDOC_TO') ?> _END_ <?php echo JText::_('COM_LOGICALDOC_OF') ?> _TOTAL_ <?php echo JText::_('COM_LOGICALDOC_ENTRIES') ?>",
                "sInfoEmpty": "<?php echo JText::_('COM_LOGICALDOC_SHOWING') ?> 0 <?php echo JText::_('COM_LOGICALDOC_TO') ?> 0 <?php echo JText::_('COM_LOGICALDOC_OF') ?> 0 <?php echo JText::_('COM_LOGICALDOC_ENTRIES') ?>",
                "sInfoFiltered": "(<?php echo JText::_('COM_LOGICALDOC_FILTERED_FROM') ?> _MAX_ <?php echo JText::_('COM_LOGICALDOC_TOTAL_ENTRIES') ?>)",
                "sInfoPostFix": "",
                "sSearch": "<?php echo JText::_('COM_LOGICALDOC_SEARCH'); ?>",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "<?php echo JText::_('COM_LOGICALDOC_FIRST') ?>",
                    "sPrevious": "<?php echo JText::_('COM_LOGICALDOC_PREVIOUS') ?>",
                    "sNext": "<?php echo JText::_('COM_LOGICALDOC_NEXT') ?>",
                    "sLast": "<?php echo JText::_('COM_LOGICALDOC_LAST') ?>"
                }
            }
        });
        
        $('#new, #edit, #delete, #connection').button();
    });
</script>
<p align="right">
    <a id="new" title="<?php echo JText::_('COM_LOGICALDOC_NEW'); ?>" href="index.php?option=com_logicaldoc&view=configuration&layout=formconfiguration">
        <img src="<?php echo JURI::base(true) . '/components/com_logicaldoc/assets/images/new.png'; ?>" alt=""/>
    </a>
</p>

<table id="tablaConfiguration" width="100%" class="display" cellpadding="0" cellspacing="0" border="0">
    <thead>
        <tr>
            <th><?php echo JText::_('COM_LOGICALDOC_NAME') ?></th>
            <th><?php echo JText::_('COM_LOGICALDOC_USER') ?></th>
            <th>URL</th>
            <th>Folder ID</th>
            <th><?php echo JText::_('COM_LOGICALDOC_ACCESS'); ?></th>
            <th><?php echo JText::_('COM_LOGICALDOC_DELETE'); ?></th>
            <th><?php echo JText::_('COM_LOGICALDOC_EDIT'); ?></th>
            <th><?php echo JText::_('COM_LOGICALDOC_CONNECTION'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->rows as $row) { ?>
            <tr>
                <td>
                    <?php echo $row->name; ?>
                </td>
                <td>
                    <?php echo $row->username; ?>                        
                </td>                   
                <td>
                    <?php echo $row->url; ?>                        
                </td>
                <td>
                    <?php echo $row->ldFolderID; ?>
                </td>
                <td align="center">
                    <a href="index.php?option=com_logicaldoc&view=configuration&task=accessLevel&id=<?php echo $row->idConfiguration; ?>" >
                        <?php
                        echo $row->accessLevel;
                        ?>
                    </a>                      
                </td>
                <td align="center">
                    <a id="delete" title="<?php echo JText::_('COM_LOGICALDOC_DELETE'); ?>" href="index.php?option=com_logicaldoc&view=configuration&task=delete&id=<?php echo $row->idConfiguration; ?>" >
                        <img src="<?php echo JURI::base(true) . '/components/com_logicaldoc/assets/images/delete.gif'; ?>" alt=""/>
                    </a>
                </td>
                <td align="center">
                    <a id="edit" title="<?php echo JText::_('COM_LOGICALDOC_EDIT') ?>" href="index.php?option=com_logicaldoc&view=configuration&task=edit&id=<?php echo $row->idConfiguration; ?>" >
                        <img src="<?php echo JURI::base(true) . '/components/com_logicaldoc/assets/images/edit.png'; ?>" alt=""/>
                    </a>
                </td>
                <td align="center">
                    <a id="connection" title="<?php echo JText::_('COM_LOGICALDOC_TEST_CONNECTION') ?>" href="index.php?option=com_logicaldoc&view=configuration&task=test&id=<?php echo $row->idConfiguration; ?>" >
                        <?php echo JText::_('COM_LOGICALDOC_TEST') ?> 
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
