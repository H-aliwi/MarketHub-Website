$(function()
{
  'use strict';

  
  // hide placeholder on focus

  // selector name placeholder on focus

  $('[placeholder]').focus(function(){
  // when focus on selector name this=>placeholder 
  // create attribut data-text AND take content of placeholder and store in data-text
    $(this).attr('data-text', $(this).attr('placeholder'));

   $(this).attr('placeholder',''); // make attribut  of placeholder ''


  }).blur(function(){ //.blur  when move foucus retrurn data

    $(this).attr('placeholder',$(this).attr('data-text'));



  });
  

  

});
//
// $(function(){               'use strict';    })     way to
// $(this).attr(  "give name to storge", "take to store" );
// *name is required
// seerch start
$(document).ready(function() {
  $('#search').click(function() {
    var searchQuery = $('#search-box').val().trim();

    if (searchQuery !== '') {
      $.ajax({
        url: 'search.php',
        method: 'POST',
        data: { query: searchQuery },
        success: function() {
          // Redirect to the search results page
          window.location.href = 'search_results.php?search=' + searchQuery;
        },
        error: function() {
          alert('Error occurred during search.');
        }
      });
    }
  });
});
function closeMessageBox() {
  var messageBox = document.getElementById("message-box");
  messageBox.classList.add("hidden");
}

function closeMessageBoxShop() {
  var messageBox = document.getElementById("message-box-shop");
  messageBox.classList.add("hidden-shop");
}
function closeMessageBoxNewRate() {
    var messageBox = document.getElementById("message-box-rate");
    messageBox.classList.add("hidden-rate");
  }

function closeMessageBoxCustomer() {
  var messageBox = document.getElementById("message-box-cus");
  messageBox.classList.add("hidden-cus");
}

//for spane
var UsernameErr = document.getElementById('Username-err');
var passwordErr = document.getElementById('password-err');
var phoneErr = document.getElementById('phone-err');
var submitErr = document.getElementById('submit-err');


//  update customrt account validation start
// checkuser strt
function checkuser() {
  var pattern = /^[A-Za-z0-9]+$/;
  var user = $('#input-username').val();
  var validuser = pattern.test(user);

  if (user.length == 0) {
      $('#username_err').html('*Username is required');
      return false;
  } else if (!user.match(/^.{4,20}$/)) {
      $('#username_err').html('*At least 4 characters.');
      return false;
  } else if (!user.match(/^(?=.*[a-zA-Z].*[a-zA-Z].*[a-zA-Z])\S{4,}$/)) {
      $('#username_err').html('*Not less than 3 letters.');
      return false;
  } else if (!user.match(/^(?=[a-zA-Z]\w{3,})(?=.*[a-zA-Z].*[a-zA-Z].*[a-zA-Z])\w+$/)) {
      $('#username_err').html('*Must start with a letter.');
      return false;
  } else {
      // Check if the username is already taken
      var isUsernameValid = false; // Introduce a variable to track username validity

      $.ajax({
          type: "POST",
          url: "checkUsernameOnupdate.php",
          data: { username: user },
          async: false, // Set async to false to wait for the response
          success: function (response) {
              if (response == 1) {
                  $('#username_err').html('*Username is already taken.');
              } else {
                  $('#username_err').html('<i class="fa fa-duotone fa-circle-check"></i>');
                  isUsernameValid = true; // Set the variable to true if the username is valid
              }
          },
          error: function () {
              console.log("Error checking username");
              // Handle the error accordingly
          }
      });

      return isUsernameValid; // Return the username validity
  }
}

// checkuser END


// start eamil

function checkemail() {  
  var email = $('#input-Email').val();
 
  // 
  if(email.length == 0){
      $('#email_err').html('*email is required');
        return false;

  }
   else if(!email.match (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)){
      $('#email_err').html('*invalid email.');

       return false;
     }
     else {
      // Check if the Email is already taken
      var isemailValid = false; // Introduce a variable to track username validity

      $.ajax({
          type: "POST",
          url: "checkEmailOnUpdate.php",
          data: { email: email },
          async: false, // Set async to false to wait for the response
          success: function (response) {
              if (response == 1) {
                  $('#email_err').html('*Email is already taken.');
              } else {
                  $('#email_err').html('<i class="fa fa-duotone fa-circle-check"></i>');
                  isemailValid = true; // Set the variable to true if the username is valid
              }
          },
          error: function () {
              console.log("Error checking username");
              // Handle the error accordingly
          }
      });

      return isemailValid; // Return the username validity
  }

  // 
}


// END

// start  checkphone

function checkphone() {
  var phone = $('#phone').val();

      // 
      
      if (!phone) {
          $('#phone-err').html('');
          return true; // No file selected, validation passes
      }
      else
      {


      if(!phone.match (/^973\d{8}$/)){
      $('#phone-err').html('*invalid phone.');

       return false;
      }

          $('#phone-err').html('<i class="fa fa-duotone fa-circle-check"></i>');
          return true;

      }
  }


// END

// start  checkname

function checkname() {
  var name = $('#input-name').val();

      // 
      
      if (!name) {
          $('#fname-err').html('');
          return true; // No file selected, validation passes
      }
      else
      {


      if(!name.match (/^(?:[a-zA-Z][a-zA-Z\s]*[a-zA-Z])$/)){
      $('#fname-err').html('*invalid Name.');

       return false;
      }

          $('#fname-err').html('<i class="fa fa-duotone fa-circle-check"></i>');
          return true;

      }
  }


// END

// start checkAddress

function checkAddress() {
  var address = $('#address').val();

      // 
      
      if (!address) {
          $('#address-err').html('');
          return true; // No address selected, validation passes
      }
      else
      {




          $('#address-err').html('<i class="fa fa-duotone fa-circle-check"></i>');
          return true;

      }
  }


// END

//   Age

function checkage() {
  var age = $('#age').val();
      if (!age) {
          $('#age-err').html('');
          return true; // No address selected, validation passes
      }
      else
      {
          if(!age.match (/^(?:[1-9][0-9]?|100)$/)){
      $('#age-err').html('*invalid age.');

       return false;
      }
          $('#age-err').html('<i class="fa fa-duotone fa-circle-check"></i>');
          return true;

      }
  }
// END 

//   img 

function checkimg() {
      // 
      var fileimg = $('#input-img-customer')[0];
      var file = fileimg.files[0];
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
// END 

// on click 

$('#submitbtncusUpdate').click(function () {
        
  var isValid = true;

  // Perform your validation checks here
  if (!checkuser() || !checkemail() ||  !checkname()  || !checkphone() || !checkAddress() || !checkimg() || !checkage()) {
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
    var form = $('#customer-form-update')[0];
    var data = new FormData(form);

    // Show the modal
    $('#updatemodal').modal('show');

    // Event handler for the update button in the modal
    $('#updatemodal').on('click', '[name="submit-update-customer"]', function() {
        $.ajax({
            type: "POST",
            url: "customer_process.php",
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


// 



//  END validation
// Search start 
// let SearchForm =document.querySelector('#serach-form');

// document.querySelector('#search-btn').onclick =()=>{
//  SearchForm.classList.toggle('active');
// }


// Search end


//  slide start
const wrapper = document.querySelector(".wrapper");
const carousel = document.querySelector(".carousel");


const firstCardWidth = carousel.querySelector(".card").offsetWidth;
const arrowBtns = document.querySelectorAll(".wrapper i");
const carouselChildrens = [...carousel.children];

let isDragging = false, isAutoPlay = true, startX, startScrollLeft, timeoutId;

// Get the number of cards that can fit in the carousel at once
let cardPerView = Math.round(carousel.offsetWidth / firstCardWidth);

// Insert copies of the last few cards to beginning of carousel for infinite scrolling
carouselChildrens.slice(-cardPerView).reverse().forEach(card => {
    carousel.insertAdjacentHTML("afterbegin", card.outerHTML);
});

// Insert copies of the first few cards to end of carousel for infinite scrolling
carouselChildrens.slice(0, cardPerView).forEach(card => {
    carousel.insertAdjacentHTML("beforeend", card.outerHTML);
});

// Scroll the carousel at appropriate postition to hide first few duplicate cards on Firefox
carousel.classList.add("no-transition");
carousel.scrollLeft = carousel.offsetWidth;
carousel.classList.remove("no-transition");

// Add event listeners for the arrow buttons to scroll the carousel left and right
arrowBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        carousel.scrollLeft += btn.id == "left" ? -firstCardWidth : firstCardWidth;
    });
});

const dragStart = (e) => {
    isDragging = true;
    carousel.classList.add("dragging");
    // Records the initial cursor and scroll position of the carousel
    startX = e.pageX;
    startScrollLeft = carousel.scrollLeft;
}

const dragging = (e) => {
    if(!isDragging) return; // if isDragging is false return from here
    // Updates the scroll position of the carousel based on the cursor movement
    carousel.scrollLeft = startScrollLeft - (e.pageX - startX);
}

const dragStop = () => {
    isDragging = false;
    carousel.classList.remove("dragging");
}

const infiniteScroll = () => {
    // If the carousel is at the beginning, scroll to the end
    if(carousel.scrollLeft === 0) {
        carousel.classList.add("no-transition");
        carousel.scrollLeft = carousel.scrollWidth - (2 * carousel.offsetWidth);
        carousel.classList.remove("no-transition");
    }
    // If the carousel is at the end, scroll to the beginning
    else if(Math.ceil(carousel.scrollLeft) === carousel.scrollWidth - carousel.offsetWidth) {
        carousel.classList.add("no-transition");
        carousel.scrollLeft = carousel.offsetWidth;
        carousel.classList.remove("no-transition");
    }

    // Clear existing timeout & start autoplay if mouse is not hovering over carousel
    clearTimeout(timeoutId);
    if(!wrapper.matches(":hover")) autoPlay();
}

const autoPlay = () => {
    if(window.innerWidth < 800 || !isAutoPlay) return; // Return if window is smaller than 800 or isAutoPlay is false
    // Autoplay the carousel after every 3500 ms
    timeoutId = setTimeout(() => carousel.scrollLeft += firstCardWidth, 3500);
}
autoPlay();

carousel.addEventListener("mousedown", dragStart);
carousel.addEventListener("mousemove", dragging);
document.addEventListener("mouseup", dragStop);
carousel.addEventListener("scroll", infiniteScroll);
wrapper.addEventListener("mouseenter", () => clearTimeout(timeoutId));
wrapper.addEventListener("mouseleave", autoPlay);

// slide end


