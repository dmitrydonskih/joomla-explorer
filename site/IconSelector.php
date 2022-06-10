<?php

/**
 * @author Cristian Fulger
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
class IconSelector
{

    /** returns the icon by parsing the provided file extension */
    public static function selectIcon($ext)
    {
        $icon = "";

        if (!empty($ext)) {
            $ext = strtolower($ext);
        }

        if (empty($ext))
            $icon = "generic.png";
        else if ($ext == "pdf")
            $icon = "pdf.png";
        else if (($ext == "txt") || ($ext == "properties"))
            $icon = "text.png";
        else if (($ext == "doc") || ($ext == "docx") || ($ext == "odt") || ($ext == "rtf") || ($ext == "ott")
            || ($ext == "sxw") || ($ext == "wpd") || ($ext == "kwd") || ($ext == "dot"))
            $icon = "word.png";
        else if (($ext == "xls") || ($ext == "xlsx") || ($ext == "ods") || ($ext == "xlt") || ($ext == "ots")
            || ($ext == "sxc") || ($ext == "dbf") || ($ext == "ksp") || ($ext == "odb"))
            $icon = "excel.png";
        else if (($ext == "ppt") || ($ext == "pptx") || ($ext == "odp") || ($ext == "pps") || ($ext == "otp")
            || ($ext == "pot") || ($ext == "sxi") || ($ext == "kpr"))
            $icon = "powerpoint.png";
        else if (($ext == "jpg") || ($ext == "jpeg") || ($ext == "gif") || ($ext == "png") || ($ext == "psd")
            || ($ext == "ai") || ($ext == "bmp") || ($ext == "tif") || ($ext == "tiff"))
            $icon = "picture.png";
        else if (($ext == "htm") || ($ext == "html") || ($ext == "xml") || ($ext == "xhtml"))
            $icon = "html.png";
        else if (($ext == "eml") || ($ext == "msg") || ($ext == "mail"))
            $icon = "page_white_email.png";
        else if (($ext == "zip") || ($ext == "rar") || ($ext == "gz") || ($ext == "tar") || ($ext == "jar")
            || ($ext == "7z"))
            $icon = "zip.png";

        else if (($ext == "dwg") || ($ext == "dxf") || ($ext == "dwt"))
            $icon = "dwg.png";
        else if (($ext == "avi") || ($ext == "mpg") || ($ext == "mp4") || ($ext == "mov")
            || ($ext == "wmv") || ($ext == "mkv") || ($ext == "divx") || ($ext == "flv"))
            $icon = "film.png";
        else if (($ext == "mp3") || ($ext == "m4p") || ($ext == "m4a") || ($ext == "wav")
            || ($ext == "wma") || ($ext == "wave"))
            $icon = "music.png";

        else if (($ext == "p7m") || ($ext == "m7m"))
            $icon = "p7m.png";
        else
            $icon = "generic.png";

        return $icon;
    }


    public static function get_mime_type($ext)
    {
        $mimeType = "application/octet-stream";

        if (!empty($ext)) {
            $ext = strtolower($ext);
        }

        // our list of mime types
        $mime_types = array(
            "pdf" => "application/pdf"
        , "txt" => "text/plain"
        , "gif" => "image/gif"
        , "png" => "image/png"
        , "jpeg,jpg" => "image/jpg"
        , "doc" => "application/msword"
        , "docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
        , "xls" => "application/vnd.ms-excel"
        , "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
        , "ppt" => "application/vnd.ms-powerpoint"
        , "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation"
        , "zip" => "application/zip"
        , "htm,html" => "text/html"
        , "xml" => "application/xml"

        , "eml" => "message/rfc822"
        , "msg" => "application/vnd.ms-outlook"

        , "mp3" => "audio/mpeg"
        , "wav" => "audio/x-wav"
        , "mpeg,mpg,mpe" => "video/mpeg"
        , "mov" => "video/quicktime"
        , "avi" => "video/x-msvideo"
        , "css" => "text/css"
        , "js" => "application/javascript"
        , "php" => "text/html"
        , "exe" => "application/octet-stream"
        );

        foreach ($mime_types as $key => $value) {
            if (strpos($key, $ext) !== false) {
                $mimeType = $value;
                break;
            }
        }

        return $mimeType;
    }
}

?>
