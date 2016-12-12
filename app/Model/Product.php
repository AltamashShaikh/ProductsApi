<?php

class Product extends AppModel {

    public $useTable = 'products';

    function add_data($request) {
        $request_data = $this->validateRequest($request);
        $image_object = ClassRegistry::init('Image');
        $image_url_array = $image_object->process_and_get_all_image_urls($request_data->image_id);

        $data = array('product_name' => $request_data->name, 'price' => $request_data->price, 'image' => $image_url_array['image'], 'image_256' => $image_url_array['image_256'], 'image_512' => $image_url_array['image_512'], 'creation_date' => date('Y-m-d'));
        $this->create();
        if ($this->save($data)) {
            $result = array('status' => 'Success', 'message' => 'Products Inserted Successfully', 'id' => $this->getLastInsertId());
        } else {
            $result = array('status' => 'Filure', 'message' => 'Products Insertion Failed');
        }

        return $result;
    }

    private function validateRequest($request) {
        $data = $request->input('json_decode');
        if (empty($data) || is_null($data)) {
            throw new BadRequestException('JSON is not properly formed.');
        }

        if (empty($data->image_id)) {
            throw new BadRequestException('image_id is required');
        }
        if (empty($data->name)) {
            throw new BadRequestException('name is required');
        }
        if (empty($data->price)) {
            throw new BadRequestException('price is required');
        }

        return $data;
    }

    public function updateData($id, $request) {
        $request_data = $this->validateUpdateRequest($request);
        $image_object = ClassRegistry::init('Image');
        if (!empty($request_data->image_id)) {
            $image_url_array = $image_object->process_and_get_all_image_urls($request_data->image_id);
        }

        $data = array(
            'product_name' => !empty($request_data->name) ? "'".$request_data->name."'" : NULL,
            'price' => !empty($request_data->price) ? $request_data->price : NULL,
            'image' => isset($image_url_array['image']) ? "'".$image_url_array['image']."'" : NULL,
            'image_256' => isset($image_url_array['image_256']) ? "'".$image_url_array['image_256']."'" : NULL,
            'image_512' => isset($image_url_array['image_512']) ? "'".$image_url_array['image_512']."'" : NULL,
        );
        
        
        if ($this->updateAll(array_filter($data),array('product_id'=>$id))) {
            $result = array('status' => 'Success', 'message' => 'Product Details Updated Successfully');
        } else {
            $result = array('status' => 'Failure', 'message' => 'Product Details Updation Failed');
        }

        return $result;
    }

    private function validateUpdateRequest($request) {
        $data = $request->input('json_decode');
        if (empty($data) || is_null($data)) {
            throw new BadRequestException('JSON is not properly formed.');
        }

        return $data;
    }

}
