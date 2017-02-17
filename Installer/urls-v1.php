<?php
return array(
        /*
         * Package management
         */
        array(
                'regex' => '#^/packages$#',
                'model' => 'Installer_Views_Package',
                'method' => 'packages'
        ),
        
        /*
         * Runs
         */
        array(
                'regex' => '#^/run/install$#',
                'model' => 'Installer_Views_Run',
                'method' => 'install',
                'http-method' => 'POST'
        )
);


