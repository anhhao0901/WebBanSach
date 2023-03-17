<?php
	include('../db/connect.php');
?>
<?php
	if(isset($_POST['themkhachhang'])){
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		$note = $_POST['note'];
		$email = $_POST['email'];
		$password = md5($_POST['password']);
		$sql_insert_khachhang = mysqli_query($con,"INSERT INTO tbl_khachhang(name,phone,address,note,email,password) values ('$name','$phone','$address','$note','$email','$password')");}
	elseif(isset($_POST['capnhatkhachhang'])) {
		$id_update = $_POST['id_update'];
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		$note = $_POST['note'];
		$email = $_POST['email'];
		$password = md5($_POST['password']);
		$sql_update_khachhang = mysqli_query($con,"UPDATE tbl_khachhang SET name='$name',phone='$phone',address='$address',note='$note',email='$email' ,password='$password' WHERE khachhang_id='$id_update'");
		header('Location:xulykhachhang.php');
	}
?> 
<?php
	if(isset($_GET['xoa'])){
		$id= $_GET['xoa'];
		$sql_xoa = mysqli_query($con,"DELETE FROM tbl_khachhang WHERE khachhang_id='$id'");
	} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="icon" href="../images/favicon.jpg" type="image/png"/>
	<title>Khách Hàng</title>
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
	       <li class="nav-item active">
	        <a class="nav-link" href="xulykhachhang.php">Khách Hàng</a>
	      </li>
		  <li class="nav-item">
	        <a class="nav-link" href="xulylienhe.php">Phản Hồi</a>
	      
	    </ul>
	  </div>
	</nav><br><br>
	<div class="container2">
		<div class="row">
		<?php
			if(isset($_GET['quanly'])=='capnhat'){
				$id_capnhat = $_GET['id'];
				$sql_capnhat = mysqli_query($con,"SELECT * FROM tbl_khachhang WHERE khachhang_id='$id_capnhat'");
				$row_capnhat = mysqli_fetch_array($sql_capnhat);
				?>
				<div class="col-md-4">
				<h4>Cập Nhật Khách Hàng</h4>
				<form action="" method="POST">
					<label>Tên Khách Hàng</label>
					<input type="text" class="form-control" name="name" value="<?php echo $row_capnhat['name'] ?>"><br>
					<input type="hidden" class="form-control" name="id_update" value="<?php echo $row_capnhat['khachhang_id'] ?>">
					<label>Số điện thoại</label>
					<input type="text" class="form-control" name="phone" value="<?php echo $row_capnhat['phone'] ?>"><br>
					<label>Địa Chỉ</label>
					<input type="text" class="form-control" name="address" value="<?php echo $row_capnhat['address'] ?>"><br>
					<label>Email</label>
					<input type="text" class="form-control" name="email" value="<?php echo $row_capnhat['email'] ?>"><br>
					<label>Mật Khẩu</label>
					<input type="text" class="form-control" name="password" value="<?php echo $row_capnhat['password'] ?>"><br>
					<label>Note</label>
					<input type="text" class="form-control" name="note" value="<?php echo $row_capnhat['note'] ?>"><br>
					<input type="submit" name="capnhatkhachhang" value="Cập nhật Khách Hàng" class="btn btn-default">
				</form>
				</div>
			<?php
			}else{
				?> 
				<div class="col-md-4">
				<h4>Thêm Khách Hàng</h4>
				
				<form action="" method="POST">	
					<label>Tên Khách Hàng</label>
					<input type="text" class="form-control" name="name" placeholder="Tên khách hàng" ><br>
					<label>Số điện thoại</label>
					<input type="text" class="form-control" name="phone" placeholder="Số điện thoại" ><br>
					<label>Địa Chỉ</label>
					<input type="text" class="form-control" name="address" placeholder="Địa chỉ"><br>
					<label>Email</label>
					<input type="text" class="form-control" name="email" placeholder="Email"><br>
					<label>Mật Khẩu</label>
					<input type="text" class="form-control" name="password" placeholder="Mật khẩu"><br>
					<label>Note</label>
					<input type="text" class="form-control" name="note" placeholder="Ghi chú"><br>
					<input type="submit" name="themkhachhang" value="Thêm Khách Hàng" class="btn btn-default">
				</form>
				</div>
				<?php
			} 
			
				?>
			<div class="col-md-8">
				<h4>Khách Hàng</h4>
				<?php
				$sql_khachhang = mysqli_query($con,"SELECT * FROM tbl_khachhang ORDER BY khachhang_id DESC");
				?> 
				<table class="table table-bordered ">
					<tr>
						<th>Thứ Tự</th>
						<th>Tên Khách Hàng</th>
						<th>Số Điện Thoại</th>
						<th>Địa Chỉ</th>
						<th>Email</th>
						<th>Ghi Chú</th>
						<th>Quản Lý</th>
					</tr>
					<?php
					$i = 0;
					while($row_khachhang = mysqli_fetch_array($sql_khachhang)){ 
						$i++;
					?> 
					<tr>
						<td><?php echo $i; ?></td>
						
						<td><?php echo $row_khachhang['name']; ?></td>
						<td><?php echo $row_khachhang['phone']; ?></td>
						<td><?php echo $row_khachhang['address']; ?></td>
						<td><?php echo $row_khachhang['email'] ?></td>
						<td><?php echo $row_khachhang['note'] ?></td>
						<td><a href="?xoa=<?php echo $row_khachhang['khachhang_id'] ?>">Xóa</a>|| <a href="xulykhachhang.php?quanly=capnhat&id=<?php echo $row_khachhang['khachhang_id'] ?>">Cập Nhật</a></td>
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