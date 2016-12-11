<?php

class ImagesController extends AppController {

    //put your code here

    function upload() {
        $this->autoRender = false;
        if (!$this->request->is('post')) {
            $this->response->statusCode(405);
            echo json_encode(array('status' => 'Failure', "message" => 'Get Not Allowed'));
            return;
        }

        try {
            $result = $this->Image->save_to_redis($this->request);
        } catch (Exception $e) {
            $this->response->statusCode($e->getCode());
            $result = array('status' => 'Failure', 'message' => $e->getMessage());
        }

        echo json_encode($result);
    }

}
