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
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

require_once (JPATH_COMPONENT . '/IconSelector.php');

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
?>
<script type="text/javascript">

    $(document).ready(function() {
                
        $(document).ready(function() {
            var iDisplayLength = <?= $this->rowConfiguration->showEntries ?>;
            var icon = <?= $this->rowConfiguration->icon ?>;
            var size = <?= $this->rowConfiguration->size ?>;
            var updateDate = <?= $this->rowConfiguration->updateDate ?>;
            var author = <?= $this->rowConfiguration->author ?>;
            var version = <?= $this->rowConfiguration->version ?>;
            var ldtype = <?= $this->rowConfiguration->type ?>;
            var iconValor = false;
            var sizeValor = false;
            var updateDateValor = false;
            var authorValor = false;
            var versionValor = false;
            var typeValor = false;
            if(icon == 1){
                iconValor = true;
            }
            if(size === 1){
                sizeValor = true;
            }
            if(updateDate == 1){
                updateDateValor = true; 
            }
            if(author == 1){
                authorValor = true;
            }
            if(version == 1){
                versionValor = true;
            }
            if(ldtype == 1){
                typeValor = true;
            }
            $('#tablaSearch').dataTable({
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",                
                "iDisplayLength": iDisplayLength,
                "bFilter":false,
                "aoColumns": [
                    { "bSortable": false,"bSearchable": false,"bVisible":iconValor},
                    { "bSortable": true ,"bVisible":true},
                    { "bSortable": false,"bVisible":versionValor },
                    { "bSortable": true ,"bVisible":authorValor},
                    { "bSortable": true, "bVisible": updateDateValor,
                        "mRender": function(date, type, full) {
                            if (type == 'display') {
                                var mydt = new Date(date);
                                //return mydt.toLocaleDateString() + " " + mydt.toLocaleTimeString();
                                var localDate = mydt.toLocaleDateString(navigator.language, {year: 'numeric', month: '2-digit', day: '2-digit'});
                                var localTime = mydt.toLocaleTimeString(navigator.language, {hour: '2-digit', minute:'2-digit'});
                                return localDate + " " + localTime;
                            }
                            return date;
                        }
                    },
                    { "bSortable": true ,"bVisible":typeValor},
                    { "bSortable": true ,"bVisible":sizeValor,
                        "mRender": function(size, type, full) {
                            if (type == 'display') {
                                if (size === '0') {return '0 KB';}
                                if (size == 0) {return ' ';}
                                var sizek = Math.floor( size / 1024 ).toFixed(0) * 1;
                                return sizek.toLocaleString() + ' KB';
                            }
                            return size;
                        }
                    }
                ],
                "aaSorting": [[ 0, "asc" ]],
                "oLanguage": {
                    "sProcessing": "<?= Text::_('COM_LOGICALDOC_PLEASE_WAIT') ?>",
                    "sLengthMenu": "<?= Text::_('COM_LOGICALDOC_SHOW') ?>_MENU_ <?= Text::_('COM_LOGICALDOC_ENTRIES') ?>",
                    "sZeroRecords": "<?= Text::_('COM_LOGICALDOC_NOTHING_FOUND_SORRY') ?>",
                    "sInfo": "<?= Text::_('COM_LOGICALDOC_SHOWING') ?>_START_ <?= Text::_('COM_LOGICALDOC_TO') ?> _END_ <?= Text::_('COM_LOGICALDOC_OF') ?> _TOTAL_ <?= Text::_('COM_LOGICALDOC_ENTRIES') ?>",
                    "sInfoEmpty": "<?= Text::_('COM_LOGICALDOC_SHOWING') ?> 0 <?= Text::_('COM_LOGICALDOC_TO') ?> 0 <?= Text::_('COM_LOGICALDOC_OF') ?> 0 <?= Text::_('COM_LOGICALDOC_ENTRIES') ?>",
                    "sInfoFiltered": "(<?= Text::_('COM_LOGICALDOC_FILTERED_FROM') ?> _MAX_ <?= Text::_('COM_LOGICALDOC_TOTAL_ENTRIES') ?>)",
                    "sInfoPostFix": "",
                    "sSearch": "<?= Text::_('COM_LOGICALDOC_SEARCH') ?>",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst":    "<?= Text::_('COM_LOGICALDOC_FIRST') ?>",
                        "sPrevious": "<?= Text::_('COM_LOGICALDOC_PREVIOUS') ?>",
                        "sNext":     "<?= Text::_('COM_LOGICALDOC_NEXT') ?>",
                        "sLast":     "<?= Text::_('COM_LOGICALDOC_LAST') ?>"
                    }
                }
            });
        });        
    });
</script>
<style>
    #advanced{
        margin-top:10px;
        margin-bottom:10px;
    }
</style>
<?php

function printFolder($folder) { ?>
    <tr>
        <td>
            <?php if ($folder->hasChildren == 1) { ?>
                <img src="components/com_logicaldoc/assets/images/menuitem_childs.png" /> 
            <?php } else {
                ?>
                <img src="components/com_logicaldoc/assets/images/menuitem_empty.png" />   
            <?php } ?>            
        </td>
        <td>
            <a href="index.php?option=com_logicaldoc&view=explorer&task=folder&path=<?php echo $folder->path; ?>" >
                <?php
                	echo substr($folder->path, strrpos($folder->path, '/') + 1);
                ?>
            </a>
        </td>
        <td></td>
        <td><?php echo $folder->author ?></td>
        <td>            
            <?php
            $time = strtotime($folder->created);
            echo date('d/m/Y h:i:s', $time);
            ?>
        </td>
        <td></td>
        <td></td>
    </tr>
    <?php
}

function printDocument($document, $rowConfiguration) {
    ?>
    <tr>
        <td>
            <img style="text-align: center" src="components/com_logicaldoc/assets/mimes/<?= IconSelector::selectIcon($document->type) ?>" />
        </td>
        <td>
            <?php
            $download_url = Route::_('index.php?option=com_logicaldoc&view=search&task=download&id='.$rowConfiguration->idConfiguration.'&documentID='.$document->id, false);
            ?>
            <a href="<?= $download_url ?>">
                <?= $document->fileName ?>
            </a>
        </td>
        <td><?= $document->fileVersion ?></td>
        <td><?= $document->creator ?></td>
        <td>
            <?php
			$ymd = DateTime::createFromFormat('Y-m-d H:i:s O', $document->date);
			//echo $ymd->format('d/m/Y H:i:s');
			echo $ymd->format('c');
            ?>
        </td>
        <td><?= $document->type ?></td>
        <td style="white-space: nowrap; text-align: right;"><?= $document->fileSize ?></td>
    </tr>
    <?php
}

function redondear($numero, $decimales) {
    $factor = pow(10, $decimales);
    return (round($numero * $factor) / $factor);
}

if ($this->error == 0) {
    ?>    
    <div id="advanced">
        <?php require_once ('form.php'); ?>
    </div>
    <table id="tablaSearch" width="100%" class="display" cellpadding="0" cellspacing="0" border="0">
        <thead>
            <tr>
                <th> </th>
                <th><?= Text::_('COM_LOGICALDOC_NAME') ?></th>
                <th><?= Text::_('COM_LOGICALDOC_VERSION') ?></th>
                <th><?= Text::_('COM_LOGICALDOC_AUTHOR') ?></th>
                <th><?= Text::_('COM_LOGICALDOC_UPDATE_DATE') ?></th>
                <th>Type</th>
                <th><?= Text::_('COM_LOGICALDOC_SIZE') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($this->resultArray)) {
                if (is_array($this->resultArray)) {
                    foreach ($this->resultArray as $result) {
			printDocument($result, $this->rowConfiguration);
                    }
                } else {
			printDocument($this->resultArray, $this->rowConfiguration);
                }
            }
            ?>
        </tbody>
    </table>

<?php } else { ?>   
     <h2><?= Text::_('COM_LOGICALDOC_ERROR_THE_CONFIGURATION_IS_NOT_CORRECT_PLEASE_CHECK_YOUR_LOGICALDOC_CONFIGURATION_TO_CONNECTO_TO') ?>.</h2>
    <?php
}?>
