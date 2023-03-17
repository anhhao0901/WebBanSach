<?php
	include('../db/connect.php');
?>
<?php 
if(isset($_POST['capnhatdonhang'])){
	$xuly = $_POST['xuly'];
	$magiaodich = $_POST['magiaodich_xuly'];
	$sql_update_donhang = mysqli_query($con,"UPDATE tbl_donhang SET tinhtrang='$xuly' WHERE magiaodich='$magiaodich'");
}

?>
<?php
	if(isset($_GET['xoadonhang'])){
		$magiaodich = $_GET['xoadonhang'];
		$sql_delete = mysqli_query($con,"DELETE FROM tbl_donhang WHERE magiaodich='$magiaodich'");
		header('Location:xulydonhang.php');
	} 
	if(isset($_GET['xacnhanhuy'])&& isset($_GET['magiaodich'])){
		$huydon = $_GET['xacnhanhuy'];
		$magiaodich = $_GET['magiaodich'];
	}else{
		$huydon = '';
		$magiaodich = '';
	}
	$sql_update_donhang = mysqli_query($con,"UPDATE tbl_donhang SET huydon='$huydon' WHERE magiaodich='$magiaodich'");

	date_default_timezone_set('Asia/Ho_Chi_Minh');

    /* Set the date */
    $date = strtotime(date('y-m-d'));

    $month = date('m', $date);
    $year = date('Y', $date);

    $daysInMonth = cal_days_in_month(0, $month, $year);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="icon" href="../images/favicon.jpg" type="image/png"/>
	<title>Đơn Hàng</title>
	<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />

	<script src="../js/jquery-2.2.3.min.js"></script>
	<script src="js/highcharts/highcharts.js"></script>
	<script src="js/highcharts/exporting.js"></script>

	<script type="text/javascript">
		$(function(){
			$('#highcharts').highcharts({
		        chart: {
		            type: 'column'
		        },
		        title: {
		            text: 'Thống kê doanh thu : <?php echo $month ?> - <?php echo $year ?> '
		        },
		        subtitle: {
		            text: ''
		        },
		        xAxis: {
		            type: 'category',
		            labels: {
		                style: {
		                    fontSize: '18px',
		                    fontFamily: 'Arial',
							fontStyle: 'bold'
		                }
		            }
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'Số tiền'
		            }
		        },
		        legend: {
		            enabled: false
		        },
		        tooltip: {
				    pointFormat: 'Tổng: <b>{point.y}</b> {point.event}'
				},
		        series: [{
		            name: 'Population',
		            data: [
		            <?php for($i = 1; $i <= $daysInMonth; $i++):
						$day = $i > 9 ? $i : "0".$i;
		                $begin = $year.'-'.$month.'-'.$day;

		                $sql = mysqli_query($con,"select sum(c.soluong * c.sanpham_giakhuyenmai) as tongtien from (SELECT a.soluong, a.donhang_id, a.ngaythang, b.sanpham_giakhuyenmai FROM tbl_donhang a, tbl_sanpham b where a.sanpham_id =b.sanpham_id and SUBSTRING(a.ngaythang, 1, 10) = '$begin') c 
						group by SUBSTRING(c.ngaythang, 1, 10)");
						$row_line = mysqli_fetch_array($sql);

		            ?>
		                ['<?=$i?>', <?=$row_line['tongtien'] ? $row_line['tongtien'] : 0 ?>],
		            <?php endfor; ?>
					]
		        }]
		    });
		})
	</script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <div class="collapse navbar-collapse" id="navbarNav">
	    <ul class="navbar-nav">
		<li class="nav-item active">
	        <a class="nav-link" href="xulydonhang.php">Đơn Hàng <span class="sr-only">(current)</span></a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="xulydanhmuc.php">Danh Mục</a>
	      </li>
		  <li class="nav-item">
	        <a class="nav-link" href="xulydanhmucbaiviet.php">Danh Mục Bài Viết</a>
	      </li>
	         <li class="nav-item">
	        <a class="nav-link" href="xulybaiviet.php">Bài Viết</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="xulysanpham.php">Sản Phẩm</a>
	      </li>
	       <li class="nav-item">
	        <a class="nav-link" href="xulykhachhang.php">Khách Hàng</a>
	      </li>
		  <li class="nav-item">
	        <a class="nav-link" href="xulylienhe.php">Phản Hồi</a>
	      
	    </ul>
	  </div>
	</nav><br><br>
	<div class="container-fluid">
		<div class="row">
			 <?php
			if(isset($_GET['quanly'])=='xemdonhang'){
				$magiaodich = $_GET['magiaodich'];
				$sql_chitiet = mysqli_query($con,"SELECT * FROM tbl_donhang,tbl_sanpham WHERE tbl_donhang.sanpham_id=tbl_sanpham.sanpham_id AND tbl_donhang.magiaodich='$magiaodich'");
				?>
				<div class="col-md-7">
				<h5>Xem Chi Tiết Đơn Hàng</h5>
			<form action="" method="POST">
				<table class="table table-bordered ">
					<tr>
						<th>Thứ Tự</th>
						<th>Mã Hàng</th>
						<th>Tên Sản Phẩm</th>
						<th>Số Lượng</th>
						<th>Giá</th>
						<th>Tổng Tiền</th>
						<th>Ngày Đặt</th>

						
						<th>Quản lý</th>
					</tr>
					<?php
					$i = 0;
					while($row_donhang = mysqli_fetch_array($sql_chitiet)){ 
						$i++;
					?> 
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $row_donhang['magiaodich']; ?></td>
						
						<td><?php echo $row_donhang['sanpham_name']; ?></td>
						<td><?php echo $row_donhang['soluong']; ?></td>
						<td><?php echo $row_donhang['sanpham_giakhuyenmai']; ?></td>
						<td><?php echo number_format($row_donhang['soluong']*$row_donhang['sanpham_giakhuyenmai']).'vnđ'; ?></td>
						
						<td><?php echo $row_donhang['ngaythang'] ?></td>
						<input type="hidden" name="magiaodich_xuly" value="<?php echo $row_donhang['magiaodich'] ?>">

						<!-- <td><a href="?xoa=<?php echo $row_donhang['donhang_id'] ?>">Xóa</a> || <a href="?quanly=xemdonhang&magiaodich=<?php echo $row_donhang['magiaodich'] ?>">Xem đơn hàng</a></td> -->
					</tr>
					 <?php
					} 
					?> 
				</table>

				<select class="form-control" name="xuly">
					<option value="1">Đã Xử Lý | Giao Hàng</option>
					<option value="0">Chưa Xử Lý</option>
				</select><br>

				<input type="submit" value="Cập nhật đơn hàng" name="capnhatdonhang" class="btn btn-success">
			</form>
				</div>  
			<?php
			}else{
				?> 
				
				<div class="col-md-7">
					<p>Thống kê hóa đơn</p>
					<div id="highcharts"></div>
				</div>  
				<?php
			} 
			
				?> 
			<div class="col-md-5">
				<h4>Liệt Kê Đơn Hàng</h4>
				<?php
				$sql_select = mysqli_query($con,"SELECT * FROM tbl_sanpham,tbl_khachhang,tbl_donhang WHERE tbl_donhang.sanpham_id=tbl_sanpham.sanpham_id AND tbl_donhang.khachhang_id=tbl_khachhang.khachhang_id GROUP BY magiaodich "); 
				?> 
				<table class="table table-bordered ">
					<tr>
						<th>Thứ Tự</th>
						<th>Mã Hàng</th>
						<th>Tình Trạng Đơn Hàng</th>
						<th>Tên Khách Hàng</th>
						<th>Ngày Đặt</th>
						<th>Ghi Chú</th>
						<th>Hủy Đơn</th>
						<th>Quản Lý</th>
					</tr>
					<?php
					$i = 0;
					while($row_donhang = mysqli_fetch_array($sql_select)){ 
						$i++;
					?> 
					<tr>
						<td><?php echo $i; ?></td>
						
						<td><?php echo $row_donhang['magiaodich']; ?></td>
						<td><?php
							if($row_donhang['tinhtrang']==0){
								echo 'Chưa xử lý';
							}else{
								echo 'Đã xử lý';
							}
						?></td>
						<td><?php echo $row_donhang['name']; ?></td>
						
						<td><?php echo $row_donhang['ngaythang'] ?></td>
						<td><?php echo $row_donhang['note'] ?></td>
						<td><?php if($row_donhang['huydon']==0){ }elseif($row_donhang['huydon']==1){
							echo '<a href="xulydonhang.php?quanly=xemdonhang&magiaodich='.$row_donhang['magiaodich'].'&xacnhanhuy=2">Xác Nhận Hủy Đơn</a>';
						}else{
							echo 'Đã hủy';
						} 
						?></td>

						<td><a href="?xoadonhang=<?php echo $row_donhang['magiaodich'] ?>">Xóa</a> || <a href="?quanly=xemdonhang&magiaodich=<?php echo $row_donhang['magiaodich'] ?>">Xem </a></td>
					</tr>
					 <?php
					} 
					?> 
				</table>
			</div>
		</div>
	</div>
	
</body>
</html>