<?php

class Cart extends CI_Controller{
    public function index(){
        $this->load->view('cart_view');
    }
    public function add(){
        if($_POST){
            $id = $this->input->post('id');
            $adet = $this->input->post('adet');

            if($adet > 0){
                $exist = $this->common_model->getProduct(['id'=>$id],'urunler');
                if($exist){
                    $data = array(
                        "id"=>$exist->id,
                        "name"=>$exist->title,
                        "price"=>$exist->price,
                        "qty"=>$adet
                    );
                    $this->cart->insert($data);
                }else{
                    echo "yok";
                }
            } else {
                echo "adetbelirtin";
            }
        }
    }

    public function delete($id){
        if(!$id){
            redirect(base_url());
        }
        $data = array(
            'rowid'=>$id,
            'qty'=>0
        );
        $this->cart->update($data);
        redirect(base_url('cart'));
    }
    public function empty(){
        $this->cart->destroy();
        redirect(base_url());
    }

    public function update(){
        if($_POST){
            $id = $this->input->post('id');
            $adet = $this->input->post('adet');

            if($adet > 0){
                $data = array(
                    "rowid"=>$id,
                    "qty"=>$adet
                );
                $this->cart->update($data);
            }else{
                echo 'adetbelirtin';
            }
        }
    }
}
?>