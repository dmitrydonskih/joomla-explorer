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
        $('#saveConfiguration').click(function() {
            if ($("#formConfiguration").validationEngine('validate')) {
                document.formConfiguration.task.value = 'buscar';
                document.formConfiguration.submit();
            }
        });

        $('#cancelConfiguration').click(function() {
            document.formConfiguration.task.value = 'cancel';
            document.formConfiguration.submit();
        });

        $('#tab').tabs();

        $('#formConfiguration').validationEngine();

        $('#mensaje').dialog({
            modal: true,
            autoOpen: false,
            buttons: {
                Ok: function() {
                    $(this).dialog("close");
                }
            }
        });

        var rowConfiguration;
<?php
$encode = json_encode($this->rows);
?>
        rowConfiguration = <?php echo $encode; ?>;
        $('#name').focusout(function(e) {
            //funciona cuando se preciona la tecla enter
            var name = $(this).val();
            for (var i = 0; i < rowConfiguration.length; i++) {
                if (name == rowConfiguration[i].name) {
                    $('#mensaje').dialog("open");
                    $(this).val('');
                    return false;//para que no se actualize la pagina
                }
            }//fin for
        });//fin keypress name

        $('#accessLevel').change(function() {
            var accessLevel = $('#accessLevel').val();
            if (accessLevel == 'Public') {
                $('#accessPassword').attr('class', '');
            }
            else {
                $('#accessPassword').attr('class', 'validate[required] text-input');
            }
        });

    });
</script>

<style type="text/css">
    #mensaje p{
        margin: 10px;
    }
</style>
<div id="mensaje" title="Abrir Caja">
    <p>
        <span class="ui-icon ui-icon-circle-check" style="float:left;"></span>
        This name already exists
    </p>
</div>
<form action= "" method="post" name="formConfiguration"
      id="formConfiguration" enctype="multipart/form-data" >
    <div id="tab">
        <ul>
            <li><a href="#dato"><?php echo JText::_('COM_LOGICALDOC_ACCESS_CONFIGURATION') ?></a></li>
            <li><a href="#tabla"><?php echo JText::_('COM_LOGICALDOC_SETTING_THE_TABLE') ?></a></li>
        </ul>
        <div id="dato">
            <table id="tableDato" class="display">
                <?php if ($this->row->name == '') { ?>
                    <tr>
                        <td align="right"><?php echo JText::_('COM_LOGICALDOC_NAME') ?>:</td>
                        <td>
                            <input type="text" name="name" id="name" value="<?php echo $this->row->name; ?>" class="validate[required] text-input" size="50"/>
                        </td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td align="right"><?php echo JText::_('COM_LOGICALDOC_NAME') ?>:</td>
                        <td>
                            <input type="text" name="name" id="name" value="<?php echo $this->row->name; ?>" size="50" disabled="disabled"/>
                        </td>
                    </tr>                    
                <?php } ?>
                <tr>
                    <td align="right"><?php echo JText::_('COM_LOGICALDOC_USER') ?>:</td>
                    <td >
                        <input type="text" name="username" id="username" size="50" value="<?php echo $this->row->username; ?>" class="validate[required] text-input"/>
                    </td>
                </tr>
                <?php if($this->row->password == ''){ ?>
                <tr>
                    <td align="right"><?php echo JText::_('COM_LOGICALDOC_PASSWORD'); ?>:</td>
                    <td >
                        <input type="password" name="password" id="password" size="50" value="" class="validate[required] text-input"/>
                    </td>
                </tr>
                <?php } else { ?>
                    <tr>
                        <td align="right"><?php echo JText::_('COM_LOGICALDOC_PASSWORD'); ?>:</td>
                        <td >
                            <input type="password" name="password" id="password" size="50" value="" />
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td align="right"><?php echo JText::_('URL'); ?>:</td>
                    <td>
                        <input type="text" name="url" id="url" size="50" value="<?php echo $this->row->url; ?>" class="validate[required] text-input"/>
                    </td>
                </tr>
                <tr>
                    <td align="right">Folder ID:</td>
                    <td>
                        <input type="text" name="ldFolderID" id="ldFolderID" size="50" value="<?php echo $this->row->ldFolderID; ?>" class="validate[required,custom[integer],min[4]] text-input" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><?php echo JText::_('COM_LOGICALDOC_ACCESS_LEVEL') ?>:</td>
                    <td>
                        <select name="accessLevel" id="accessLevel" class="validate[required]">
                            <option value="Public" <?php if ("Public" == $this->row->accessLevel) echo "selected='selected'" ?>><?php echo JText::_('COM_LOGICALDOC_PUBLIC') ?></option>
                            <option value="Private" <?php if ("Private" == $this->row->accessLevel) echo "selected='selected'" ?>><?php echo JText::_('COM_LOGICALDOC_PRIVATE') ?></option>
                        </select>
                    </td>
                </tr>  
                <?php if ($this->row->accessPassword == '') { ?>
                    <tr>
                        <td align="right"><?php echo JText::_('COM_LOGICALDOC_ACCESS_PASSWORD') ?>:</td>
                        <td>
                            <input type="password" name="accessPassword" id="accessPassword" size="50" value="" class=""/> 
                        </td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td align="right"><?php echo JText::_('COM_LOGICALDOC_ACCESS_PASSWORD') ?>:</td>
                        <td>
                            <input type="password" name="accessPassword" id="accessPassword" size="50" value=""/> 
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div><!--Fin tab Configuration-->
        <div id="tabla">
            <table>
                <tr>
                    <td align="right"><?php echo JText::_('COM_LOGICALDOC_SHOW_FIELD') ?>:</td>
                    <td>
                        <input type="checkbox" name="icon" id="icon" value="1" <?php if ($this->row->icon == 1) echo "checked='checked'"; ?>/><?php echo JText::_('COM_LOGICALDOC_ICON') ?>                       
                        <input type="checkbox" name="size" id="size" value="1" <?php if ($this->row->size == 1) echo "checked='checked'"; ?>/><?php echo JText::_('COM_LOGICALDOC_SIZE') ?>
                        <input type="checkbox" name="updateDate" id="updateDate" value="1" <?php if ($this->row->updateDate == 1) echo "checked='checked'"; ?>/><?php echo JText::_('COM_LOGICALDOC_UPDATE_DATE') ?>
                        <input type="checkbox" name="author" id="author" value="1" <?php if ($this->row->author == 1) echo "checked='checked'"; ?>/><?php echo JText::_('COM_LOGICALDOC_AUTHOR') ?>
                        <input type="checkbox" name="version" id="version" value="1" <?php if ($this->row->version == 1) echo "checked='checked'"; ?>/><?php echo JText::_('COM_LOGICALDOC_VERSION') ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" ><?php echo JText::_('COM_LOGICALDOC_SHOW_IN_TABLE') ?>:</td>      
                    <td>
                        <select name="showEntries" size="1" id="showEntries">
                            <option value="10" <?php if ($this->row->showEntries == 10) echo "selected='selected'" ?> >10</option>
                            <option value="25" <?php if ($this->row->showEntries == 25) echo "selected='selected'" ?>>25</option>
                            <option value="50" <?php if ($this->row->showEntries == 50) echo "selected='selected'" ?>>50</option>
                            <option value="100" <?php if ($this->row->showEntries == 100) echo "selected='selected'" ?>>100</option>
                        </select>
                        <?php echo JText::_('COM_LOGICALDOC_REGISTRIES') ?>
                    </td>
                </tr>  
            </table>
        </div>
        <input type="hidden" name="p2" value="<?php echo $this->row->accessPassword; ?>" />
        <table width="100%" id="buttonTable">
            <tr>
                <td align="right" colspan="2">
                    <button id="saveConfiguration">
                        <?php echo JText::_('COM_LOGICALDOC_SAVE') ?>
                    </button>
                    <button id="cancelConfiguration">
                        <?php echo JText::_('COM_LOGICALDOC_CANCEL') ?>
                    </button>
                </td>
            </tr>
        </table>
        <input type="hidden" name="idConfiguration" value="<?php echo $this->row->idConfiguration; ?>" />
        <input type="hidden" name="option" value="com_logicaldoc" />
        <input type="hidden" name="view" value="configuration"/>
        <input type="hidden" name="task" value="" />   
    </div><!--fin del tabs-->
</form>
