<?php
error_reporting(0);
if (isset($_POST['themgiohang'])) {
	$tensanpham = $_POST['tensanpham'];
	$sanpham_id = $_POST['sanpham_id'];
	$hinhanh = $_POST['hinhanh'];
	$gia = $_POST['giasanpham'];
	$soluong = $_POST['soluong'];
	$tongtien = $_POST['tongtien'];
	$sql_select_giohang = mysqli_query($con, "SELECT * FROM tbl_giohang WHERE sanpham_id='$sanpham_id'");
	$count = mysqli_num_rows($sql_select_giohang);
	if ($count > 0) {
		$row_sanpham = mysqli_fetch_array($sql_select_giohang);
		$soluong = $row_sanpham['soluong'] + 1;
		$sql_giohang = "UPDATE tbl_giohang SET soluong='$soluong' WHERE sanpham_id='$sanpham_id'";
	} else {
		$soluong = $soluong;
		$sql_giohang = "INSERT INTO tbl_giohang(tensanpham,sanpham_id,giasanpham,hinhanh,soluong) values ('$tensanpham','$sanpham_id','$gia','$hinhanh','$soluong')";
	}
	$insert_row = mysqli_query($con, $sql_giohang);
} elseif (isset($_POST['capnhatsoluong'])) {

	for ($i = 0; $i < count($_POST['product_id']); $i++) {
		$sanpham_id = $_POST['product_id'][$i];
		$soluong = $_POST['soluong'][$i];
		if ($soluong <= 0) {
			$sql_delete = mysqli_query($con, "DELETE FROM tbl_giohang WHERE sanpham_id='$sanpham_id'");
		} else {
			$sql_update = mysqli_query($con, "UPDATE tbl_giohang SET soluong='$soluong' WHERE sanpham_id='$sanpham_id'");
		}
	}
} elseif (isset($_GET['xoa'])) {
	$id = $_GET['xoa'];
	$sql_delete = mysqli_query($con, "DELETE FROM tbl_giohang WHERE giohang_id='$id'");
} elseif (isset($_GET['dangxuat'])) {
	$id = $_GET['dangxuat'];
	if ($id == 1) {
		unset($_SESSION['dangnhap_home']);
		echo '<script language="javascript">window.location = "index.php?quanly=giohang" </script>';
	}
} elseif (isset($_POST['thanhtoan'])) {
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$note = $_POST['note'];
	$address = $_POST['address'];

	$sql_khachhang = mysqli_query($con, "INSERT INTO tbl_khachhang(name,phone,email,address,note,password) values ('$name','$phone','$email','$address','$note','$password')");
	if ($sql_khachhang) {
		$sql_select_khachhang = mysqli_query($con, "SELECT * FROM tbl_khachhang ORDER BY khachhang_id DESC LIMIT 1");
		$magiaodich = rand(0, 9999);
		$row_khachhang = mysqli_fetch_array($sql_select_khachhang);
		$khachhang_id = $row_khachhang['khachhang_id'];
		$_SESSION['dangnhap_home'] = $row_khachhang['name'];
		$_SESSION['khachhang_id'] = $khachhang_id;
		for ($i = 0; $i < count($_POST['thanhtoan_product_id']); $i++) {
			$sanpham_id = $_POST['thanhtoan_product_id'][$i];
			$soluong = $_POST['thanhtoan_soluong'][$i];
			$sql_donhang = mysqli_query($con, "INSERT INTO tbl_donhang(sanpham_id,khachhang_id,soluong,magiaodich) values ('$sanpham_id','$khachhang_id','$soluong','$magiaodich')");
			$sql_delete_thanhtoan = mysqli_query($con, "DELETE FROM tbl_giohang WHERE sanpham_id='$sanpham_id'");
		}
		unset($_SESSION['datve']);
		echo '<script language="javascript">alert("Đặt thành công");</script>';
	}
} elseif (isset($_POST['thanhtoandangnhap'])) {

	$khachhang_id = $_SESSION['khachhang_id'];
	$magiaodich = rand(0, 9999);
	for ($i = 0; $i < count($_POST['thanhtoan_product_id']); $i++) {
		$sanpham_id = $_POST['thanhtoan_product_id'][$i];
		$soluong = $_POST['thanhtoan_soluong'][$i];
		$sql_donhang = mysqli_query($con, "INSERT INTO tbl_donhang(sanpham_id,khachhang_id,soluong,magiaodich) values ('$sanpham_id','$khachhang_id','$soluong','$magiaodich')");
		$sql_delete_thanhtoan = mysqli_query($con, "DELETE FROM tbl_giohang WHERE sanpham_id='$sanpham_id'");
	}
}
?>

<!-- checkout page -->
<div class="privacy py-sm-5 py-4">
	<div class="container py-xl-4 py-lg-2">
		<!-- tittle heading -->
		<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
			Giỏ Hàng Của Bạn
		</h3>
		<?php
		if (isset($_SESSION['dangnhap_home'])) {
			echo '<p style="color:#000;">Xin Chào Bạn: ' . $_SESSION['dangnhap_home'] . '</p>';
		} else {
			echo '';
		}
		?>

		<!-- //tittle heading -->
		<div class="checkout-right">
			<?php
			$sql_lay_giohang = mysqli_query($con, "SELECT * FROM tbl_giohang ORDER BY giohang_id DESC");

			?>

			<div class="table-responsive">
				<form action="" method="POST">

					<table class="timetable_sub">
						<thead>
							<tr>
								<th style="background-color: #ea9408;">Thứ Tự</th>
								<th style="background-color: #ea9408;">Sản Phẩm</th>
								<th style="background-color: #ea9408;">Số Lượng</th>
								<th style="background-color: #ea9408;">Tên Sản Phẩm</th>
								<th style="background-color: #ea9408;">Giá</th>
								<th style="background-color: #ea9408;">Giá Tổng</th>
								<th style="background-color: #ea9408;">Quản Lý</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							$total = 0;
							while ($row_fetch_giohang = mysqli_fetch_array($sql_lay_giohang)) {
								$subtotal = $row_fetch_giohang['soluong'] * $row_fetch_giohang['giasanpham'];
								$tongtien += $subtotal;
								$i++;
							?>
								<tr class="rem1">
									<td class="invert"><?php echo $i ?></td>
									<td class="invert-image">
										<img src="images/<?php echo $row_fetch_giohang['hinhanh'] ?>" alt=" " height="86" width="80" class="img-responsive">
									</td>
									<td class="invert">
										<input type="hidden" name="product_id[]" value="<?php echo $row_fetch_giohang['sanpham_id'] ?>">
										<input type="number" min="1" name="soluong[]" value="<?php echo $row_fetch_giohang['soluong'] ?>">


									</td>
									<td class="invert"><?php echo $row_fetch_giohang['tensanpham'] ?></td>
									<td class="invert"><?php echo number_format($row_fetch_giohang['giasanpham']) . 'vnđ' ?></td>
									<td class="invert"><?php echo number_format($subtotal) . 'vnđ' ?></td>
									<td class="invert">
										<a href="?quanly=giohang&xoa=<?php echo $row_fetch_giohang['giohang_id'] ?>">Xóa</a>
									</td>
								</tr>
							<?php
							}
							?>
							<tr>
								<td colspan="7">Tổng Tiền : <?php echo number_format($tongtien) . 'vnđ' ?></td>

							</tr>
							<tr>
								<td colspan="7"><input type="submit" class="btn btn-success" value="Cập Nhật Giỏ Hàng" name="capnhatsoluong">
									<?php
									$sql_giohang_select = mysqli_query($con, "SELECT * FROM tbl_giohang");
									$count_giohang_select = mysqli_num_rows($sql_giohang_select);

									if (isset($_SESSION['dangnhap_home']) && $count_giohang_select > 0) {
										while ($row_1 = mysqli_fetch_array($sql_giohang_select)) {
									?>

											<input type="hidden" name="thanhtoan_product_id[]" value="<?php echo $row_1['sanpham_id'] ?>">
											<input type="hidden" name="thanhtoan_soluong[]" value="<?php echo $row_1['soluong'] ?>">
										<?php
										}
										?>
										<input type="submit" class="btn btn-primary" value="Thanh Toán Giỏ Hàng" name="thanhtoandangnhap">

									<?php
									}
									?>

								</td>

							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
		<?php
		if (!isset($_SESSION['dangnhap_home'])) {
		?>
			<div class="checkout-left">
				<div class="address_form_agile mt-sm-5 mt-4">
					<h4 class="mb-sm-4 mb-3">Thêm Địa Chỉ Giao Hàng</h4>
					<form id="formGioHang" action="" method="post" class="creditly-card-form agileinfo_form">
						<div class="creditly-wrapper wthree, w3_agileits_wrapper">
							<div class="information-wrapper">
									<div class="controls form-group">
										<input class="billing-address-name form-control" type="text" name="name" placeholder="Điền Tên" required>
										<div class="invalid-feedback"></div>
									</div>
									<div class="controls form-group">
										<input type="text" class="form-control" placeholder="Số Phone" name="phone" required>
										<div class="invalid-feedback"></div>
									</div>
									<div class="controls form-group">
										<input type="text" class="form-control" placeholder="Địa Chỉ" name="address" required>
										<div class="invalid-feedback"></div>
									</div>
									<div class="controls form-group">
										<input type="text" class="form-control" placeholder="Email" name="email" required>
										<div class="invalid-feedback"></div>
									</div>
									<div class="controls form-group">
										<input type="text" class="form-control" placeholder="Password" name="password" required>
										<div class="invalid-feedback"></div>
									</div>
									<div class="controls form-group">
										<textarea style="resize: none;" class="form-control" placeholder="Ghi Chú" name="note"></textarea>
									</div>
							</div>
								<?php
								$sql_lay_giohang = mysqli_query($con, "SELECT * FROM tbl_giohang ORDER BY giohang_id DESC");
								while ($row_thanhtoan = mysqli_fetch_array($sql_lay_giohang)) {
								?>
									<input type="hidden" name="thanhtoan_product_id[]" value="<?php echo $row_thanhtoan['sanpham_id'] ?>">
									<input type="hidden" name="thanhtoan_soluong[]" value="<?php echo $row_thanhtoan['soluong'] ?>">
								<?php
								}
								?>
								<input id="submitBtn" type="submit" name="thanhtoan" class="btn btn-success" style="width: 20%" value="Thanh Toán">

							</div>
						</div>
					</form>

				</div>
			</div>
		<?php
		}
		?>
	</div>
</div>
<!-- //checkout page -->
<script>
		$('#formGioHang').on('submit', function(e) {
			console.log('ok');

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