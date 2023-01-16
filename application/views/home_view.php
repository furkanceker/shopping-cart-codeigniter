
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
                <a class="navbar-brand" href="#!">Fenix Shop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Ana Sayfa</a></li>
                    </ul>
                    <form class="d-flex">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Sepet
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
                    <h1 class="display-4 fw-bolder">Ürün Listesi</h1>
                    <p class="lead fw-normal text-white-50 mb-0">En Yeni Ürünler Fenix Shop'da</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">  
				<?php foreach($product as $prod) { ?> 
				<div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?= $prod->title ?></h5>
                                    <!-- Product price-->
                                    <?= $prod->price ?>₺
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
									<input type="number" class="form-control" placeholer="Ürün Adet" id="<?= $prod->id ?>">
									<button type="button" name="add" class="btn btn-success add" data-name="<?= $prod->title ?>" data-id="<?= $prod->id ?>" data-price="<?= $prod->price ?>">Sepete Ekle</button>
								</div>
                            </div>
                        </div>
                    </div>
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
				$('.add').click(function(){
					var id = $(this).data('id')
					var name = $(this).data('name')
					var price = $(this).data('price')
					var adet = $('#'+id).val()
					/* var total = price * adet */
					if(adet != '' && adet > 0){
						$.ajax({
							type : 'POST',
							url : "<?= base_url('cart/add') ?>",
							data : {
								id:id,
								name:name,
								price:price,
								adet:adet
							},
							success : function(data){
								if($.trim(data)=="yok"){
									alert("Ürün Mevcut Değil")
								}else if($.trim(data)=="adetbelirtin"){
									alert("Lütfen Adet Girin")
								}
								else{
									alert("Ürün Sepete Eklendi")
									window.location.href = '<?= base_url('cart') ?>'
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