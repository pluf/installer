<?php

/**
 * Generate a secret key string
 *
 * Generates and display a secret key.
 *
 * Sample usage:
 *     <code>secret:{sercretKey}</code>
 *
 */
class Installer_Template_Tag_SecretKey extends Pluf_Template_Tag
{

    /**
     *
     * @see Pluf_Template_Tag::start()
     * @param string $token
     *            Format to be applied.
     */
    public function start ($token = 'user random token')
    {
        $key = md5(
                microtime() . 
                rand(0, 123456789) . 
                rand(0, 123456789)
                . $token);
        echo $key;
    }
}
