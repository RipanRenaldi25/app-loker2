<?php 

// id, nama, nim , email, jurusan , kelas, aksi

class Mahasiswa{
	var $conn;

	function __construct(){
		session_start();
		$server = "localhost";
		$nama = "root";
		$pw = "";
		$db = "tugas";
		$this->conn = mysqli_connect($server,$nama,$pw,$db);
	}

	
	public function getKelas(){
		$query = "SELECT * FROM kelas";
		return $this->conn->query($query);
	}

	public function setMahasiswa(){
		$nama = $_POST['nama'];
		$nim = $_POST['nim'];
		$email = $_POST['email'];
		$jurusan = $_POST['jurusan'];
		$kelas = $_POST['kelas'];

		$query = "INSERT INTO `mahasiswa2`( `nama`, `nim`, `email`, `kelas`, `jurusan`) VALUES ('$nama','$nim','$email','$kelas','$jurusan')";
		$result = $this->conn->query($query);
		header("location: mahasiswa.php");
	}


	public function deleteMahasiswa(){
		$id = $_GET['id'];

		$query = "DELETE FROM mahasiswa2 where id = $id";
		$result = $this->conn->query($query);
		header("location: mahasiswa.php");
	}

	public function updateMahasiswa(){
		$nama = $_POST['nama'];
		$nim = $_POST['nim'];
		$email = $_POST['email'];
		$kelas = $_POST['kelas'];
		$jurusan = $_POST['jurusan'];

		$query = "UPDATE mahasiswa2 SET nama= '$nama' , nim='$nim' , email='$email' , kelas='kelas', jurusan='$jurusan' WHERE nama = '$nama";
		
	}


	public function proses_registrasi(){
		if($_POST['password'] != $_POST['password2']){
			echo "<script>alert('password yang anda masukkan tidak sesuai');</script>";
			echo "<script>location='registrasi.php';</script>";
		}

		$username = $_POST['username'];
		$password = $_POST['password'];
		$query = "SELECT * FROM user WHERE username='$username'";
		$result = $this->conn->query($query);

		if(mysqli_fetch_assoc($result) > 0){
			echo "<script>alert('username yang anda masukkan sudah ada');</script>";
			echo "<script>location='registrasi.php'</script>";
		}else {
			$password = md5($password);
			$query = "INSERT INTO `user`(`username`, `password`) VALUES ('$username','$password')";
			$this->conn->query($query);
			echo "<script>alert('anda telah berhasil registrasi');</script>";
			echo "<script>location='login.php'</script>";
		}


	}


	public function proses_login(){

		
		$username = $_POST['username'];
		$password = md5($_POST['password']);

		$query = "SELECT * FROM user WHERE username='$username' && password='$password'";
		$result = $this->conn->query($query);

		if(mysqli_fetch_assoc($result) > 0){
			$_SESSION['login'] = true;
			header("location: mahasiswa.php");
		}else{
			echo "<script> alert('username atau password salah');</script>";
			echo "<script>location='login.php'; </script>";
		}

	}

	public function proses_logout(){
		session_destroy();
		echo "<script>alert('anda berhasil log out');</script>";
		echo "<script>location='login.php';</script>";
	}



}


$mhs = new Mahasiswa();

if(isset($_GET['edit'])){
	$mhs->setMahasiswa();
}

if(isset($_GET['delete'])){
	$mhs->deleteMahasiswa($_GET['id']);

}

if(isset($_GET['proses_login'])){
	$mhs->proses_login();
}

if(isset($_GET['proses_regist'])){
	$mhs->proses_registrasi();
}

if(isset($_POST['logout'])){
	$mhs->proses_logout();
}

 ?>
