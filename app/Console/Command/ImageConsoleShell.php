<?php

//Console/cake imageConsole delete_processed_images_from_redis
class ImageConsoleShell extends AppShell {

    public $uses = array('Image');

    public function delete_processed_images_from_redis() {
        $output = $this->Image->delete_processed_keys();

        $this->out(print_r($output, true));
    }

}
