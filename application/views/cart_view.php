
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Codeigniter Alışveriş Sepeti</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="<?php echo base_url('assets/css/styles.css');?> " rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="<?= base_url() ?>">Fenix Shop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="<?= base_url() ?>">Ana Sayfa</a></li>
                    </ul>
                    <form class="d-flex">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                             <a href="<?= base_url('cart') ?>">Sepet</a> 
                            <span class="badge bg-dark text-white ms-1 rounded-pill"><?= count($this->cart->contents()) ?></span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">SEPET</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Sepetindeki Ürünler</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row justify-content-center">  
                    <?php if(count($this->cart->contents())>0) { ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Ürün Adı</th>
                                    <th>Ürün Adet</th>
                                    <th>Ürün Fiyat</th>
                                    <th>Toplam Fiyat</th>
                                    <th>İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($this->cart->contents() as $product){ ?>
                                <tr>
                                    <td><?= $product['name'] ?></td>
                                    <td>
                                        <?= $product['qty'] ?>
                                        <input type="number" class="form-control col-md-2" placeholder="Adet" name="adet" id="<?= $product['rowid'] ?>">
                                        <button class="btn btn-primary update" type="button" name="update" data-id="<?= $product['rowid'] ?>">Güncelle</button>
                                    </td>
                                    <td><?= $product['price'] ?>₺</td>
                                    <td><?= $product['subtotal'] ?>₺</td>
                                    <td><a href="<?php echo base_url('cart/delete/'.$product['rowid']) ?>" onclick="return confirm('Ürün Sepetten Çıkarılsın Mı?')" class="btn btn-danger">Sepetten Çıkart</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div align="right">
                            <a href="<?php echo base_url('cart/empty') ?>" onclick="return confirm('Ürün Sepetten Çıkarılsın Mı?')"  class="btn btn-danger">Sepeti Boşalt</a>
                            <h2>GENEL TOPLAM : <?= $this->cart->total(); ?>₺</h2>
                        </div>
                    </div>
                    <?php } else { ?>
                        <h3 class="alert alert-danger text-center">Sepette Ürün Yok</h3>
                    <?php } ?>
                </div>
				
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2022</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->
        <!-- Core theme JS-->
        <!-- <script src="js/scripts.js"></script> -->

        <script>
			$(document).ready(function(){
				$('.update').click(function(){
					var id = $(this).data('id')
					var adet = $('#'+id).val()
					/* var total = price * adet */
					if(adet != '' && adet > 0){
						$.ajax({
							type : 'POST',
							url : "<?= base_url('cart/update') ?>",
							data : {
								id:id,
								adet:adet
							},
							success : function(data){
								if($.trim(data)=="adetbelirtin"){
									alert("Lütfen Adet Girin")
								}
								else{
									alert("Ürün Adeti Güncellendi")
									window.location.reload()
								}
							}
						})
					}else {
						alert('Lütfen Adet Girin')
					}
				})
			})
		</script>
    </body>
</html>