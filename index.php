<?php
/*
 * This file is part of Pluf Framework, a simple PHP Application Framework.
 * Copyright (C) 2010-2020 Phoinex Scholars Co. (http://dpq.co.ir)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
ini_set('display_errors', 'on');
error_reporting(E_ALL);

require 'Pluf.php';
$cfg = array(
        'installed_apps' => array(),
        'middleware_classes' => array(
                'Pluf_Middleware_Translation'
        ),
        'debug' => true,
        'migrate_allow_web' => true,
        'time_zone' => 'Europe/Berlin',
        'encoding' => 'UTF-8',
        'log_delayed' => true,
        'log_handler' => 'Pluf_Log_File',
        'log_level' => Pluf_Log::ERROR,
        'pluf_log_file' => SRC_BASE . '/var/logs/pluf.log',
        'languages' => array(
                'fa',
                'en'
        ),
        'template_tags' => array(
                'now' => 'Pluf_Template_Tag_Now',
                'cfg' => 'Pluf_Template_Tag_Cfg',
                'spaView' => 'Template_SapMainView'
        ),
        'mimetypes_db' => SRC_BASE . '/etc/mime.types'
);

$urls = array(
        array(
                'regex' => '#^/$#',
                'model' => 'Installer_Views',
                'method' => 'getIndex'
        ),
        array(
                'regex' => '#^/(?P<resource>.*)$#',
                'model' => 'Installer_Views',
                'method' => 'getResource'
        )
);

Pluf::start($cfg);
Pluf_Dispatcher::loadControllers($urls);
Pluf_Dispatcher::dispatch(Pluf_HTTP_URL::getAction());