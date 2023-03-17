<?php
if (isset($_POST['lienhe'])) {
	$ten = $_POST['lienhe_name'];
	$email = $_POST['lienhe_email'];
	$noidung = $_POST['lienhe_noidung'];
	$sql_lienhe = "INSERT INTO tbl_lienhe(lienhe_name,lienhe_email,lienhe_noidung) values ('$ten','$email','$noidung')";
	$insert_row = mysqli_query($con, $sql_lienhe);
}
?>

<body>
	<!-- page -->
	<div class="services-breadcrumb">
		<div class="agile_inner_breadcrumb">
			<div class="container">
				<ul class="w3_short">
					<li>
						<a href="index.php">Trang Chủ</a>
						<i>|</i>
					</li>
					<li>Liên Hệ</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- //page -->

	<!-- contact -->
	<div class="contact py-sm-5 py-4">
		<div class="container py-xl-4 py-lg-2">
			<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
				<span>L</span>iên
				<span>H</span>ệ
			</h3>
			<!-- //tittle heading -->
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-7">
						<!-- form -->
						<form id="formLienHe" action="?quanly=lienhe" method="post">
							<div class="contact-grids1 w3agile-6">
								<div class="row">
									<div class="col-md-6 col-sm-6 contact-form1 form-group">
										<label class="col-form-label">Họ Tên</label>
										<input id="lienhe_name" class="billing-address-name form-control" type="text" name="lienhe_name" placeholder="Điền Tên">
										<div class="invalid-feedback"></div>
									</div>
									<div class="col-md-6 col-sm-6 contact-form1 form-group">
										<label class="col-form-label">Email</label>
										<input id="lienhe_email" type="text" class="form-control" name="lienhe_email" placeholder="Email">
										<div class="invalid-feedback"></div>
									</div>
								</div>
								<div class="contact-me animated wow slideInUp form-group">
									<label class="col-form-label">Nội Dung</label>
									<textarea id="lienhe_noidung" style="resize: none;" class="form-control" placeholder="Nhập nội dung..." name="lienhe_noidung"></textarea>
									<div class="invalid-feedback"></div>
								</div>
								<div class="contact-form">
									<input id="btnGuiLienHe" type="submit" name="lienhe" value="Gửi" style="width: 30%">
								</div>
							</div>
						</form>
						<!-- //form -->
					</div>
					<div class="col-md-5">
						<!-- map -->
						<div class="map mt-sm-0 mt-4">
							<iframe src="https://www.google.com/maps/embed?pb=!1m19!1m8!1m3!1d318.4426293083084!2d105.75888083922297!3d10.029616805551305!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x31a0883f671acab1%3A0xfbe30475ff294c60!2zQW4gS2jDoW5oLCBQaMaw4budbmcgQW4gS2jDoW5oLCBOaW5oIEtp4buBdSwgQ-G6p24gVGjGoSwgVmnhu4d0IE5hbQ!3m2!1d10.029795799999999!2d105.7590949!5e0!3m2!1svi!2s!4v1653799070656!5m2!1svi!2s" width:20% height:20%></iframe>
						</div>
					</div>
					<!-- //map -->
				</div>
			</div>
			<br><br>
			<div class="row contact-grids agile-1 mb-5">
				<div class="col-sm-4 contact-grid agileinfo-6 mt-sm-0 mt-2">
					<div class="contact-grid1 text-center">
						<div class="con-ic">
							<i class="fas fa-map-marker-alt rounded-circle"></i>
						</div>
						<h4 class="font-weight-bold mt-sm-4 mt-3 mb-3">Địa Chỉ</h4>
						<p>An Khánh, Ninh Kiều
							<label>TP Cần Thơ</label>
						</p>
					</div>
				</div>
				<div class="col-sm-4 contact-grid agileinfo-6 my-sm-0 my-4">
					<div class="contact-grid1 text-center">
						<div class="con-ic">
							<i class="fas fa-phone rounded-circle"></i>
						</div>
						<h4 class="font-weight-bold mt-sm-4 mt-3 mb-3">HotLine</h4>
						<p>+(084) 907986036
							<label>+(084) 778268330</label>
						</p>
					</div>
				</div>
				<div class="col-sm-4 contact-grid agileinfo-6">
					<div class="contact-grid1 text-center">
						<div class="con-ic">
							<i class="fas fa-envelope-open rounded-circle"></i>
						</div>
						<h4 class="font-weight-bold mt-sm-4 mt-3 mb-3">Email</h4>
						<p>
							<a href="mailto:haohuynh9101@gmail.com">haohuynh9101@gmail.com</a>
							<label>
								<a href="mailto:lethitieubang177@gmail.com">lethitieubang177@gmail.com</a>
							</label>
						</p>
					</div>
				</div>
			</div>
		</div>
		<script>
			$('#formLienHe').on('submit', function(e) {
				// Xóa các validate cũ
				document.querySelectorAll('.is-invalid').forEach(item => item.classList.remove('is-invalid'));

				// Lấy giá trị các input
				const name = document.getElementById('lienhe_name').value;
				const email = document.getElementById('lienhe_email').value;
				const content = document.getElementById('lienhe_noidung').value;

				// Tạo biến lỗi (mặc định ko có lỗi)
				let errors = {
					lienhe_name: false,
					lienhe_email: false,
					lienhe_noidung: false
				};

				let hasError = false;

				// validate dữ liệu
				if (!name) {
					errors.lienhe_name = 'Cột tên không được bỏ trống';
					hasError = true;
				} else if (name.length < 10) {
					errors.lienhe_name = 'Cột tên không được dưới 10 kí tự';
					hasError = true;
				}

				if (!email) {
					errors.lienhe_email = 'Cột email không được bỏ trống';
					hasError = true;
				} else if (!validateEmail(email)) {
					errors.lienhe_email = 'Email không hợp lệ';
					hasError = true;
				}

				if (!content) {
					errors.lienhe_noidung = 'Cột nội dung không được bỏ trống';
					hasError = true;
				} else if (content.length < 20) {
					errors.lienhe_noidung = 'Cột nội dung không được dưới 20 kí tự';
					hasError = true;
				}

				if (hasError) {
					e.preventDefault();
				}

				// Nếu có lỗi thì thêm phản hồi cho người dùng
				for (let key in errors) {
					if (errors[key]) {
						const invalidInputElement = document.querySelector(`#${key}`);

						invalidInputElement.classList.add('is-invalid');
						invalidInputElement.nextSibling.nextSibling.textContent = errors[key];
					}
				}
			});
		</script>
		<!-- //contact -->
</body>

</html>