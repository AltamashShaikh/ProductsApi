<?php

class Image extends AppModel {

    public $useTable = false;

    public function save_to_redis($request) {
        //generate unique name
        //store the image contents in redis with file name and extension
        //return the data successfully

        $this->validateRequest($request);
        $image_size_array = getimagesize($request['form']['image']['tmp_name']);
        $payout_cache = ClassRegistry::init('PayoutCache');
        $redis_key_name = Configure::read('image_prefix_redis_name') . time() . "_" . substr(md5_file($request['form']['image']['tmp_name']), 0, 5);
        $image_contents = base64_encode(file_get_contents($request['form']['image']['tmp_name']));
        $payout_cache->set($redis_key_name, json_encode(array('image_name' => $request['form']['image']['name'], 'image_contents' => $image_contents, 'type' => $request['form']['image']['type'], 'processed_staus' => false, 'actual_image_width' => $image_size_array[0], 'actual_image_height' => $image_size_array[1]), true));

        return array('status' => 'Success', 'message' => 'Image stored in redis successfully', 'image_id' => $redis_key_name);
    }

    private function validateRequest($request) {
        if (!isset($request['form']['image']['error']) || $request['form']['image']['error'] != 0 || !in_array($request['form']['image']['type'], array('image/jpeg', 'image/png'))) {
            throw new BadRequestException('Please send a valid image');
        }
    }

    public function process_images_from_redis($id = null) {
        if (empty($id)) {
            throw new NotFoundException('Invalid image id');
        }
        $payout_cache = ClassRegistry::init('PayoutCache');
        $key_data = $payout_cache->keys($id);
        if (empty($key_data)) {
            throw new NotFoundException('Invalid image id');
        }

        return $this->get_image_data_and_save($key_data[0]);
    }

    private function get_image_data_and_save($id) {
        $payout_cache = ClassRegistry::init('PayoutCache');
        $data = json_decode($payout_cache->get($id), true);
        if ($data['processed_staus'] == false) {
            $result = $this->make_and_save_image($data, $id);
            $data['processed_staus'] = true;
            $payout_cache->set($id, json_encode(array_merge($data, $result)));

            return true;
        }

        return true;
    }

    private function make_and_save_image($data, $key) {
        $result = array('orignal_url' => '', '256_url' => '', '512_url' => '');
        $domain_url = Router::fullBaseUrl() . "/img/";
        $im = imagecreatefromstring(base64_decode($data['image_contents']));
        if ($im !== false) {
            $ext = '.jpeg';
            $function_name = 'imagejpeg';
            if ($data['type'] == "image/png") {
                $ext = '.png';
                $function_name = 'imagejpeg';
            }
            $orignal_file_name = $key . '_actual_image' . $ext;
            $resized_to_256_file_name = $key . '_256_pixel_image' . $ext;
            $resized_to_512_file_name = $key . '_512_pixel_image' . $ext;

            if ($function_name($im, WWW_ROOT . "img/" . $orignal_file_name)) {
                $result['orignal_url'] = $domain_url . $orignal_file_name;
            }
            $image_ick = new Imagick(WWW_ROOT . "img/" . $orignal_file_name);
            $image_ick->scaleImage(256, 0);
            if ($image_ick->writeimage(WWW_ROOT . "img/" . $resized_to_256_file_name)) {
                $result['256_url'] = $domain_url . $resized_to_256_file_name;
            }
            $image_ick->scaleImage(512, 0);
            if ($image_ick->writeimage(WWW_ROOT . "img/" . $resized_to_512_file_name)) {
                $result['512_url'] = $domain_url . $resized_to_512_file_name;
            }
            //make the orignal_image with saved height width
//            imagecopyresized($orignal_image, $im, 0, 0, 0, 0, $data['actual_image_width'], $newheight, $width, $height);
            $image_ick->destroy();
            imagedestroy($im);

            return $result;
        }
    }

    public function delete_processed_keys() {
        $count = 0;
        $payout_cache = ClassRegistry::init('PayoutCache');
        $data = $payout_cache->keys(Configure::read('image_prefix_redis_name') . '*');
        foreach ($data as $value) {
            $redis_value = json_decode($payout_cache->get($value), true);
            if ($redis_value['processed_staus'] == true) {
                $payout_cache->del($value);
                $count++;
            }
        }

        return $count;
    }

    public function process_and_get_all_image_urls($id) {
        $this->process_images_from_redis($id);
        $payout_cache = ClassRegistry::init('PayoutCache');
        $redis_value = json_decode($payout_cache->get($id), true);
        return array(
            'image' => $redis_value['orignal_url'],
            'image_256' => $redis_value['256_url'],
            'image_512' => $redis_value['512_url']
        );
    }

}
