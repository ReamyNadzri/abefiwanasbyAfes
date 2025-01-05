<?PHP
$namafail = basename($_SERVER['PHP_SELF']); // Mendapatkan nama fail semasa

if (empty($_SESSION['customerName'])) { // Semak jika sesi tidak wujud
    die("<script>alert('Please login first!');
    window.location.href='logout.php';</script>");
}
?>