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
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

require_once (JPATH_COMPONENT . DS . 'IconSelector.php');
?>
<script type="text/javascript">

    $(document).ready(function() {
                
        $(document).ready(function() {
            var iDisplayLength = <?php echo $this->rowConfiguration->showEntries; ?>;
            var icon = <?php echo $this->rowConfiguration->icon; ?>;
            var size = <?php echo $this->rowConfiguration->size; ?>;
            var updateDate = <?php echo $this->rowConfiguration->updateDate; ?>;
            var author = <?php echo $this->rowConfiguration->author; ?>;
            var version = <?php echo $this->rowConfiguration->version; ?>;
            var iconValor = false;
            var sizeValor = false;
            var updateDateValor = false;
            var authorValor = false;
            var versionValor = false;
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
            $('#tablaSearch').dataTable({
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",                
                "iDisplayLength": iDisplayLength,
                "bFilter":false,
                "aoColumns": [
                    { "bSortable": false,"bSearchable": false,"bVisible":iconValor},
                    { "bSortable": true ,"bVisible":true},
                    { "bSortable": false ,"bVisible":sizeValor},
                	{ "bSortable": true, "bVisible": updateDateValor, 
						"mRender": function(date, type, full) {
										if (type == 'display') {
											var mydt = new Date(date);
											return mydt.toLocaleDateString() + " " + mydt.toLocaleTimeString();
								  		}
		                              return date;
		                           }
      				},
                    { "bSortable": true ,"bVisible":authorValor},
                    { "bSortable": false,"bVisible":versionValor }
                ],
                "aaSorting": [[ 0, "asc" ]],
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
                        "sFirst":    "<?php echo JText::_('COM_LOGICALDOC_FIRST') ?>",
                        "sPrevious": "<?php echo JText::_('COM_LOGICALDOC_PREVIOUS') ?>",
                        "sNext":     "<?php echo JText::_('COM_LOGICALDOC_NEXT') ?>",
                        "sLast":     "<?php echo JText::_('COM_LOGICALDOC_LAST') ?>"
                    }
                }
            });
        });        
    });
</script>
<style type="text/css">
    #advanced{
        margin-top:10px;
        margin-bottom:10px;
    }
</style>
<?php

function printFolder($folder) { ?>
    <tr>
        <td align="center">
            <?php if ($folder->hasChildren == 1) { ?>
                <img src="components/com_logicaldoc/assets/images/menuitem_childs.png" /> 
            <?php } else {
                ?>
                <img src="components/com_logicaldoc/assets/images/menuitem_empty.png" />   
            <?php } ?>            
        </td>
        <td>
            <a  href="index.php?option=com_logicaldoc&view=explorer&task=folder&path=<?php echo $folder->path; ?>" >
                <?php
                	echo substr($folder->path, strrpos($folder->path, '/') + 1);
                ?>
            </a>
        </td>
        <td>

        </td>
        <td>            
            <?php
            $time = strtotime($folder->created);
            echo date('d/m/Y h:i:s', $time);
            ?>
        </td>
        <td>
            <?php echo $folder->author ?>
        </td>
        <td>           
        </td> 
    </tr>
    <?php
}

function printDocument($document, $rowConfiguration) {
    ?>
    <tr>
        <td align="center">
            <img src="components/com_logicaldoc/assets/mimes/<?php echo IconSelector::selectIcon($document->type); ?>" />          
        </td>
        <td>            
            <a  href="components/com_logicaldoc/download.php?id=<?php echo $rowConfiguration->idConfiguration;?>&documentID=<?php echo $document->id; ?>" >               
                <?php echo $document->fileName; ?>
            </a>               
        </td>
        <td>
            <?php echo formatSize($document->fileSize); ?>
        </td>
        <td>
            <?php
			$ymd = DateTime::createFromFormat('Y-m-d H:i:s O', $document->date);
			//echo $ymd->format('d/m/Y H:i:s');
			echo $ymd->format('c');
            ?>
        </td>
        <td>
            <?php echo $document->creator; ?>
        </td>
        <td>
            <?php echo $document->fileVersion; ?>
        </td>
    </tr>
    <?php
}

function redondear($numero, $decimales) {
    $factor = pow(10, $decimales);
    return (round($numero * $factor) / $factor);
}

function formatSize($size) {
    $srt = "BIG";
    if ($size / 1024 < 1) {
        $srt = $size + " Bytes";
    } else if ($size / 1048576 < 1) {
        $srt = redondear(($size / 1024), 1) . " KB";
    } else if ($size / 1073741824 < 1) {
        $srt = redondear(($size / 1048576), 1) . " MB";
    } else if ($size / 1099511627776 < 1) {
        $srt = redondear(($size / 1073741824), 1) . " GB";
    } 
    return $srt;
}

if ($this->error == 0) {
    ?>    
    <div id="advanced">
        <?php require_once ('form.php'); ?>
    </div>
    <table id="tablaSearch" width="100%" class="display" cellpadding="0" cellspacing="0" border="0">
        <thead>
            <tr>
                <th > </th>
                <th > <?php echo JText::_('COM_LOGICALDOC_NAME') ?></th>
                <th > <?php echo JText::_('COM_LOGICALDOC_SIZE') ?></th>
                <th> <?php echo JText::_('COM_LOGICALDOC_UPDATE_DATE') ?></th>
                <th > <?php echo JText::_('COM_LOGICALDOC_AUTHOR') ?></th>
                <th > <?php echo JText::_('COM_LOGICALDOC_VERSION') ?></th>
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
     <h2><?php echo JText::_('COM_LOGICALDOC_ERROR_THE_CONFIGURATION_IS_NOT_CORRECT_PLEASE_CHECK_YOUR_LOGICALDOC_CONFIGURATION_TO_CONNECTO_TO') ?>.</h2>
    <?php
}?>
