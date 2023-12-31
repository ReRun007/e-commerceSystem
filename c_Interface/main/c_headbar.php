<?php
require_once '../../config/db.php';
require_once '../../config/bs5.php';
require_once 'cart.php'; // เรียกใช้ไฟล์ cart.php
session_start();
if (!isset($_SESSION['customer_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ';
    header('location: ../../customerLogin/signin.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/bg.css">
    
</head>
<body>
<div class="bg"></div>

    <?php
    if (isset($_SESSION['customer_login'])) {
        $customer_id = $_SESSION['customer_login'];
        $_SESSION['cart'] = loadCartForUser($customer_id); // ใช้ฟังก์ชัน loadCartForUser()
        $stmt = $conn->query("SELECT * FROM customers WHERE customer_id = $customer_id");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    ?>

    <header class="sticky-top p-3 text-bg-dark">
        <!-- โค้ดของ <header> จากไฟล์เดิม -->
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                  <a href="" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                      <img src="../../images/LogoEatKubTang.jpg" alt="Logo" height="45" style="border-radius: 5%;">
                  </a>
          
                  <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="../product/view_product.php" class="nav-link px-2 text-white">Product</a></li>
                    <li><a href="../order/view_order.php" class="nav-link px-2 text-white">Order</a></li>
                  </ul>
          

                  <a href="../cart/view_cart.php" class="btn btn-primary position-relative me-3">
                    ตะกร้าสินค้า
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                      <?php
                        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                            $cartQuantity = 0;
                            foreach ($_SESSION['cart'] as $cartItem) {
                                $cartQuantity += $cartItem['quantity'];
                            }
                            echo $cartQuantity;
                        } else {
                            echo '0';
                        }
                      ?>
                      <span class="visually-hidden">unread messages</span>
                    </span>
                  </a>
          
                  <div class="dropdown text-end">
                    <a href="#" class="d-block link-light link-offset-2 text-decoration-none dropdown-toggle " data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $row['img_URL']; ?>" alt="mdo" width="32" height="32" class="rounded-circle">
                        <?php echo $row['username']; ?> 
                    </a>
                    <ul class="dropdown-menu text-small text-center" style="">
                        <li><img src="<?php echo $row['img_URL']; ?>" alt="mdo" width="96" height="96" class="rounded-circle"></li>
                        <li><?php echo $row['username']; ?> </li>
                        <li><a class="dropdown-item" href="../../customerLogin/edit.php">Edit Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><button type="button" class="btn btn-outline-danger" onclick="logout('../../config/logout.php')">Logout</button></li>
                    </ul>
                  </div>
                </div>
              </div>
    </header>
</body>
</html>

<script>
  function logout(a) {
    // ใช้ window.confirm() เพื่อแสดงข้อความแจ้งเตือนและปุ่ม 'ยืนยัน' และ 'ยกเลิก'
    var result = window.confirm("ยืนยันการออกจากระบบ?");
      if (result) {
      window.location.href = a;
    } else {
    }
  }
  
</script>

