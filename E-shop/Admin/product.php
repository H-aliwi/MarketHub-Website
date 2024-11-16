<?php
$NoNavbar =" ";
include("intil.php");

?>
<section name="navbar" > 
    
    <nav class="navbar navbar-expand-md  navbar-light ">
    <a class="navbar-brand" href="#">
        <span style="    color: red;
        font-weight: 400;
        font-size: 22px; ">SBE</span><span style="font-weight: 200;
        font-size: 22px;" >Shop</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
        <ul  class="navbar-nav mr-auto my-2 my-lg-0 navbar-nav-scroll" style="max-height: 100px;">
        <li class="nav-item ">
            <a class="nav-link" href="">Home<span class="sr-only" >(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Catogeries</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Chats</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Posts</a>
        </li>
     
        </ul>


        <ul class="navbar-nav ml-auto  my-2 my-lg-0 navbar-nav-scroll" style="max-height: 100px;margin-right: 70px;">
        <li class="nav-item_2 dropdown ">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
            About us
            </a>
            
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Contact us</a></li>
            <li><a class="dropdown-item" href="#">FQS</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php">team members</a></li>
            </ul>
        </li>

        </ul>
        

    </div>
        
    </nav>


</section>
<section name="second-navbar" >
    <div class="nav navbar navbar-expand-lg  navbar-dark bg-secondary">
        <ul class="navbar-nav me-auto">
            <li class="nav-item" >
                <a class="nav-link" href="#"> welcome Goust</a>

            </li>
            <li class="nav-item" >
                <a class="nav-link" href="#"> Login</a>

            </li>
        </ul>
    </div>
</section>

<style>
        .card-img-top{
            width: 100%;
    height: 200px;   
    object-fit: contain;   
    padding: 2px;

    }

    .card-flex {
        position: relative;
        /* display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        width: 100%; */
    }
    .like{
        position: absolute;
        top: -9px;
        right: 3px;
        font-size: 18px;
        color: black;
        
    }


</style>

<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-4 mb-2">

                    <div class="card" >
                    <img src="https://assets.products-live.ao.com/Images/7c3968a5-5f73-4496-9b60-3b7ce34ea33d/1280x853/108955953_9233391105_1.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <div class="card-flex ">
                            <h5 class="card-title">Card title</h5>
                            <a href="#"><span class="like" ><i class="fa-regular fa-heart"></i></span></a>

                        </div>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#"class="btn btn-light ">Chat </a>

                        <a href="#" class="btn ">View more </a>
                    </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4 mb-2">

                    <div class="card" >
                    <img src="https://www.vizio.com/content/dam/vizio/us/en/images/product/2021/tv/d-series/d40f-j09/gallery/2022_D-Series_D40f-J09_Front_Editors-Choice-Reviewed.jpg/_jcr_content/renditions/cq5dam.web.640.480.png" class="card-img-top" alt="...">
                    <div class="card-body">
                    <div class="card-flex ">
                            <h5 class="card-title">Card title</h5>
                            <a href="#"><span class="like" ><i class="fa-regular fa-heart"></i></span></a>

                        </div>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#"class="btn btn-light ">Chat </a>

                        <a href="#" class="btn ">View more </a>
                    </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-md-6 col-lg-4  mb-2">

                    <div class="card" >
                    <img   src="https://detec.in/cdn/shop/products/19_300acad9-741d-4907-87d6-94f95bbcdf7f.jpg?v=1671806857" class="card-img-top" alt="...">
                    <div class="card-body">
                    <div class="card-flex ">
                            <h5 class="card-title">Card title</h5>
                            <a href="#"><span class="like" ><i class="fa-regular fa-heart"></i></span></a>

                        </div>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#"class="btn btn-light ">Chat </a>

                        <a href="#" class="btn ">View more </a>
                    </div>
                    </div>
                </div>
                     <div class="col-sm-6 col-md-6 col-lg-4  mb-2">

                    <div class="card" >
                    <img   src="https://m.media-amazon.com/images/I/71pGGJSecBL._AC_UF1000,1000_QL80_.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                    <div class="card-flex ">
                            <h5 class="card-title">Card title</h5>
                            <a href="#"><span class="like" ><i class="fa-regular fa-heart"></i></span></a>

                        </div>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#"class="btn btn-light ">Chat </a>

                        <a href="#" class="btn ">View more </a>
                    </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4  mb-2">

                        <div class="card" >
                        <img   src="https://pisces.bbystatic.com/image2/BestBuy_US/images/products/6451/6451294_sd.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                        <div class="card-flex ">
                            <h5 class="card-title">Card title</h5>
                            <a href="#"><span class="like" ><i class="fa-regular fa-heart"></i></span></a>

                        </div>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#"class="btn btn-light ">Chat </a>

                            <a href="#" class="btn ">View more </a>
                        </div>
                        </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4  mb-2">

                        <div class="card" >
                        <img   src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQWf43OyV9ueYDZed1YN01U4L3CjEK-dtcwndvLa5azl-Bn-UxYHAFdL64gzy6VWIIJL3s&usqp=CAU" class="card-img-top" alt="...">
                        <div class="card-body">
                        <div class="card-flex ">
                            <h5 class="card-title">Card title</h5>
                            <a href="#"><span class="like" ><i class="fa-regular fa-heart"></i></span></a>

                        </div>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#"class="btn btn-light ">Chat </a>

                            <a href="#" class="btn ">View more </a>
                        </div>
                        </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4 mb-2">

                        <div class="card" >
                        <img   src="https://cdn.shopify.com/s/files/1/0024/9803/5810/products/654346-Product-0-I-638241268225604386_600x600.jpg?v=1691045785" class="card-img-top" alt="...">
                        <div class="card-body">
                        <div class="card-flex ">
                            <h5 class="card-title">Card title</h5>
                            <a href="#"><span class="like" ><i class="fa-regular fa-heart"></i></span></a>

                        </div>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#"class="btn btn-light ">Chat </a>

                            <a href="#" class="btn ">View more </a>
                        </div>
                        </div>
                </div>
                
           
            </div>

            

        </div>
        
        <div class="col-md-2 bg-secondary p-0">
            <ul class="navbar-nav me-auto text-center  ">
                    <li style="background-color: #192a51;" class="vab-item">
                  <h4 style="
                                            color: aliceblue;
                                    ">
                                        Catogeries</h4>
          
                
                </li>
                    <li  class="nav-item">
                    <a href=""> <h4 style="  color: aliceblue;  color: aliceblue;  font-size: 15px;  margin-top: 18px;">
                        sub-Catogeries 1</h4>
                    </a>
        
                </li>
                </li>
                    <li  class="nav-item">
                    <a href=""> <h4 style="  color: aliceblue;  color: aliceblue;  font-size: 15px;  margin-top: 18px;">
                        sub-Catogeries 2</h4>
                    </a>
        
                </li>
                </li>
                    <li  class="nav-item">
                    <a href=""> <h4 style="  color: aliceblue;  color: aliceblue;  font-size: 15px;  margin-top: 18px;">
                        sub-Catogeries 3</h4>
                    </a>
        
                </li>
                </li>
                    <li  class="nav-item">
                    <a href=""> <h4 style="  color: aliceblue;  color: aliceblue;  font-size: 15px;  margin-top: 18px;">
                        sub-Catogeries 4</h4>
                    </a>
        
                </li>
            </ul>
            <ul class="navbar-nav me-auto text-center mt-3 ">
                    <li style="background-color: #192a51;" class="vab-item">
                   <h4 style=" color: aliceblue">
                                        Location</h4>
                
                
                </li>
                    <li  class="nav-item mt-2 ">
                        <div class="form-group ">
                            <label for="inputState"><h4 style=" color: aliceblue;font-size: 18px;margin-top: 8px">
                            City:</h4></label>
                            <select id="inputState" >
                            <option selected>Choose...</option>
                             <option>Manama</option>
                            <option>Moharaq</option>
                            <option>Hamad Town</option>
                            

                            </select>
                        </div>
        
                </li>
          
            </ul>

            
        </div>



    </div>

</div>


<section name="footer"> 
    <div class=" p-3  text-center" style="  background-color: #192a51; " >
    <p style=" color: aliceblue;">&copy; 2023 BSE Shop. All rights reserved. | Desigend by Hussain Aliwi</p>
    </div>
</section>

<?php
include($tmpl .'footer.php') ;             //<!-- footer -->

?>




