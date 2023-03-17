<?php
	// session_destroy();
	// unset('dangnhap');
	if(isset($_POST['dangnhap_home'])) {
		$taikhoan = $_POST['email_login'];
		$matkhau = md5($_POST['password_login']);
		if($taikhoan=='' || $matkhau ==''){
			echo '<script>alert("Làm Ơn Không Để Trống")</script>';
		}else{
			$sql_select_admin = mysqli_query($con,"SELECT * FROM tbl_khachhang WHERE email='$taikhoan' AND password='$matkhau' LIMIT 1");
			$count = mysqli_num_rows($sql_select_admin);
			$row_dangnhap = mysqli_fetch_array($sql_select_admin);
			if($count>0){
				$_SESSION['dangnhap_home'] = $row_dangnhap['name'];
				$_SESSION['khachhang_id'] = $row_dangnhap['khachhang_id'];
				
				header('Location: index.php?quanly=giohang');
			}else{
				echo '<script>alert("Tài Khoản Mật Khẩu Sai")</script>';
			}
		}
	}elseif(isset($_POST['dangky'])){
		$name = $_POST['name'];
	 	$phone = $_POST['phone'];
	 	$email = $_POST['email'];
	 	$password = md5($_POST['password']);
	 	$note = $_POST['note'];
	 	$address = $_POST['address'];

 		$sql_khachhang = mysqli_query($con,"INSERT INTO tbl_khachhang(name,phone,email,address,note,password) values ('$name','$phone','$email','$address','$note','$password')");
 		$sql_select_khachhang = mysqli_query($con,"SELECT * FROM tbl_khachhang ORDER BY khachhang_id DESC LIMIT 1");
 		$row_khachhang = mysqli_fetch_array($sql_select_khachhang);
 		$_SESSION['dangnhap_home'] = $name;
		$_SESSION['khachhang_id'] = $row_khachhang['khachhang_id'];
		
 		header('Location:index.php?quanly=giohang');
	}
?> 

<!-- top-header -->
	<div class="agile-main-top">
		<div class="container-fluid">
			<div class="row main-top-w3l py-2">
				<div class="col-lg-4 header-most-top">
					
				</div>
				<div class="col-lg-8 header-right mt-lg-0 mt-2">
					<!-- header lists -->
					<ul>

						<?php
						if(isset($_SESSION['dangnhap_home'])){ 
						
						?>
						<li class="text-center border-right text-white">
							<a href="index.php?quanly=xemdonhang&khachhang=<?php echo $_SESSION['khachhang_id'] ?>" class="text-white">
								<i class="fas1 fa-truck mr-2"></i>Xem Đơn Hàng : <?php echo $_SESSION['dangnhap_home'] ?></a>
						</li>
						<li class="text-center border-right text-white">
							<a href="index.php?quanly=giohang&dangxuat=1" class="text-white">
								<i class="fas1 fa-sign-out-alt mr-2"></i>Đăng Xuất</a>
						</li>
						
						<?php
					}
						?>
						<li class="text-center border-right text-white">
							<i class="fas1 fa-phone mr-2"></i> 0907986036
						</li>
						<li class="text-center border-right text-white">
							<a href="#" data-toggle="modal" data-target="#dangnhap" class="text-white">
								<i class="fas1 fa-sign-in-alt mr-2"></i> Đăng Nhập </a>
						</li>
						<li class="text-center text-white">
							<a href="#" data-toggle="modal" data-target="#dangky" class="text-white">
								<i class="fas1 fa-edit"></i> Đăng Ký </a>
						</li>
					</ul>
					<!-- //header lists -->
				</div>
			</div>
		</div>
	</div>
	<!-- modals -->
	<!-- log in -->
	<div class="modal fade" id="dangnhap" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-center">Đăng Nhập</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="#" method="post">
						<div class="form-group">
							<label class="col-form-label">Email</label>
							<input type="text" class="form-control" placeholder=" " name="email_login" required="">
						</div>
						<div class="form-group">
							<label class="col-form-label">Mật Khẩu</label>
							<input type="password" class="form-control" placeholder=" " name="password_login" required="">
						</div>
						<div class="right-w3l">
							<input type="submit" class="form-control" name="dangnhap_home" value="Đăng Nhập">
						</div>
						
						<p class="text-center dont-do mt-3">Chưa Có Tài Khoản?
							<a href="#" data-toggle="modal" data-target="#dangky">
								Đăng Ký</a>
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- register -->
	<div class="modal fade" id="dangky" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Đăng Ký</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="formDangKy" action="" method="post">
						<div class="form-group">
							<label class="col-form-label">Tên Khách Hàng</label>
							<input id="name"type="text" class="form-control" placeholder="" name="name">
							<div class="invalid-feedback"></div>
						</div>
						<div class="form-group">
							<label class="col-form-label">Email</label>
							<input id="email" type="text" class="form-control" placeholder="" name="email">
							<div class="invalid-feedback"></div>
						</div>
						<div class="form-group">
							<label class="col-form-label">Số Điện Thoại</label>
							<input id="phone" type="text" class="form-control" placeholder="" name="phone">
							<div class="invalid-feedback"></div>
						</div>
						<div class="form-group">
							<label class="col-form-label">Địa Chỉ</label>
							<input id="address" type="text" class="form-control" placeholder="" name="address">
							<div class="invalid-feedback"></div>
						</div>
						<div class="form-group">
							<label class="col-form-label">Mật Khẩu</label>
							<input id="password" type="password" class="form-control" placeholder="" name="password">
							<div class="invalid-feedback"></div>
						</div>
						<div class="form-group">
							<label class="col-form-label">Ghi Chú</label>
							<textarea class="form-control" name="note"></textarea>
						</div>
						
						<div class="right-w3l">
							<input type="submit" class="form-control" name="dangky" value="Đăng ký">
						</div>
					
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- //modal -->
	<!-- //top-header -->
	
	
	<!-- header-bottom-->
	<div class="header-bot">
		<div class="container">
			<div class="row header-bot_inner_wthreeinfo_header_mid">
				<!-- logo -->
				<div class="col-md-3 logo_agile">
					<h1 class="text-center">
						<a href="index.php" class="font-weight-bold font-italic">
							<img src="images/logoo.jpg" alt=" " class="img-fluid">BookStore
						</a>
					</h1>
				</div>
				<!-- //logo -->
				<!-- header-bot -->
				<div class="col-md-9 header mt-4 mb-md-0 mb-4">
					<div class="row">
						<!-- search -->
						<div class="col-10 agileits_search">
							<form class="form-inline" action="index.php?quanly=timkiem" method="POST">
								<input class="form-control mr-sm-2" name="search_product" type="search" placeholder="Tìm Kiếm Sản Phẩm" aria-label="Search" required>
								<button class="btn my-2 my-sm-0" name="search_button" type="submit"><i class="fas fa-search"></i></button>
							</form>
						</div>
						<!-- //search -->
						<!-- cart details -->
						<div class="col-2 top_nav_right text-center mt-sm-0 mt-2">
							<div class="wthreecartaits wthreecartaits2 cart cart box_1">
								<form action="index.php?quanly=giohang" method="post" class="last">
									<input type="hidden" name="cmd" value="_cart">
									<input type="hidden" name="display" value="1">
									<button class="btn w3view-cart" type="submit" name="submit" value="">
										<i class="fas fa-cart-arrow-down"></i>
									</button>
								</form>
							</div>
						</div>
						<!-- //cart details -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- //header-bottom -->
	<!-- navigation -->
	<script>
			$('#formDangKy').on('submit', function(e) {
				// Xóa các validate cũ
				document.querySelectorAll('.is-invalid').forEach(item => item.classList.remove('is-invalid'));

				// Lấy giá trị các input
				const name = document.getElementById('name').value;
				const email = document.getElementById('email').value;
				const phone = document.getElementById('phone').value;
				const address = document.getElementById('address').value;
				const password = document.getElementById('password').value;

				// Tạo biến lỗi (mặc định ko có lỗi)
				let errors = {
					name: false,
					email: false,
					phone: false,
					address: false,
					password: false,
				};

				let hasError = false;

				// validate dữ liệu
				if (!name) {
					errors.name = 'Cột tên không được bỏ trống';
					hasError = true;
				} else if (name.length < 10) {
					errors.name = 'Cột tên không được dưới 10 kí tự';
					hasError = true;
				}

				if (!email) {
					errors.email = 'Cột email không được bỏ trống';
					hasError = true;
				} else if (!validateEmail(email)) {
					errors.email = 'Email không hợp lệ';
					hasError = true;
				}

				if (!phone) {
					errors.phone = 'Cột số điện thoại không được bỏ trống';
					hasError = true;
				} else if (!validatePhoneNumber(phone)) {
					errors.phone = 'Số điện thoại không hợp lệ';
					hasError = true;
				}
				if (!address) {
					errors.address = 'Cột địa chỉ không được bỏ trống';
					hasError = true;
				} else if (address.length < 15) {
					errors.address = 'Cột địa chỉ không được dưới 15 kí tự';
					hasError = true;
				}
				if (!password) {
					errors.password = 'Cột mật khẩu không được bỏ trống';
					hasError = true;
				} else if (password.length < 3) {
					errors.password = 'Cột mật khẩu không được dưới 3 kí tự';
					hasError = true;
				}

				if (hasError) {
					e.preventDefault();
				}

				// Nếu có lỗi thì thêm tài khoản cho người dùng
				for (let key in errors) {
					if (errors[key]) {
						const invalidInputElement = document.querySelector(`#${key}`);

						invalidInputElement.classList.add('is-invalid');
						invalidInputElement.nextSibling.nextSibling.textContent = errors[key];
					}
				}
			});

			const validateEmail = (email) => {
				return String(email)
					.toLowerCase()
					.match(
						/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
					);
			};

			const validatePhoneNumber = (phone) => {
				return phone.match(/(84|0[3|5|7|8|9])+([0-9]{8})\b/g);
			}
		</script>