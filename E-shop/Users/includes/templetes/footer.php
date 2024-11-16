  <script src="layout/js/Jqueryy.js"></script>
  <script src="layout/js/backend.js"></script>
  <script src="layout/js/bootstrap.min.js"></script>


  <?php
   if (!isset($NoFooter)){
    
?>
  <footer class="footer mt-5">
      <img src="layout/images/logo_2.png" alt="">
      <div class="container " style="padding: 20px;">
          <div class="row">
              <div class="col-md-3">
                  <h4>Company</h4>
                  <ul>
                      <li><a href="AboutUS.php">About Us</a></li>
                      <li><a href="contact_form.php">Contact Us</a></li>
                      <!-- <li><a href="#">Terms and Conditions</a></li> -->
                  </ul>

              </div>
              <div class="col-md-3">
                  <h4>Quick links</h4>
                  <ul>
                      <li><a href="control_page.php">Home</a></li>
                      <li><a href="shops.php">Shops</a></li>
                      <li><a href="catogry_all.php">Categories </a></li>
                      <li><a href="rooms.php">Chat</a></li>

                  </ul>
              </div>
              <div class="col-md-3">
                  <h4>Support</h4>
                  <ul>
                      <li><a href="FAQs.php">FAQs</a></li>
                      <li><a href="#">Help Center</a></li>
                      <li><a href="#">Customer Service</a></li>
                  </ul>
              </div>
              <div class="col-md-3">
                  <h4>Follow Us</h4>
                  <ul>
                      <li><a href="#">Facebook</a></li>
                      <li><a href="#">Twitter</a></li>
                      <li><a href="#">Instagram</a></li>
                  </ul>
              </div>
          </div>
      </div>
      <div class=" p-3  text-center">
          <p style=" color: aliceblue;">&copy; 2023 Market Hub. All rights reserved. | Desigend by Hussain Aliwi</p>
      </div>
  </footer>


  <?php

}

  ?>





  </body>

  </html>