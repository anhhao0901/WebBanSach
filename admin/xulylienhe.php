<?php
	include('../db/connect.php');
?>
<?php
	if(isset($_GET['xoa'])){
		$id= $_GET['xoa'];
		$sql_xoa = mysqli_query($con,"DELETE FROM tbl_lienhe WHERE lienhe_id='$id'");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="icon" href="../images/favicon.jpg" type="image/png"/>
	<title>Phản Hồi</title></title>
	<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <div class="collapse navbar-collapse" id="navbarNav">
	    <ul class="navbar-nav">
		<li class="nav-item">
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
		  <li class="nav-item active">
	        <a class="nav-link" href="xulylienhe.php">Phản Hồi</a>
	      
	    </ul>
	  </div>
	</nav><br><br>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h4>Liệt Kê Phản Hồi</h4>
				<?php
				$sql_select = mysqli_query($con,"SELECT * FROM tbl_lienhe ORDER BY lienhe_id DESC"); 
				?>
				<table class="table table-bordered ">
					<tr>
						<th>Thứ Tự</th>
						<th>Tên Khách Hàng</th>
						<th>Email</th>
                        <th>Nội Dung</th>
						<th>Ngày Phản Hồi</th>
                        <th>Quản Lý</th>
					</tr>
					<?php
					$i = 0;
					while($row_category = mysqli_fetch_array($sql_select)){ 
						$i++;
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $row_category['lienhe_name'] ?></td>
                        <td><?php echo $row_category['lienhe_email'] ?></td>
                        <td><?php echo $row_category['lienhe_noidung'] ?></td>
						<td><?php echo $row_category['lienhe_ngaythang'] ?></td>
						<td><a href="?xoa=<?php echo $row_category['lienhe_id'] ?>">Xóa</a></td>
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