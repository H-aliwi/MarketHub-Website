
$(document).ready(function() {
    // .toggle-button
    $(".toggle-button").click(function() {
        $("nav").toggleClass("close");
        $(this).toggleClass('clicked');

        
    });
    // toggle-button end




});

const activePage = window.location.pathname;
const navLinks = document.querySelectorAll('nav a');

Array.from(navLinks).forEach((link) => {
  if (link.href.includes(activePage)) {
    link.classList.add('active');
  }
});






// start update item vaildation

$('#submitbtnitemUpdate').click(function () {
        
    var isValid = true;
  
    // Perform your validation checks here
    if ( !validateCategories() ||  !validateSubCategories() ||!validateTitle() || !validatedsc() || !validatePrice() || !validateQun() || !checkfileimg() ) {
        isValid = false;
        
        $("#message").html(`<div class="alert alert-warning" style="margin: 0px -16px;">Please fill all required fields</div>`);
        console.log("Validation error");
        window.scrollTo({
        top: 0,
        behavior: 'smooth'
                        });
    }
  
    if (isValid) {
      console.log("Validation successful");
      $("#message").html("");
      var form = $('#edit-item-form')[0];
      var data = new FormData(form);
  
      // Show the modal
      $('#updatemodal-item').modal('show');
  
      // Event handler for the update button in the modal
      $('#updatemodal-item').on('click', '[name="submit-update-item"]', function() {
          $.ajax({
              type: "POST",
              url: "",
              data: data,
              processData: false,
              contentType: false,
              success: function (data) {
                  $('#message').html(data);
                  $('#updatemodal').modal('hide'); // Hide the modal
  
                  // var message_new_customer = "Data updated successfully inserted";
                  // window.location.href = "customer_accountT.php?message_new_customer=" + encodeURIComponent(message_new_customer);
  
              },
              error: function () {
                  console.log("Error submitting form");
                  $("#message").html("<div class='alert alert-danger'>Error submitting form</div>");
              }
          });
      });
   }
  });

                // Function to validate the category selection
                function validateCategories() {
                    var selectedCategories = $('select[name="Category[]"]').val();
                    if (!selectedCategories || selectedCategories.length === 0) {
                        $("#category-err").html("*Please select item category");
                        return false;
                    } else {
                        $("#category-err").html('<i class="fa fa-duotone fa-circle-check"></i>');
                        return true;
                    }
                }
            
                    // Function to validate the sub-category selection
                    function validateSubCategories() {
                    var selectedSubCategories = $('select[name="sub-Category[]"]').val();
                    if (!selectedSubCategories|| selectedSubCategories.length === 0) {
                        $("#sub-category-err").html("*Please select sub category");
                        return false;
                    } else {
                        $("#sub-category-err").html('<i class="fa fa-duotone fa-circle-check"></i>');
                        return true;
                    }
                }
            
                    // Function to validate the item titel selection
                    function validateTitle() {
                        var title = $('#input-title').val();
                        if(title.length == 0){
                            $('#title-err').html('*title is required');
                                return false;
            
                        }
                            else if(!title.match (/^(?=(?:.*[a-zA-Z]){4})[a-zA-Z\d\s|()~-]{10,}$/)){
                            $('#title-err').html('*must contain 10 letters ');
            
                                return false;
                                
                            }
                            else if(!title.match (/^(?=(?:.*[a-zA-Z]){4})[a-zA-Z\d\s|()~-]{10,60}$/)){
                            $('#title-err').html('*maximum 60 letters.');
            
                                return false;
            
                                
                            }
                            else
                            {
                                $("#title-err").html('<i class="fa fa-duotone fa-circle-check"></i>');
                                 return true;
                            }
                }
                        // Function to validate the item dsc
                        function validatedsc() {
                        var title = $('#item-dsc').val();
                        if(title.length == 0){
                            $('#Item_description-err').html('*description is required');
                                return false;
            
                        }
                            else if(!title.match (/^(?=(?:.*[a-zA-Z]){10})[a-zA-Z\d\s.|\\#()%.,\"*{}[\]:\/><+\-]{10,}$/)){
                            $('#Item_description-err').html('*must contain 10 letters.');
            
                                return false;
                            }
                            else
                            {
                                $("#Item_description-err").html('<i class="fa fa-duotone fa-circle-check"></i>');
                                 return true;
                            }
                }  
                // END 
                function validatePrice() {
                        var Price = $('#Price').val();
                        if(Price.length == 0){
                            $('#Price-err').html('*Price is required');
                                return false;
            
                        }
                            else if(!Price.match (/^(?:[0-9]{1}\.[1-9]\d{2}|[0-9]{2}\.[0-9]{3}|[1-9]\d{0,2}(?:\.\d{3})?)$/
            )){
                            $('#Price-err').html('*must be >= 0.100');
            
                                return false;
                            }
                            else
                            {
                                $("#Price-err").html('<i class="fa fa-duotone fa-circle-check"></i>');
                                 return true;
                            }
                }      // END 
            
                function validateQun() {
                        var Qun = $('#Qun').val();
                        if(Qun.length == 0){
                            $('#Qun-err').html('*Price is required');
                                return false;
            
                        }
                            else if(!Qun.match (/^([1-9]|[1-9]\d|1\d{2}|200)$/)){
                            $('#Qun-err').html('*must be number 1-200');
            
                                return false;
                            }
                            else
                            {
                                $("#Qun-err").html('<i class="fa fa-duotone fa-circle-check"></i>');
                                 return true;
                            }
                }      // END 
            
                function validatediscount() {
                        var discount = $('#discount').val();
                        if(discount.length == 0){
                            $('#discount-err').html('*discount percent is required');
                                return false;
            
                        }
                            else if(!discount.match (/^(?:\d|[1-9]\d|100)$/)){
                            $('#discount-err').html('*must be number 0-100');
            
                                return false;
                            }
                            else
                            {
                                $("#discount-err").html('<i class="fa fa-duotone fa-circle-check"></i>');
                                 return true;
                            }
                }      // END 
            
                function checkfileimg() {
                var fileInput = $('#img')[0];
                var file = fileInput.files[0];
            
                if (!file) {
                    $('#img-err').html('');
                    return true; // No file selected, validation passes
                }
                else
                {
                        // Check file type
                    var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!allowedTypes.includes(file.type)) {
                        $('#img-err').html('*Only JPEG, PNG, and JPG images are allowedTTT');
                        return false;
                    }
          
                    // Check file size
                    var maxSize = 10 * 1024 * 1024; // 10 MB
                    if (file.size > maxSize) {
                        $('#img-err').html('*Logo size should be less than 10 MB');
                        return false;
                    }
          
                    $('#img-err').html('<i class="fa fa-duotone fa-circle-check"></i>');
                    return true;
          
                }
            }
            // END img


            // on click 




// end validation item


// start validation shop profile


// END validation shop

  