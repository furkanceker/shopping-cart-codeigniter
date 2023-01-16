<?php 

class Creditcard extends CI_Controller{

    public function basarili(){
        $this->load->view('basarili_view');
    }
    public function hata(){
        $this->load->view('hata_view');
    }

    public function completeorder(){
        if($this->input->method() == 'post'){
            $isim = $this->input->post('isim',true);
            $tel = $this->input->post('tel',true);
            $eposta = $this->input->post('eposta',true);
            $adres = $this->input->post('adres',true);
            $sipariskodu = uniqid();

            if(!$isim || !$tel || !$eposta || !$adres){
                echo "Tüm Alanları Doldurun";
            }else {
                $veri = array(
                    "isim"=>$isim,
                    "tel"=>$tel,
                    "eposta"=>$eposta,
                    "adres"=>$adres,
                    "toplam"=>$this->cart->total(),
                    "durum"=>2,
                    "sipariskodu"=>$sipariskodu
                );
                $ekle = $this->common_model->ekle('siparisler',$veri);
                if($ekle){
                    $merchant_id = '256204';
                    $merchant_key = 'dKsU2NxHwb96ZEfS';
                    $merchant_salt = '9Scs5unkBtxg83sL';
                    $email = $eposta;
                    $payment_amount = $this->cart->total() * 100;
                    $merchant_oid = $sipariskodu;
                    $user_name = $isim;
                    $user_address = $adres;
                    $user_phone = $tel;

                    $merchant_ok_url = base_url("creditcard/basarili");
                    $merchant_fail_url = base_url("creditcard/hata");

                    $urunadi = "";
                    $urunfiyat = "";
                    $urunadet = "";

                    foreach($this->cart->contents() as $urun){
                        $urunadi = $urun['name'];
                        $urunfiyat = $urun['price'];
                        $urunadet = $urun['qty'];
                    }
                    $user_basket = base64_encode(json_encode(array(
                        array($urunadi,$urunfiyat,$urunadet),
                    )));

                    if(isset($_SERVER['HTTP_CLIENT_IP'])){
                        $ip = $_SERVER['HTTP_CLIENT_IP'];
                    }else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    }else{
                        $ip = $_SERVER['REMOTE_ADDR'];
                    }

                    $user_ip = $ip;
                    $timeout_limit = "30";
                    $debug_on = 1;
                    $test_mode = 0;
                    $no_installment = 0;
                    $max_installment = 0;
                    $currency = "TL";
                    $hash_str = $merchant_id .$user_ip .$merchant_oid .$email .$payment_amount .$user_basket.$no_installment.$max_installment.$currency.$test_mode;
                    $paytr_token = base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));
                    $post_vals=array(
                        'merchant_id'=>$merchant_id,
                        'user_ip'=>$user_ip,
                        'merchant_oid'=>$merchant_oid,
                        'email'=>$email,
                        'payment_amount'=>$payment_amount,
                        'paytr_token'=>$paytr_token,
                        'user_basket'=>$user_basket,
                        'debug_on'=>$debug_on,
                        'no_installment'=>$no_installment,
                        'max_installment'=>$max_installment,
                        'user_name'=>$user_name,
                        'user_address'=>$user_address,
                        'user_phone'=>$user_phone,
                        'merchant_ok_url'=>$merchant_ok_url,
                        'merchant_fail_url'=>$merchant_fail_url,
                        'timeout_limit'=>$timeout_limit,
                        'currency'=>$currency,
                        'test_mode'=>$test_mode
                    );
                    $ch=curl_init();
                    $ch=curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1) ;
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
                    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                    
                    // XXX: DİKKAT: lokal makinanızda "SSL certificate problem: unable to get local issuer certificate" uyarısı alırsanız eğer
                    // aşağıdaki kodu açıp deneyebilirsiniz. ANCAK, güvenlik nedeniyle sunucunuzda (gerçek ortamınızda) bu kodun kapalı kalması çok önemlidir!
                    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    
                    $result = @curl_exec($ch);

                    if(curl_errno($ch))
                        die("PAYTR IFRAME connection error. err:".curl_error($ch));

                    curl_close($ch);
                    
                    $result=json_decode($result,1);
                        
                    if($result['status']=='success')
                        $token=$result['token'];
                    else
                        die("PAYTR IFRAME failed. reason:".$result['reason']);
                    #########################################################################

                    ?>

                    
                    <script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
                    <iframe src="https://www.paytr.com/odeme/guvenli/<?php echo $token;?>" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>
                    <script>iFrameResize({},'#paytriframe');</script>
                    

            <?php 
                }else {
                    echo "Hata Oluştu!";
                }
            }
        }
    }
}

?>