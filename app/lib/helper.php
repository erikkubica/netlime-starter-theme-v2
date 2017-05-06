<?php
### Import autoload
require_once(__DIR__ . "/vendor/autoload.php");

### Init the theme engine
$nlTheme = new \NetLimeTheme\Core\Theme();

/**
 * @return \NetLimeTheme\Core\Theme
 */
function theme()
{
    global $nlTheme;
    return $nlTheme;
}

function setTheme(&$object)
{
    global $nlTheme;
    $nlTheme = $object;
}