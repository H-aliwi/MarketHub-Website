<?php
session_start();
if (isset($_SESSION['usernameA'])) {
    $pageTitle = "About US";

    include("intil.php");
    ?>
    

<style>
    .lead,p {
        font-size: 18px;
        font-family: serif;
    }

    h3 {
        color:#f70808;
        font-size: 24px;
        font-family: serif;
    }

    .list-group-item {
        background-color: #f5f5f5;
        color: #333;
    }
    .feature-icon {
        width: 50px;
        height: 50px;
        background-color: #e0e0e0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }

    .feature-text {
        display: flex;
        align-items: center;
    }

</style>

<div class="container bg-form mt-3" style="min-height: 1105px; width:70%">
    <div class="row justify-content-center">
        <div class="row">
            <h1 class="d-flex ">About Us</h1>
        </div>

        <div class="col-md-12">

        <p class="lead">Welcome to our MarketHub website! We have created this website to serve as a platform that facilitates the buying and selling of goods, catering to both shop owners and customers. Our goal is to provide a user-friendly environment where users can set up virtual shops, list their products, and effectively promote them to a wide audience.</p>

<h3 class="mt-4">For Shop Owners:</h3>
<p>As a shop owner, you can take advantage of our platform to showcase your products to a large customer base. By creating a virtual shop, you can easily list your products and reach potential buyers from various locations. Our system offers tools and features that enable you to efficiently manage your inventory, process orders, and communicate with customers.</p>

<h3 class=" mt-4 mb-2">For Customers:</h3>
<p>We understand the importance of a seamless shopping experience. With our website MarketHub , you have the convenience of browsing through various categories and shops, exploring a wide range of options, and purchasing your desired products with just a few clicks. Our platform is designed to save you time and effort in finding and purchasing goods, offering an enjoyable and hassle-free shopping experience.</p>

<h2 class="mb-3 mt-5">Key Features:</h2>
<ul class="list-unstyled">
    <li>
        <div class="feature-text mb-4">
            <div class="feature-icon">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div>
                <h4>Virtual Shops</h4>
                <p>Shop owners can create their virtual shops, customize their profiles, and showcase their products to potential customers.</p>
            </div>
        </div>
    </li>
    <li>
        <div class="feature-text mb-4">
            <div class="feature-icon">
                <i class="fa fa-list"></i>
            </div>
            <div>
                <h4>Product Listings</h4>
                <p>Sellers can easily list their products, providing detailed descriptions, images, and pricing information.</p>
            </div>
        </div>
    </li>
    <li>
        <div class="feature-text mb-4">
            <div class="feature-icon">
                <i class="fa fa-globe"></i>
            </div>
            <div>
                <h4>Wide Audience Reach</h4>
                <p>Our MarketHub website offers a broad customer base, allowing sellers to reach customers nationwide.</p>
            </div>
        </div>
    </li>
    <li>
        <div class="feature-text mb-4">
            <div class="feature-icon">
                <i class="fa fa-comments"></i>
            </div>
            <div>
                <h4>Real-time Chatting</h4>
                <p>Users can communicate with each other within the system, enabling seamless interactions and fostering customer engagement.</p>
            </div>
        </div>
    </li>
</ul>





        </div>
    </div>
</div>
</div>

<?php
    include($tmpl . 'footer.php'); //<!-- footer -->
} else {
    echo "You are unauthorized to enter this page.";
    header('location:index.php');
}
?>