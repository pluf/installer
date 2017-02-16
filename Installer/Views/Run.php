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
class Installer_Views_Run
{

    /**
     * Install current
     *
     * @param Pluf_HTTP_Request $request            
     * @param unknown $match            
     * @return Pluf_HTTP_Response_File
     */
    public static function install ($request, $match)
    {
        $messages = array();
        
        $ctx =  new Pluf_Template_Context_Request($request, $request->REQUEST);
        // write templates
        self::writeTemplate('/config.php', 'config.php.tmp', $ctx);
        $messages[] = 'Writ config template';
        self::writeTemplate('/urls.php', 'urls.php.tmp', $ctx);
        $messages[] = 'Writ urls template';
        
        // install
        self::createDb($ctx);
        $messages[] = 'DBMS is created';
        self::createUser($ctx);
        $messages[] = 'Create an administrator';
        self::createTenant($ctx);
        $messages[] = 'Create a default tenant';
        // response
        return new Pluf_HTTP_Response_Json($messages);
    }

    /**
     *
     * @param unknown $path            
     * @param unknown $template            
     * @param Pluf_Template_Context_Request $contex            
     * @return boolean
     */
    private static function writeTemplate ($path, $template, $contex = null)
    {
        $dir = dirname($_SERVER["SCRIPT_FILENAME"]);
        $dist = $dir . $path;
        { // make directory
            $folder = realpath(dirname($dist));
            if (! is_dir($folder)) {
                mkdir($folder, '777', true);
            }
        }
        $configTemplate = new Pluf_Template($template);
        $myfile = fopen($dist, "w");
        fwrite($myfile, $configTemplate->render($contex));
        fclose($myfile);
        return true;
    }

    /**
     * 
     * @param Pluf_Template_Context_Request $contex
     */
    private static function createDb ($contex)
    {
        $configPath = dirname($_SERVER["SCRIPT_FILENAME"]) . '/config.php';
        Pluf::start($configPath);
        $m = new Pluf_Migration();
        $m->install();
    }

    /**
     * 
     * @param Pluf_Template_Context_Request $contex
     */
    private static function createUser ($contex)
    {
        $user = new Pluf_User();
        $user->login = 'admin';
        $user->last_name = 'admin';
        $user->email = 'admin@dpq.co.ir';
        $user->setPassword('admin');
        $user->administrator = true;
        $user->staff = true;
        $user->create();
        return $user;
    }

    /**
     * 
     * @param Pluf_Template_Context_Request $contex
     */
    private static function createTenant ($contex)
    {
        $tenant = new Pluf_Tenant();
        $tenant->title = 'Default Tenant';
        $tenant->description = 'Auto generated tenant';
        $tenant->subdomain = Pluf::f('tenant_default', 'www');
        $tenant->domain = Pluf::f('general_domain', 'digidoki.com');
        $tenant->create();
        return $tenant;
    }
}
