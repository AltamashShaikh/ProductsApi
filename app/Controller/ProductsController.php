<?php

class ProductsController extends AppController {

    function index($id = null) {
        $this->autoRender = FALSE;
        if (!$this->request->is('get')) {
            $this->response->statusCode(405);
            echo json_encode(array('status' => 'Failure', "message" => 'Post Not Allowed'));
            return;
        }

        if ($id) {
            return $this->get_products_by_id($id);
        }

        return $this->get_all_products();
    }

    public function add() {
        $this->autoRender = FALSE;
        if (!$this->request->is('post')) {
            $this->response->statusCode(405);
            echo json_encode(array('status' => 'Failure', "message" => 'Post Not Allowed'));
            return;
        }

        try {
            $result = $this->Product->add_data($this->request);
        } catch (Exception $e) {
            $result = array('status' => 'Failure', 'message' => $e->getMessage());
            $this->response->statusCode($e->getCode());
        }


        echo json_encode($result);
    }

    private function get_products_by_id($id) {
        $result = array();
        if (!$this->Product->hasAny(array('product_id' => $id))) {
            $this->response->statusCode(404);
            echo json_encode(array('status' => 'Failure', "message" => 'Invalid Product ID'), true);
            return;
        }

        try {
            $data = $this->Product->find('all', array('conditions' => array('is_deleted' => 0, 'product_id' => $id)));
            $result = array('data' => $data, 'status' => 'Success');
        } catch (Exception $e) {
            $this->response->statusCode($e->getCode());
            $result = array('status' => 'Failure', "message" => $e->getMessage());
        }

        echo json_encode($result);
    }

    private function get_all_products() {
        $result = array();
        try {
            $data = $this->Product->find('all', array('conditions' => array('is_deleted' => 0), 'recursive' => -1));
            $result = array('data' => $data, 'status' => 'Success');
        } catch (Exception $e) {
            $this->response->statusCode($e->getCode());
            $result = array('status' => 'Failure', "message" => $e->getMessage());
        }

        echo json_encode($result);
    }

    public function delete($id) {
        $this->autoRender = false;
        if (!$this->request->is('post')) {
            $this->response->statusCode(405);
            echo json_encode(array('status' => 'Failure', "message" => 'Only Post Request Allowed'));
            return;
        }

        if (!$this->Product->hasAny(array('product_id' => $id))) {
            $this->response->statusCode(404);
            echo json_encode(array('status' => 'Failure', "message" => 'Invalid Product ID'), true);
            return;
        }

        $data = array('is_deleted' => 1);
        try {
            $this->Product->updateAll($data,array('product_id'=>$id));
            $result = array('status' => 'Success', 'message' => 'Products Deleted Successfully');
        } catch (Exception $e) {
            $this->response->statusCode(500);
            $result = array('status' => 'Filure', 'message' => 'Products Deletion Failed');
        }

        echo json_encode($result);
    }

    function update($id) {
        $this->autoRender = false;
        if (!$this->request->is('post')) {
            $this->response->statusCode(405);
            echo json_encode(array('status' => 'Failure', "message" => 'Only Post Request Allowed'));
            return;
        }
        
        if (!$this->Product->hasAny(array('product_id' => $id))) {
            $this->response->statusCode(404);
            echo json_encode(array('status' => 'Failure', "message" => 'Invalid Product ID'), true);
            return;
        }
        
        try{
            $result=$this->Product->updateData($id,$this->request);
        }catch(Exception $e){
            $this->response->statusCode($e->getCode());
            $result = array('status' => 'Filure', 'message' => 'Products Updation Failed');
        }
        
        echo json_encode($result);
    }

}
