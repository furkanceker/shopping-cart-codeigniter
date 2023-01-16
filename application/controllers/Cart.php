<?php

class Cart extends CI_Controller{
    public function index(){
        echo "Sepet";
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
}
?>