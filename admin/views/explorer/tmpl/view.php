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
defined('_JEXEC') or die;

require_once (JPATH_COMPONENT . DS . 'IconSelector.php');
?>

<style type="text/css">
    #basic {
        padding: 10px;
    }
</style>
<script type="text/javascript">

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
        if (icon == 1) {
            iconValor = true;
        }
        if (size === 1) {
            sizeValor = true;
        }
        if (updateDate == 1) {
            updateDateValor = true;
        }
        if (author == 1) {
            authorValor = true;
        }
        if (version == 1) {
            versionValor = true;
        }
        var asInitVals = new Array();
        var oTable = $('#tablaExplorer').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayLength": iDisplayLength,
            "bFilter": false,
            "aoColumns": [
                {"bSortable": false, "bSearchable": false, "bVisible": iconValor},
                {"bSortable": true, "bVisible": true},
                {"bSortable": false, "bVisible": sizeValor},
                {"bSortable": true, "bVisible": updateDateValor,
					"mRender": function(date, type, full) {
									if (type == 'display') {
										var mydt = new Date(date);
							    		return mydt.toLocaleDateString() + " " + mydt.toLocaleTimeString();
							  		}
                                  return date;
                               }
      			},
                {"bSortable": true, "bVisible": authorValor},
                {"bSortable": false, "bVisible": versionValor}
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

        $('#searchBasic').button().click(function() {
            if ($('#formSearch').validationEngine('validate')) {
                document.formSearch.task.value = 'searchBasic';
                document.formSearch.submit();
            }
            return false;
        });
        $('#cbSearchAdvanced').button().click(function() {
            if ($(this).is(':checked')) {
                $('#basic').css('display', 'none');
                $('#advanced').css('display', '');
                $('#tablaExplorer_wrapper').css('display', 'none');
                $("#spanAdvancedSearch").css('display', 'none');
            }
        });

        $('#formSearch').validationEngine();
    });
</script>
<?php

function printFolder($folder, $rowConfiguration, $exitemid = null) { 

    $folderUrl = "index.php?option=com_logicaldoc&view=explorer&task=folder&folderID=" .$folder->id;
    if (!empty($exitemid)) {
       $folderUrl = $folderUrl ."&Itemid=" .$exitemid;
	}
	?>
    <tr>       
        <td align="center">
		   <img src="components/com_logicaldoc/assets/images/menuitem_childs.png" />   
        </td>
        <td>
            <a href="<?php echo $folderUrl; ?>" >
                <?php echo $folder->name; ?>
            </a>
        </td>
        <td> </td>
        <td>            
            <?php
			$ymd = DateTime::createFromFormat('Y-m-d H:i:s O', $folder->creation);
			//echo $ymd->format('d/m/Y H:i:s');
			echo $ymd->format('c');
            ?>
        </td>        
        <td>
            <?php echo $folder->creator ?>
        </td>        
        <td> </td> 
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

if ($this->entrar == 0) {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#enviar').click(function() {
                document.formAcceso.task.value = 'enviar';
                document.formAcceso.submit();
            });

            $("#enviar").button();
        });
    </script>
    <div class=""> 
        <?php if ($this->mensaje != '') { ?>
            <p style="color: #ff0000;"><?php echo $this->mensaje; ?></p>
        <?php } ?>
        <h3 class="contentpassword-title"><?php echo JText::_('COM_LOGICALDOC_RESTRICTED_CONTENT') ?></h3>
        <p class="contentpassword-description"><?php echo JText::_('COM_LOGICALDOC_PROTECTED_AREA') ?><br>
            <?php echo JText::_('COM_LOGICALDOC_PRIVATE_DESCRIPTION') ?></p>
        <form action= "" method="post" id="formAcceso" name="formAcceso" class="contentpassword-form">
            <table>
                <tr>
                    <td align="right"><?php echo JText::_('COM_LOGICALDOC_PASSWORD') ?></td>
                    <td><input type="password" name="accessPassword" id="accessPassword" value=""/></td>
                    <td><button id="enviar"><?php echo JText::_('COM_LOGICALDOC_SEND'); ?></button></td>
                </tr>
            </table>        
            <input type="hidden" name="option" value="com_logicaldoc" />
            <input type="hidden" name="view" value="explorer"/>            
            <input type="hidden" name="task" value="" /> 
            <input type="hidden" name="id" value="<?php echo $this->rowConfiguration->idConfiguration; ?>"/>
        </form>
    </div>
    <?php
} else {
    if ($this->error == 0) {

        // List Folder
		$getChildrenFolder = $this->LDFolder->listChildren(array('sid' => $this->token, 'folderId' => $this->folderID));

		if (! empty ( $getChildrenFolder->folder )) {
			$folderArray =  $getChildrenFolder->folder;
			if (! is_array ( $folderArray )) {
				$folderArray = array ();
				$folderArray [0] = $getChildrenFolder->folder;
			}
		}
         
        //List Document
		$getChildrenDocument = $this->LDDocument->listDocuments(array('sid' => $this->token, 'folderId' => $this->folderID));        

		if (! empty ( $getChildrenDocument->document )) {
			$documentArray =  $getChildrenDocument->document;
			if (! is_array ( $documentArray )) {
				$documentArray = array();
				$documentArray[0] = $getChildrenDocument->document;
			}
		}

        $getPathResult = $this->LDFolder->getPath(array('sid' => $this->token, 'folderId' => $this->folderID));

        if (! empty ($getPathResult->folders)) {
			$folderPath =  $getPathResult->folders;
			if (! is_array ( $folderPath )) {
				$folderPath = array();
				$folderPath[0] = $getPathResult->folders;
			}
		}

		$this->LDAuth->logout(array('sid' => $this->token));
        ?>
        <h3><?php echo JText::_('COM_LOGICALDOC_PATH'); ?>:
            <!--
			<?php            
            for ($i = 0; $i < count($folderPath); $i++) {
                ?> 
                <a href="index.php?option=com_logicaldoc&view=explorer&task=folder&folderID=<?php echo $folderPath[$i]->id; ?>" >
					<?php
                    if ($i != 0) {
                        echo '/' . $folderPath[$i]->name;
                    } else {
                        echo JText::_('COM_LOGICALDOC_HOME');
                    }
                    ?>                                  
                </a>           
            <?php } ?>
            -->
			<?php 
      
 		    $exitemid = JRequest::getVar('Itemid');
 			//echo "exitemid: " .$exitemid ."<br/>";
     
            $canprint = 0;
            $startFolder = $this->rowConfiguration->ldFolderID;  
            for ($i = 0; $i < count($folderPath); $i++) {
                if ($folderPath[$i]->id == $startFolder) {
					$canprint = 1;
				}
                if ($canprint) {
                  $folderPathUri = "index.php?option=com_logicaldoc&view=explorer&task=folder&folderID=" .$folderPath[$i]->id;
                  if (!empty($exitemid)) {
					 $folderPathUri .= "&Itemid=" .$exitemid;
				  }
                ?> 
                <a href="<?php echo $folderPathUri; ?>" >
					<?php
                    if ($i != 0) {
                        echo '/' . $folderPath[$i]->name;
                    } else {
                        echo JText::_('COM_LOGICALDOC_HOME');
                    }
                    ?>                                  
                </a>           
            <?php }} ?>
        </h3>

        <div id="basic" style="display:inline-block; " width="100%">
            <form method="post" action="" name="formSearch" id="formSearch">
                <span><?php echo JText::_('COM_LOGICALDOC_SEARCH_BY_CONTENT') ?>:</span>    
                <span><input type="text" name="contenido" id="contenido" value="" size="50" class="validate[required] text-input"/> </span>
                <span><button id="searchBasic"><img src="components/com_logicaldoc/assets/images/search.png" width="16"  /></button></span>                
                <input type="hidden" name="option" value="com_logicaldoc" />
                <input type="hidden" name="view" value="explorer"/>
                <input type="hidden" name="id" value="<?php echo $this->rowConfiguration->idConfiguration; ?>"/>
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="documento" id="documento" value="1" />                       
            </form>
        </div>
        <div id="advanced" style="display: none;">
            <?php require_once ('form.php'); ?>
        </div>
        <span style="float: right; margin: 10px;" id="spanAdvancedSearch" ><input type="checkbox" name="cbSearchAdvanced" id="cbSearchAdvanced" /><label id="lSearch" for="cbSearchAdvanced"><?php echo JText::_('COM_LOGICALDOC_ADVANCED_SEARCH'); ?></label> </span>
        <table id="tablaExplorer" width="100%" class="display">
            <thead>
                <tr>
                    <th> </th>
                    <th> <?php echo JText::_('COM_LOGICALDOC_NAME') ?></th>
                    <th> <?php echo JText::_('COM_LOGICALDOC_SIZE') ?></th>
                    <th> <?php echo JText::_('COM_LOGICALDOC_UPDATE_DATE') ?></th>
                    <th> <?php echo JText::_('COM_LOGICALDOC_AUTHOR') ?></th>
                    <th> <?php echo JText::_('COM_LOGICALDOC_VERSION') ?></th>
                </tr>
            </thead>
            <tbody id="tbodyExplorer">
                <?php

                if (!empty($folderArray)) {
                    if (is_array($folderArray)) {
                        foreach ($folderArray as $folder) {
                            printFolder($folder, $this->rowConfiguration, $exitemid);
                        }
                    } else {
                        if (isset($folderArray)) {
                            printFolder($folderArray, $this->rowConfiguration, $exitemid);
                        }
                    }
                }

                if (!empty($documentArray)) {
                    if (is_array($documentArray)) {
                        foreach ($documentArray as $document) {
                            printDocument($document, $this->rowConfiguration);
                        }
                    } else {
                        if (isset($documentArray)) {
                            printDocument($documentArray, $this->rowConfiguration);
                        }
                    }
                }

                ?>
            </tbody>
            <tfoot>
        </table>
    <?php } else { ?>   
        <h2><?php echo JText::_('COM_LOGICALDOC_ERROR_THE_CONFIGURATION_IS_NOT_CORRECT_PLEASE_CHECK_YOUR_LOGICALDOC_CONFIGURATION_TO_CONNECTO_TO') ?>.</h2>
    <?php } ?>
<?php } ?>
