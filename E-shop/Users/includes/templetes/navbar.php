<nav class="navbar navbar-expand-md  navbar-light">
  <a class="navbar-brand" href="control_page.php">
    <!-- <span style=" color: red;  
    font-weight: 400;
    font-size: 22px; ">Market</span><span style="font-weight: 200;
    font-size: 21px; " >Hub</span> -->
    <img src="layout/images/logo_2.png" alt="">
  

</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarScroll">
    <ul  class="navbar-nav mr-auto my-2 my-lg-0 navbar-nav-scroll" style="max-height: 100px;">
      <li class="nav-item ">
        <a class="nav-link" href="control_page.php">Home<span class="sr-only" >(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="shops.php">Shops</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="catogry_all.php">Categories</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="rooms.php">Chats</a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" href="#">Posts</a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link" href="contact_form.php">Contact us</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="AboutUS.php">About us</a>
      </li>

   
      </ul>
    <!-- search -->
      </li><input type="search" class="box" id="search-box" placeholder="Search here...">
      <button id="search" type="button" class="btn">
        <i class="fas fa-search"></i>
      </button>

    <!--  -->
      <ul class="navbar-nav ml-auto  my-2 my-lg-0 navbar-nav-scroll" style="max-height: 100px;margin-right: 30px;">

      <li class="nav-item_2 dropdown ">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
<?php echo $_SESSION['usernameA'] ?>
        </a>
        
        
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="customer_account.php?UserID=<?php echo $_SESSION['UserID'];?>"><span><i class="fa-solid fa-pen-to-square"></i> </span> Edit profile</a></li>
          <li><a class="dropdown-item" href="Favorat_list.php"> <span><i class="fa-solid fa-heart"></i></span> Favorite items</a></li>
          <li><a class="dropdown-item" href="my_orders.php"> <span><i class="fa-sharp fa-solid fa-cart-flatbed"></i></span> My orders</a></li>

          <li><hr class="dropdown-divider"></li>
          <hr class="m-0">
          <li><a class="dropdown-item" href="logout.php"><span><i class="fa-solid fa-right-from-bracket"></i></span>  Logout</a></li>
        </ul>


      <li class="nav-item">
        
        <a class="nav-link" href="cart.php"><span><i class="fa-solid fa-cart-shopping"></i></span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="search-btn" href="#"><span> </span></a>
      </li>
    

      <div class="input-group d-none">
        <div class="form-outline" id="serach-form">
        <input type="search" class="box" id="serach-box" placeholder="search here...">
          <button id="search-p" type="button" class="btn ">
          <i class="fas fa-search"></i>
        </button>
        </div>
  
      </div>

   
  

    </ul>
    

</div>
    
</nav>


