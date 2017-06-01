<?php

namespace NetLimeTheme\Extensions;

use NetLimeTheme\Core\Lib\ThemeModuleBase;

class ThemeImage extends ThemeModuleBase
{
    public function init()
    {
        $this->registerImageSizes();
    }

    /**
     * Registers image sizes from config
     */
    protected function registerImageSizes()
    {
        do_action("before_theme_register_image-sizes");

        foreach ($this->getConfig("image-sizes") as $id => $data):
            add_image_size($id, $data["width"], $data["height"], $data["crop"]);
        endforeach;

        do_action("after_theme_register_image-sizes");
    }

    /**
     * Get image url by ID and size
     *
     * @param $attachment_id
     * @param string $size
     * @param bool $placeholder
     * @return bool|mixed
     */
    public function getImage($attachment_id, $size = "post-thumbnail", $placeholder = true)
    {
        $sizes = $this->getConfig("image-sizes");

        if (isset($sizes[$size]) && $placeholder) {
            $image = "//placehold.it/" . $sizes[$size]["width"] . "x" . $sizes[$size]["height"];
        } else {
            $image = false;
        }

        $imgData = wp_get_attachment_image_src($attachment_id, $size);
        if ($imgData && is_array($imgData) && isset($imgData[0]) && $imgData[0]):
            $image = $imgData[0];
        endif;

        return $image;
    }
}