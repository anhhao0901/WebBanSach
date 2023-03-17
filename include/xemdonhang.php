<?php
	if(isset($_GET['huydon'])&& isset($_GET['magiaodich'])){
		$huydon = $_GET['huydon'];
		$magiaodich = $_GET['magiaodich'];
	}else{
		$huydon = '';
		$magiaodich = '';
	}
	$sql_update_donhang = mysqli_query($con,"UPDATE tbl_donhang SET huydon='$huydon' WHERE magiaodich='$magiaodich'");
?>
<!-- top Products -->
	<div class="ads-grid py-sm-5 py-4">
		<div class="container2 py-xl-4 py-lg-2">
			<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">Xem Đơn Hàng</h3>
			<!-- //tittle heading -->
			<div class="row">
				<!-- product left -->
				<div class="agileinfo-ads-display col-lg-9">
					<div class="wrapper">
						<!-- first section -->
						
							<div class="row"><h5>
								<?php
								if(isset($_SESSION['dangnhap_home'])){
									echo 'Đơn hàng : '.$_SESSION['dangnhap_home'];
								} 
								?></h5>
							<div class="col-md-12">
								
								<?php
								if(isset($_GET['khachhang'])){
									$id_khachhang = $_GET['khachhang'];
								}else{
									$id_khachhang = '';
								}
								$sql_select = mysqli_query($con,"SELECT * FROM tbl_donhang WHERE tbl_donhang.khachhang_id='$id_khachhang' GROUP BY tbl_donhang.magiaodich"); 
								?> 
								<table class="table table-bordered ">
									<tr>
										<th>Thứ Tự</th>
										<th>Mã Giao Dịch</th>									
										<th>Ngày Đặt</th>
										<th>Quản Lý</th>
										<th>Tình Trạng</th>
										<th>Yêu Cầu</th>
									</tr>
									<?php
									$i = 0;
									while($row_donhang = mysqli_fetch_array($sql_select)){ 
										$i++;
									?> 
									<tr>
										<td><?php echo $i; ?></td>
										
										<td><?php echo $row_donhang['magiaodich']; ?></td>
									
										
										<td><?php echo $row_donhang['ngaythang'] ?></td>
										<td><a href="index.php?quanly=xemdonhang&khachhang=<?php echo $_SESSION['khachhang_id'] ?>&magiaodich=<?php echo $row_donhang['magiaodich'] ?>">Xem Chi Tiết</a></td>
										<td><?php 
										if($row_donhang['tinhtrang']==0){
											echo 'Đã Đặt Hàng';
										}else{
											echo 'Đã Xử Lý | Đang Giao Hàng';
										}
										?></td>
										<td>
											<?php
											if($row_donhang['huydon']==0){ 
											?>
											<a href="index.php?quanly=xemdonhang&khachhang=<?php echo $_SESSION['khachhang_id'] ?>&magiaodich=<?php echo $row_donhang['magiaodich'] ?>&huydon=1">Yêu Cầu Hủy</a>
											<?php
										}elseif($row_donhang['huydon']==1){											
											?>
											<p>Đang Chờ Hủy...</p>
											<?php
											}else{
												echo 'Đã Hủy';
											}
											?>
										</td>
									</tr>
									 <?php
									} 
									?> 
								</table>
							</div>


							<div class="col-md-12">
								<h5>Chi Tiết Đơn Hàng</h6><br>
								<?php
								if(isset($_GET['magiaodich'])){
									$magiaodich = $_GET['magiaodich'];
								}else{
									$magiaodich = '';
								}
								$sql_select = mysqli_query($con,"SELECT * FROM tbl_donhang,tbl_khachhang,tbl_sanpham WHERE tbl_donhang.sanpham_id=tbl_sanpham.sanpham_id AND tbl_khachhang.khachhang_id=tbl_donhang.khachhang_id AND tbl_donhang.magiaodich='$magiaodich' ORDER BY tbl_donhang.donhang_id DESC"); 
								?> 
								<table class="table table-bordered ">
									<tr>
										<th>Thứ Tự</th>
										<th>Mã Giao Dịch</th>
										<th>Tên Sản Phẩm</th>
										<th>Số Lượng</th>
										<th>Giá</th>
										<th>Tổng Tiền</th>
										<th>Ngày Đặt</th>
										
									</tr>
									<?php
									$i = 0;
									while($row_donhang = mysqli_fetch_array($sql_select)){ 
										$i++;
									?> 
									<tr>
										<td><?php echo $i; ?></td>
										
										<td><?php echo $row_donhang['magiaodich']; ?></td>
									
										<td><?php echo $row_donhang['sanpham_name']; ?></td>

										<td><?php echo $row_donhang['soluong']; ?></td>

										<td><?php echo number_format($row_donhang['sanpham_giakhuyenmai']).'vnđ'; ?></td>

										<td><?php echo number_format($row_donhang['soluong']*$row_donhang['sanpham_giakhuyenmai']).'vnđ'; ?></td>
										
										<td><?php echo $row_donhang['ngaythang'] ?></td>
									
										
									</tr>
									 <?php
									} 
									?> 
								</table>
							</div>
							</div>

						
						<!-- //first section -->
					</div>
				</div>
				<!-- //product left -->
				<!-- product right -->
				
			</div>
		</div>
	</div>
	<!-- //top products -->