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
defined( '_JEXEC' ) or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
?>
<script type="text/javascript">
    $(document).ready(function(){

        $("#searchAdvanced").button().click(function() {
            var contenido = $('#contenido').val();
            var nombre = $('#nombre').val();
            var palabraClave = $('#palabraClave').val();
            if (contenido != '' || nombre != '' || palabraClave != ''){
                document.formSearchAdvanced.task.value = 'searchAdvanced';
                document.formSearchAdvanced.submit();
            }
            else{
                $('#nombre').validationEngine('showPrompt', '<?= Text::_('COM_LOGICALDOC_SOME_OF_THESE_FIELDS_ARE_REQUIRED')?>', 'error', true);
                return false;
            }
        });
        
        $('*').keypress(function(e){
            //funciona cuando se preciona la tecla enter
            if (e.keyCode == 13){
                var contenido = $('#contenido').val();
                var nombre = $('#nombre').val();
                var palabraClave = $('#palabraClave').val();
                if (contenido != '' || nombre != '' || palabraClave != ''){
                    document.formSearchAdvanced.task.value = 'searchAdvanced';
                    document.formSearchAdvanced.submit();
                }
                else{
                    $('#nombre').validationEngine('showPrompt', '<?= Text::_('COM_LOGICALDOC_SOME_OF_THESE_FIELDS_ARE_REQUIRED')?>', 'error', true);
                    return false;
                }
            }
        });
        
        $("#searchReturn").button().click(function() {
            document.formSearch.task.value = 'returnDesktop';
            document.formSearch.submit();
        });

        $("#tab").tabs();
        
        $('#formSearchAdvanced').validationEngine();
    });


</script>
<form action= "" method="post" name="formSearchAdvanced" id="formSearchAdvanced">
    <div id="tab">
        <ul>
            <li><a href="#dato"><?= Text::_('COM_LOGICALDOC_ADVANCED_SEARCH') ?></a></li>
        </ul>
        <div id="dato">
            <table id="datoTable" align="center">
                <tr>
                    <td style="text-align: right"><?= Text::_('COM_LOGICALDOC_CONTENT') ?>:</td>
                    <td>
                        <input type="text" name="contenido" id="contenido" value="" />
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right">Search Fields:</td>
                    <td>
                        <input type="checkbox" name="sfields[]" id="sfieldsc" value="content" checked="checked" />Content
                        <input type="checkbox" name="sfields[]" id="sfieldst" value="title" checked="checked" />Name
			            <input type="checkbox" name="sfields[]" id="sfieldsk" value="tags" checked="checked" />Tags
                    </td>
                </tr>
                <tr>
                    <td><?= Text::_('COM_LOGICALDOC_DOCUMENT_TYPE') ?>:</td>
                    <td>
                        <select id="tipoDocumento" name="tipoDocumento">
                            <option value=""></option>
                            <option value="pdf,doc,docx,odt,rtf" <?php if (!empty($this->sessionSearch) && ($this->sessionSearch->get('tipoDocumento') == 'pdf,doc,docx,odt,rtf')) echo "selected"; ?>>Document</option>
                            <option value="xls,xlsx,ods" <?php if (!empty($this->sessionSearch) && ($this->sessionSearch->get('tipoDocumento') == 'xls,xlsx,ods')) echo "selected"; ?>>Spreadsheet</option>
                            <option value="ppt,pptx,odp" <?php if (!empty($this->sessionSearch) && ($this->sessionSearch->get('tipoDocumento') == 'ppt,pptx,odp')) echo "selected"; ?>>Presentation</option>
                            <option value="txt,html,htm,xml" <?php if (!empty($this->sessionSearch) && ($this->sessionSearch->get('tipoDocumento') == 'txt,html,htm,xml')) echo "selected"; ?>>Text</option>
                            <option value="jpg,jpeg,png,gif,tif,tiff,psd,dwg,bmp,webp" <?php if (!empty($this->sessionSearch) && ($this->sessionSearch->get('tipoDocumento')) == 'jpg,jpeg,png,gif,tif,tiff,psd,dwg,bmp,webp') echo "selected"; ?>>Image</option>
                            <option value="mp3,wav,m4a" <?php if (!empty($this->sessionSearch) && ($this->sessionSearch->get('tipoDocumento') == 'mp3,wav,m4a')) echo "selected"; ?>>Audio</option>
                            <option value="avi,mkv,mp4,wmv" <?php if (!empty($this->sessionSearch) && ($this->sessionSearch->get('tipoDocumento') == 'avi,mkv,mp4,wmv')) echo "selected"; ?>>Video</option>
                            <option value="eml,msg" <?php if (!empty($this->sessionSearch) && ($this->sessionSearch->get('tipoDocumento') == 'eml,msg')) echo "selected"; ?>>Email</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <table width="100%" id="buttonTable">
            <tr>
                <td align="right" colspan="2">
                    <button id="searchReturn">
                        <?= Text::_('COM_LOGICALDOC_GO_BACK') ?>
                    </button>
                    <button id="searchAdvanced">
                        <?= Text::_('COM_LOGICALDOC_SEARCH') ?>
                    </button>                        
                </td>
            </tr>
        </table>            
        <input type="hidden" name="option" value="com_logicaldoc" />
        <input type="hidden" name="view" value="search"/>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="id" value="<?= $this->rowConfiguration->idConfiguration ?>"/>
		<input type="hidden" name="documento" id="documento" value="1" />
    </div><!--fin del tabs-->
</form>
