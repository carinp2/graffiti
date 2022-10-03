//
// Copyright (c) 2016, Carin Pretroius
// CEIT DEvelopment CC
//

//########################################################################################################## Document ready start
$( window ).on( "load", function() {
	 	if(window.location.href.indexOf('#login') != -1) {
		    $('#login').modal('show');
		 }
	 	if(window.location.href.indexOf('#registrationsuccess') != -1) {
		    $('#registrationsuccess').modal('show');
		 }
	 	if(window.location.href.indexOf('#validatesuccess') != -1) {
		    $('#validatesuccess').modal('show');
		 }
	 	if(window.location.href.indexOf('#validateerror') != -1) {
		    $('#validateerror').modal('show');
		 }
	 	if(window.location.href.indexOf('#loginsuccess') != -1) {
		    $('#loginsuccess').modal('show');
		 }	 		 	
	
        var dt = new Date();
        dt.setSeconds(dt.getMinutes() + 60);
        document.cookie = "cookie_graf_test=1; expires=" + dt.toGMTString();
        var cookiesEnabled = document.cookie.indexOf("cookie_graf_test=") != -1;
        if(!cookiesEnabled){
        	alert("Aktiveer asb jou leser se 'cookies' wanneer jy Graffiti besoek!\n\nPlease activate your browser cookies when visiting Grafitti!");
        }
        
    	//BACK BUTTON
    	$('#backButton').click(function(){//TODO add url
    		parent.history.back();
    		//window.location.href = document.referrer;
    		return false;
    	});
        
      //################################# Registration submit start
        $('#registerSubmit').click(function(e){
	       	 $('#register_complete').fadeOut(500);      	
	    	 $('#register_password').fadeOut(500); 
	    	 $('#register_error').fadeOut(500);     
	    	 $('#register_double').fadeOut(500); 
            e.preventDefault();
            var error = false;
            var type = $('#type').val();
            
            var firstname = $('#registerForm #firstname').val();
            var surname = $('#registerForm #surname').val();
            var email = $('#registerForm #email').val();
            var postal_address1 = $('#registerForm #postal_address1').val();
            var postal_city = $('#registerForm #postal_city').val();
            var postal_province = $('#registerForm #postal_province').val();
            var postal_code = $('#registerForm #postal_code').val();
			var phone = $('#registerForm #phone').val();
            if(type == "register"){
	            var password = $('#registerForm #password').val();
	            var password2 = $('#registerForm #password2').val();
            }
            
            if(firstname.length == 0){
                var error = true;
                $('#registerForm #firstname').addClass("validation");
            }else{
                $('#registerForm #firstname').removeClass("validation");
            }
            if(surname.length == 0){
                var error = true;
                $('#registerForm #surname').addClass("validation");
            }else{
                $('#registerForm #surname').removeClass("validation");
            }    
            if(email.length == 0){
                var error = true;
                $('#registerForm #email').addClass("validation");
            }else{
                $('#registerForm #email').removeClass("validation");
            }  
            if(postal_address1.length == 0){
                var error = true;
                $('#registerForm #postal_address1').addClass("validation");
            }else{
                $('#registerForm #postal_address1').removeClass("validation");
            }
            if(postal_city.length == 0){
                var error = true;
                $('#registerForm #postal_city').addClass("validation");
            }else{
                $('#registerForm #postal_city').removeClass("validation");
            }
            if(postal_province.length == 0){
                var error = true;
                $('#registerForm #postal_province').addClass("validation");
            }else{
                $('#registerForm #postal_province').removeClass("validation");
            }
            if(postal_code.length == 0){
                var error = true;
                $('#registerForm #postal_code').addClass("validation");
            }else{
                $('#registerForm #postal_code').removeClass("validation");
            }
            if(phone.length == 0){
                var error = true;
                $('#registerForm #phone').addClass("validation");
            }else{
                $('#registerForm #phone').removeClass("validation");
            }        			
            if(type == "register"){
	            if(password.length == 0){
	                var error = true;
	                $('#registerForm #password').addClass("validation");
	            }else{
	                $('#registerForm #password').removeClass("validation");
	            }
	            if(password2 != password){
	                var error = true;
	                $('#registerForm #password2').addClass("validation");
	                $('#registerForm #password').val();
	                $('#registerForm #password2').val()
	                $('#registerForm #register_password').fadeIn(500);          
	            }else{
	                $('#registerForm #password2').removeClass("validation");
	                $('#registerForm #register_password').fadeOut(500);     
	            }
	    	    var v = grecaptcha.getResponse();
	    	    if(v.length == 0){
	                var error = true;
	                $('.g-recaptcha div div').css('border', '1px solid #DA391E');
	                $('.g-recaptcha div div').css('background-color', '#DA391E');
	    	    }      
	    	    else{
	                $('.g-recaptcha div div').css('border', '0px');
	                $('.g-recaptcha div div').css('background-color', 'transparent');
		           	$('#registerForm #register_complete').fadeOut(500);      	
		        	$('#registerForm #register_password').fadeOut(500); 
		        	$('#registerForm #register_double').fadeOut(500); 
		        	$('#registerForm #register_error').fadeOut(500);                  
	    	    }
            }
            if(error == false){
                $.post("process.php", $("#registerForm").serialize(),function(result){
	               	 if(result == 'send'){
	               		$('#registerForm #register_success').fadeIn(500);    
	                	 $('#registerForm #register_complete').fadeOut(500);      	
	                	 $('#registerForm #register_password').fadeOut(500); 
	                	 $('#registerForm #register_double').fadeOut(500); 
	                	 $('#registerForm #register_error').fadeOut(500);   	       
	                	 
	                      $("#registerForm :input").attr("disabled", true);
	                      $("#registerForm :input").addClass('readonly');
	                      $("#registerForm :textarea").attr("disabled", true);
	                      $("#registerForm :textarea").addClass('readonly');	   
	                      $("#registerForm :button").attr("disabled", true);
	               	 }
	               	 else if(result == 'profile-success'){
		               		$('#registerForm #profile_success').fadeIn(500);    
		               		$('#registerForm #register_success').fadeOut(500);    		               		
		                	 $('#registerForm #register_complete').fadeOut(500);      	
		                	 $('#registerForm #register_password').fadeOut(500); 
		                	 $('#registerForm #register_double').fadeOut(500); 
		                	 $('#registerForm #register_error').fadeOut(500);   	       
		                	 
		                      $("#registerForm :input").attr("disabled", true);
		                      $("#registerForm :input").addClass('readonly');
		                      $("#registerForm :textarea").attr("disabled", true);
		                      $("#registerForm :textarea").addClass('readonly');	   
		                      $("#registerForm :button").attr("disabled", true);
		              }	               	 
	                 else if(result == 'error'){
	                	 $('#registerForm #register_complete').fadeOut(500);      	
	                	 $('#registerForm #register_password').fadeOut(500); 
	                	 $('#registerForm #register_double').fadeOut(500); 
	                	 $('#registerForm #register_error').fadeIn(500);          
	                 }
	                 else if(result == 'profile-error'){
	                	 $('#registerForm #register_complete').fadeOut(500);      	
	                	 $('#registerForm #register_password').fadeOut(500); 
	                	 $('#registerForm #register_double').fadeOut(500); 
	                	 $('#registerForm #register_error').fadeIn(500);          
	                 }	               	 
	                 else if(result == 'double'){
	                	 $('#registerForm #register_complete').fadeOut(500);      	
	                	 $('#registerForm #register_password').fadeOut(500); 
	                	 $('#registerForm #register_error').fadeOut(500);     
	                	 $('#registerForm #register_double').fadeIn(500); 
	                 }
                });
            }	    
          else {   
			  $('#registerForm #register_complete').fadeIn(500);   
          }        
           //e.preventDefault();       
        });  
    //################################# Registration submit end        
        
    //################################# Password change form start
        $('#changePasswordSubmit').click(function(e){
        	var userId =$(this).attr('data-src');
        	$('#passwordForm #password_success').fadeOut(500);    
       	 	$('#passwordForm #password_complete').fadeOut(500);      	
       	 	$('#passwordForm #password_password').fadeOut(500); 
       	 	$('#passwordForm #password_error').fadeOut(500);   	        	
        	$('#passwordForm #id').val(userId);
            $("#passwordForm :input").attr("disabled", false);
            $("#passwordForm :input").removeClass('readonly');
            $("#passwordForm :button").attr("disabled", false);
            $("#passwordForm #passwordClose").attr("disabled", false);        	            
        });         
    // ################################ Password change form end
        
    //################################# Password sumbit start
        $('#passwordSubmit').click(function(e){
	       	 $('#password_complete').fadeOut(500);      	
	    	 $('#password_password').fadeOut(500); 
           e.preventDefault();
           var error = false;
           
            var password = $('#passwordForm #password').val();
            var password2 = $('#passwordForm #password2').val();
	            if(password.length == 0){
	                var error = true;
	                $('#passwordForm #password').addClass("validation");
	            }else{
	                $('#passwordForm #password').removeClass("validation");
	            }
	            if(password2 != password){
	                var error = true;
	                $('#passwordForm #password').addClass("validation");
	                $('#passwordForm #password2').addClass("validation");
	                $('#passwordForm #password').val();
	                $('#passwordForm #password2').val();
	                $('#passwordForm #password_password').fadeIn(500);     
	            }else{
	            	$('#passwordForm #password').removeClass("validation");
	                $('#passwordForm #password2').removeClass("validation");
	                $('#passwordForm #password_password').fadeOut(500);     
	            }
          
           if(error == false){
               $.post("process.php", $("#passwordForm").serialize(),function(result){
	               	 if(result == 'password-success'){
	               		$('#passwordForm #password_success').fadeIn(500);    
	                	 $('#passwordForm #password_complete').fadeOut(500);      	
	                	 $('#passwordForm #password_password').fadeOut(500); 
	                	 $('#passwordForm #password_error').fadeOut(500);   	       
	                	 
	                      $("#passwordForm :input").attr("disabled", true);
	                      $("#passwordForm :input").addClass('readonly');
	                      $("#passwordForm :button").attr("disabled", true);
	                      $("#passwordForm #passwordClose").attr("disabled", false);
	               	 } 
	                 else if(result == 'password-error'){
	                	 $('#passwordForm #password_complete').fadeOut(500);      	
	                	 $('#passwordForm #password_password').fadeOut(500); 
	                	 $('#passwordForm #password_success').fadeOut(500);    
	                	 $('#passwordForm #password_error').fadeIn(500);          
	                 }
               });
         }	    
         else {  
       	  $('#passwordForm #password_complete').fadeIn(500);   
         }                
       });          
    // ################################ Password submit end
        
    //################################# Password reset start
    $('#passwordResetSubmit').click(function(e){
    	$('#reset_complete').fadeOut(500); 
    	$('#reset_success').fadeOut(500); 
    	$('#reset_error').fadeOut(500); 
    	$('#reset_not_exist').fadeOut(500); 
        e.preventDefault();
        var error = false;

        var username = $('#password_reset #username').val();
        
        if(username.length == 0){
            var error = true;
             $('#password_reset #username').addClass("validation");
        }else{
        	$('#password_reset #username').removeClass("validation");
        }
        if(error == false){
            $.post("process.php", $("#passwordResetForm").serialize(),function(result){
               	 if(result == 'reset_success'){
                	$('#reset_success').fadeIn(500);   	
                	$('#reset_complete').fadeOut(500); 
                	$('#reset_error').fadeOut(500); 
                	$('#reset_not_exist').fadeOut(500);                 	
               	 }
                 else if(result == 'reset_error'){
                	$('#reset_complete').fadeOut(500); 
                	$('#reset_not_exist').fadeOut(500);    
                	$('#reset_success').fadeOut(500);   	
                	$('#reset_error').fadeIn(500); 
                 }
                 else if(result == 'not_exist'){
                	 $('#reset_complete').fadeOut(500); 
                	 $('#reset_complete').fadeOut(500); 
                 	 $('#reset_error').fadeOut(500); 
                	 $("#reset_not_exist").fadeIn(500); 
                 }
            });
        }	    
      else {  
    	  $('#reset_complete').fadeIn(500);   
      }                
    });          
    // ################################ Password reset end        
        
    //################################# Login submit start
        $('#loginSubmit').click(function(e){
        	$('#login_error').fadeOut(500); 
        	$('#login_complete').fadeOut(500); 
        	$('#login_many').fadeOut(500); 
            e.preventDefault();
            var error = false;

            var username = $('#login #username').val();
            var password = $('#login #password').val();
            var language = $('#login #language').val();
            var url = $('#login #redirect-url').val();
            var vNewUrl = url.replace("/en/", "/"+language+"/");
            var vNewUrl = url.replace("/af/", "/"+language+"/");
            
            if(username.length == 0){
                var error = true;
                 $('#login #username').addClass("validation");
            }else{
            	$('#login #username').removeClass("validation");
            }
            if(password.length == 0){
                var error = true;
                $('#login #password').addClass("validation");
            }else{
            	$('#login #password').removeClass("validation");
            }  
            if(error == false){
                $.post("process.php", $("#loginForm").serialize(),function(result){
	               	 if(result == 'success'){
	                 	$('#login_error').fadeOut(500); 
	                	$('#login_complete').fadeOut(500); 
	                	$('#login_many').fadeOut(500);          
	                	$('#login').modal('hide');
	                	if( language == "af"){
	                		window.location.href = "af/Tuisblad";
	                	}
	                	else if( language == "en"){
	                		window.location.href = "en/Home";
	                	}
	               	 }
	                 else if(result == 'error'){
	                	 $('#login_complete').fadeOut(500);      	
	                	 $('#login_many').fadeOut(500); 
	                	 $('#login_error').fadeIn(500);          
	                 }
	                 else if(result == 'attempts'){
	                	 $('#login_complete').fadeOut(500);      	
	                	 $('#login_error').fadeOut(500);     
	                	 $('#login_many').fadeIn(500); 
	                 }
                });
            }	    
          else {  
        	  $('#login_complete').fadeIn(500);   
          }                
        });  
    //################################# Login submit end     
    
	/* carousel of home page animation */
	$('#myCarousel').carousel({
	  interval: 4000
	})
	 $('#featured').carousel({
	  interval: 4000
	})
//	$(function() {
//		$('#gallery a').lightBox();
//	});
    
    //############################### Shopping cart start
    $("[id^=cart-number]").on("change keyup paste", function() {
		    var vLanguage = $('#searchForm #language').val();
		    if(vLanguage == 'af'){
			   	var vAlert = "Jammer, jou aantal boeke kon nie verander word nie! Probeer asseblief weer.\n\nKontak Graffiti indien die fout herhaaldelik voorkom.";
		    }
		    else if(vLanguage == 'en'){
			   	var vAlert = "An error occurred. The number of book could not be updated. Please try again.\n\nPlease contact Graffiti if the error is not resolved.";
		    }    	  
    	
    		var cartId = $(this).attr('data-src');
    		var number = $(this).val();
    		var price = $("#cart-total-price-"+cartId).attr('data-src');
    		var newPrice = number * price;
    		var book_id =  $(this).attr('data-book');
    	   $("#cart-total-price-"+cartId).html("R "+newPrice); 
    	   $.fn.calculateTotalBookCost();

           $.post("order_process.php", {type: "update-cart-on-checkout", temp_cart_id: cartId, book_number: number, book_id: book_id},function(data){
           	if (data == 0) {
           		alert(vAlert);
             }
           	else if(data == 1){
				var theValue = number;
			    if(theValue > 2){
				    $('#big-order-message').fadeIn();
				    return false;
			   	} else {
			   		$('#big-order-message').fadeOut();
			   }          		
           	}
          });        	    	   
    	});
    
    $("[id^=remove-book-]").click(function(e){
	   	var cartId =$(this).attr('data-src');
		var vLanguage = $('#searchForm #language').val();
	    if(vLanguage == 'af'){
		   	var vAlert = "Is jy seker jy wil die boek uit jou mandjie verwyder?\n\nKlik 'OK' om voort te gaan!";
		   	var vDeleteAlert = "Jammer, die boek is nie verwyder uit jou mandjie nie! Probeer asseblief weer.\n\nKontak Graffiti indien die fout herhaaldelik voorkom.";
	    }
	    else if(vLanguage == 'en'){
		   	var vAlert = "Are you sure you want to remove this book from your cart?\n\nClick'OK' to continue!";
		   	var vDeleteAlert = "An error occurred. The book was not deleted from your cart. Please try again.\n\nPlease contact Graffiti if the error is not resolved.";
	    }    	          	   
	   if(confirm(vAlert)){
           $.post("order_process.php", {type: "delete-book", temp_cart_id: cartId},function(data){
              	if (data == 'error') {
              		alert(vDeleteAlert);
                }
              	else {
              		window.location.reload();
              	}
           });    
	   }
    });
    
    $("[id^=remove-wish-book-]").click(function(e){
	   	var wishId =$(this).attr('data-src');
	   	var vUrl =$(this).attr('data-url');
		var vLanguage = $('#searchForm #language').val();
	    if(vLanguage == 'af'){
		   	var vAlert = "Is jy seker jy wil die boek uit jou wenslys verwyder?\n\nKlik 'OK' om voort te gaan!";
		   	var vDeleteAlert = "Jammer, die boek is nie verwyder uit jou wenslys nie! Probeer asseblief weer.\n\nKontak Graffiti indien die fout herhaaldelik voorkom.";
	    }
	    else if(vLanguage == 'en'){
		   	var vAlert = "Are you sure you want to remove this book from your wish list?\n\nClick'OK' to continue!";
		   	var vDeleteAlert = "An error occurred. The book was not deleted from your wish list. Please try again.\n\nPlease contact Graffiti if the error is not resolved.";
	    }    	          	   
	   if(confirm(vAlert)){
           $.post("order_process.php", {type: "delete-wish-book", wish_id: wishId},function(data){
              	if (data == 'error') {
              		alert(vDeleteAlert);
                }
              	else {
              		window.location.href=vUrl;
              	}
           });    
	   }
    });    
    
    $.fn.calculateTotalBookCost = function() {
		var sum = 0;
		$('[id^=cart-total-price-]').each(function(){
			var theValue = $(this).text().substring(2);
		    sum += parseFloat(theValue);
		   $('#cart-total-all-books-price').html('R '+sum+''); 
		   $('#total-price').val(sum);
		});  
    }
    
    //Move to wishlist
    $("#move-to-wishlist").click(function(e){
		var vLanguage = $('#searchForm #language').val();
	    if(vLanguage == 'af'){
		   	var vMoveAlert = "Jammer, die boek is nie na jou wenslys geskuif nie! Probeer asseblief weer.\n\nKontak Graffiti indien die fout herhaaldelik voorkom.";
	    }
	    else if(vLanguage == 'en'){
		   	var vMoveAlert = "An error occurred. The book was not moved to your wishlist. Please try again.\n\nPlease contact Graffiti if the error is not resolved.";
	    }    	      	
    	var cartId =$(this).attr('data-src');
    	var bookId =$(this).attr('data-book');
        $.post("order_process.php", {type: "move-book", temp_cart_id: cartId, book_id:bookId},function(data){
          	if (data == 'error') {
          		alert(vMoveAlert);
            }
          	else {
          		window.location.reload();
          	}
       });  
    });
    
    //Add to wishlist
    $("[id^=add-to-wishlist]").click(function(e){
		var vLanguage = $('#searchForm #language').val();
	    if(vLanguage == 'af'){
		   	var vAddAlert = "Jammer, die boek is nie in jou wenslys gelaai nie! Probeer asseblief weer.\n\nKontak Graffiti indien die fout herhaaldelik voorkom.";
	    }
	    else if(vLanguage == 'en'){
		   	var vAddAlert = "An error occurred. The book was not added to your wishlist. Please try again.\n\nPlease contact Graffiti if the error is not resolved.";
	    }    	      	
    	var bookId =$(this).attr('data-book');
        $.post("order_process.php", {type: "add-wishlist-book", book_id:bookId},function(data){
          	if (data == 'error') {
          		alert(vAddAlert);
          		$('#wishlist_double'+bookId).fadeOut(500);       
          		$('#wishlist_success'+bookId).fadeOut(500);   
            }
          	else if(data == 'double'){
          		$('#add-to-wishlist'+bookId).fadeOut(500);   
          		$('#wishlist_double'+bookId).fadeIn(500);   
          		$('#wishlist_success'+bookId).fadeOut(500);   
          	}
          	else {
          		$('#add-to-wishlist'+bookId).fadeOut(500); 
          		$('#wishlist_double'+bookId).fadeOut(500);       
          		$('#wishlist_success'+bookId).fadeIn(500);   
          	}
       });  
    });    
    
    //Delivery address start
    $("[id^=delivery-]").click(function(e){
		$('#orderCourierForm #deliver_name').val("");
		$('#orderCourierForm #deliver_address1').val("");
		$('#orderCourierForm #deliver_address2').val("");
		$('#orderCourierForm #deliver_city').val("");
		$('#orderCourierForm #deliver_province').val("");
		$('#orderCourierForm #deliver_country').val("");
		$('#orderCourierForm #deliver_code').val("");
		$('#orderCourierForm #deliver-phone').val("");
		$('#orderCourierForm #courier-detail').val("");    	
		var type =$(this).attr('data-src');    	
		var thisAddress = "#"+type+"_check";
    	if ($(this).is(':checked')) {
    		$('#delivery_address_error').fadeOut(500);   
    		$('#cartSubmitStep2').fadeIn(500);   
    		if(type == "postal"){
    			$( "#delivery-physical").prop('checked', false);
    			$("#physical-check").removeClass( "selected-div" );
    			$( "#delivery-new").prop('checked', false);
    			$("#new-check").removeClass( "selected-div" );		
    			$("#postal-check").addClass( "selected-div" );
    		}
    		else if(type == "physical"){
    			$( "#delivery-postal").prop('checked', false);
    			$("#postal-check").removeClass( "selected-div" );	
    			$( "#delivery-new").prop('checked', false);
    			$("#new-check").removeClass( "selected-div" );	 			
    			$("#physical-check").addClass( "selected-div" );
    		} 
    		else if(type == "new"){
    		    $("#new_name, #new_1, #new_2, #new_city, #new_province, #new_country, #new_code, #new_phone").prop("disabled", false);
    			$( "#delivery-postal").prop('checked', false);
    			$("#postal-check").removeClass( "selected-div" );	
    			$( "#delivery-physical").prop('checked', false);
    			$("#physical-check").removeClass( "selected-div" );
    			$("#new-check").addClass( "selected-div" );
    		}
    	}
    	else {
    		$("#"+type+"-check").removeClass( "selected-div" );
    	}
    });    
    $("#new_name, #new_1, #new_2, #new_city, #new_province, #new_country, #new_code, #new_phone").on('change', function() {
		$('#delivery_address_error').fadeOut(500);   
		$('#cartSubmitStep2').fadeIn(500);    		    	
//    	if ($("#delivery-new").is(":checked")) {
//    		$.fn.upDateDeliveryAddress("new");
//    	}
    }); 
    
    jQuery.fn.extend({
        upDateDeliveryAddress: function (theType) {
        	if (theType == "new") {
        		var deliver_name = $("#new_name").val();
	    		var address1 = $("#new_1").val();
	    		var address2 = $("#new_2").val();
	    		var city = $("#new_city").val();
	    		var province = $("#new_province").val();
	    		var country = $("#new_country").val();
	    		var code = $("#new_code").val();
	    		var deliver_phone = $("#new_phone").val();
	    		var pargo_point_code = $("#pargo_point_code").val();
	    		
	    		$('#orderCourierForm #deliver_name').val(deliver_name);
	    		$('#orderCourierForm #deliver_address1').val(address1);
	    		$('#orderCourierForm #deliver_address2').val(address2);
	    		$('#orderCourierForm #deliver_city').val(city);
	    		$('#orderCourierForm #deliver_province').val(province);
	    		$('#orderCourierForm #deliver_country').val(country);
	    		$('#orderCourierForm #deliver_phone').val(deliver_phone);
	    		$('#orderCourierForm #courier_detail').val(pargo_point_code);
	    		if(code.length == 1){
	    			$('#orderCourierForm #deliver_code').val("000"+code);
	    		}
	    		else if (code.length == 2){
	    			$('#orderCourierForm #deliver_code').val("00"+code);
	    		}
	    		else if (code.length == 3){
	    			$('#orderCourierForm #deliver_code').val("0"+code);
	    		}
	    		else if (code.length >= 4){
	    			$('#orderCourierForm #deliver_code').val(code);
	    		}
	        }
        	else{
        		var deliver_name = "";
	    		var address1 = $("#"+theType+"-check").attr('data-address1');
	    		var address2 = $("#"+theType+"-check").attr('data-address2');
	    		var city = $("#"+theType+"-check").attr('data-city');
	    		var province = $("#"+theType+"-check").attr('data-province');
	    		var country = $("#"+theType+"-check").attr('data-country');
	    		var code = $("#"+theType+"-check").attr('data-code');
	    		var deliver_phone = "";
	    		$('#orderCourierForm #name').val(deliver_name);
	    		$('#orderCourierForm #deliver_address1').val(address1);
	    		$('#orderCourierForm #deliver_address2').val(address2);
	    		$('#orderCourierForm #deliver_city').val(city);
	    		$('#orderCourierForm #deliver_province').val(province);
	    		$('#orderCourierForm #deliver_country').val(country);
	    		$('#orderCourierForm #deliver_code').val(code);
	    		$('#orderCourierForm #phone').val(deliver_phone);
        	}
        }
    });
    //Delivery address end
    
    //Courier selection start    
    $("#courier-type").change(function(){
    	$("#delivery-postal, #delivery-physical, #delivery-new").prop("disabled", false);
    	$("#delivery-postal").prop('checked', false);
    	$("#delivery-physical").prop('checked', false);
    	$("#delivery-new").prop('checked', false);    
    	
    	$("#postal-check").removeClass( "selected-div" );
		$("#physical-check").removeClass( "selected-div" );
		$("#new-check").removeClass( "selected-div" );    	
    	
		$("#cart-courier-cost").html("");
		$("#cart-total-order-cost").html("");    	
    	$("#total-cart-cost").addClass( "no-display" );
		$("#normal-cart-message").addClass( "no-display" );
		$("#courier-cart-message").addClass( "no-display" );
		$("#country-cart-courier-select").addClass( "no-display" );
		$("#text-cart-courier-cost").addClass( "no-display");    	

		$('#delivery_courier_error').fadeOut(500);   
		$('#delivery_address_error').fadeOut(500);   

    	var select = $("#courier-type option:selected").val();
		if (select != "") {
			$('#cartSubmitStep2').fadeIn(500);   
		}    	
    	switch(select){
	    	case "1": //Normal postage
	    		$("#text-cart-courier-cost").removeClass( "no-display");
	    		$("#normal-cart-message").removeClass( "no-display" );
	    		$("#courier-cart-message").addClass( "no-display" );
	    		
	    		var book_cost =  $("#cart-total-all-books-price").html().substr(2);
	    		if(book_cost < 400){
	    			var delivery_cost =  $("#normal-cart-courier-cost").html();
	    		}
	    		else {
	    			var delivery_cost = 0;
	    		}
	    		$("#cart-courier-cost").html("R "+delivery_cost);
	    		
	    		var total_cost = parseInt(book_cost)+parseInt(delivery_cost);
	    		$("#cart-total-order-cost").html("R "+ total_cost);
	    		$("#total-cart-cost").removeClass( "no-display" );
	    		$("#country-cart-pargo-select").addClass( "no-display");
	    	break;
	
	    	case "2": //Courier - CourierIT Main cities
	    		$("#text-cart-courier-cost").removeClass( "no-display");
	    		$("#normal-cart-message").removeClass( "no-display" );
	    		$("#courier-cart-message").removeClass( "no-display" );
	    		
	    		var delivery_cost =  $("#courierit-main-cart-courier-cost").html();
	    		$("#cart-courier-cost").html("R "+delivery_cost);
	    		
	    		var book_cost =  $("#cart-total-all-books-price").html().substr(2);
	    		var total_cost = parseInt(book_cost)+parseInt(delivery_cost);
	    		$("#cart-total-order-cost").html("R "+ total_cost);
	    		$("#total-cart-cost").removeClass( "no-display" );	    
	    		$("#country-cart-pargo-select").addClass( "no-display");
	    	break;
	
	    	case "3": //Courier - Pargo
	    		$("#country-cart-pargo-select").removeClass( "no-display");
	    		$("#text-cart-courier-cost").removeClass( "no-display");
	    		$("#normal-cart-message").removeClass( "no-display" );
	    		$("#courier-cart-message").removeClass( "no-display" );
	    		
	    		$("#delivery-postal, #delivery-physical, #delivery-new").prop("disabled", true);
	    		
	    		var book_cost =  $("#cart-total-all-books-price").html().substr(2);
	    		var delivery_cost =  $("#pargo-cart-courier-cost").html();
	    		$("#cart-courier-cost").html("R "+delivery_cost);
	    		
	    		var total_cost = parseInt(book_cost)+parseInt(delivery_cost);
	    		$("#cart-total-order-cost").html("R "+ total_cost);
	    		$("#total-cart-cost").removeClass( "no-display" );	    		
	    	break;
	    	
	    	case "4": //Collect
	    		$("#text-cart-courier-cost").removeClass( "no-display");
	    		$("#cart-courier-cost").html("R 0");
	    		$("#courier-cart-message").addClass( "no-display" );
	    		
	    		var book_cost =  $("#cart-total-all-books-price").html().substr(2);
	    		var total_cost = book_cost;
	    		$("#cart-total-order-cost").html("R "+ total_cost);
	    		$("#total-cart-cost").removeClass( "no-display" );	 
	    		$("#country-cart-pargo-select").addClass( "no-display")

	    		//Select delivery address 	    		
		    	$("#delivery-postal").prop('checked', false);
		    	$("#delivery-physical").prop('checked', false);
		    	$("#delivery-new").prop('checked', false);

		    	$("#postal-check").removeClass( "selected-div" );
    			$("#physical-check").removeClass( "selected-div" );
    			$("#new-check").removeClass( "selected-div" );	
	    		
				 $("#new_name").val(' ');
				 $("#new_1").val('Graffiti Zambezi Junction');
				 $("#new_2").val(' ');
				 $("#new_city").val(' ');
				 $("#new_province").val(' ');
				 $("#new_country").val(' ');
				 $("#new_code").val('    ');
				 $("#new_phone").val(' ');

				 $("#delivery-new").prop('checked', true);
			     $("#new-check").addClass( "selected-div" );
			     $("#delivery-postal, #delivery-physical, #delivery-new").prop("disabled", true);
		    	break;	 
	    		
	    	case "5": //Other country
	    		$("#country-cart-courier-select").removeClass( "no-display" );
	    		$("#country-cart-pargo-select").addClass( "no-display")
	    		$("#courier-cart-message").addClass( "no-display" );
	    	break;   	
	    	
	    	case "6": //Courier -  CourierIT Regional
	    		$("#text-cart-courier-cost").removeClass( "no-display");
	    		$("#normal-cart-message").removeClass( "no-display" );
	    		$("#courier-cart-message").removeClass( "no-display" );
	    		
	    		var delivery_cost =  $("#courierit-regional-cart-courier-cost").html();
	    		$("#cart-courier-cost").html("R "+delivery_cost);
	    		
	    		var book_cost =  $("#cart-total-all-books-price").html().substr(2);
	    		var total_cost = parseInt(book_cost)+parseInt(delivery_cost);
	    		$("#cart-total-order-cost").html("R "+ total_cost);
	    		$("#total-cart-cost").removeClass( "no-display" );	    		
	    		$("#country-cart-pargo-select").addClass( "no-display");
	    	break;	    
	    	
	    	case "7": //Courier -  CourierIT Jhb, Pta
    		$("#text-cart-courier-cost").removeClass( "no-display");
    		$("#normal-cart-message").removeClass( "no-display" );
    		$("#courier-cart-message").removeClass( "no-display" );
    		
    		var delivery_cost =  $("#courierit-jhbpta-cart-courier-cost").html();
    		$("#cart-courier-cost").html("R "+delivery_cost);
    		
    		var book_cost =  $("#cart-total-all-books-price").html().substr(2);
    		var total_cost = parseInt(book_cost)+parseInt(delivery_cost);
    		$("#cart-total-order-cost").html("R "+ total_cost);
    		$("#total-cart-cost").removeClass( "no-display" );	    
    		$("#country-cart-pargo-select").addClass( "no-display");
	    	break;	     		
    	}
    });
    //Country selection
    $("#country-select").change(function(){
		var selectCourier = $("#courier-type option:selected").val();
		if(selectCourier == 5){
    		$("#text-cart-courier-cost").removeClass( "no-display");
    		$("#normal-cart-message").removeClass( "no-display" );
    		$("#courier-cart-message").addClass( "no-display" );
    		
    		var country_cost = $("#country-select option:selected").val();
    		$("#cart-courier-cost").html("R "+country_cost);

    		var book_cost =  $("#cart-total-all-books-price").html().substr(2);
    		var courier_cost = country_cost
    		var total_cost = parseInt(book_cost)+parseInt(courier_cost);
    		$("#cart-total-order-cost").html("R "+ total_cost);
    		$("#total-cart-cost").removeClass( "no-display" );	      
    		var country = $("#country-select option:selected").val();
    		if(country != "" && country > 0){
    			$('#delivery_courier_error').fadeOut(500);   
    			$('#cartSubmitStep2').fadeIn(500);  
    		}
		}
	});
    //Country selection end
    
    //Courier submit start
	$("#cartSubmitStep2").bind("click",function(e){
		//Update final delivery info start
		 if($("#delivery-postal").is(':checked')){
			 var deliveryType =$("#delivery-postal").attr('data-src');    		
			 $.fn.upDateDeliveryAddress(deliveryType);
		 }
		 else if($("#delivery-physical").is(':checked')){
			 var deliveryType =$("#delivery-physical").attr('data-src');    		
		 }
		 else if($("#delivery-new").is(':checked')){
			 var deliveryType =$("#delivery-new").attr('data-src');    		
		 }
		 else {
			 var error = true;
			 $('#delivery_address_error').fadeIn(500); 
			 $('#cartSubmitStep2').fadeOut(500);   
		 }
		 $.fn.upDateDeliveryAddress(deliveryType);
		//Update final delivery info end
	
		var courier_type = $("#orderCourierForm #courier-type").val();
		if(courier_type == 5){
			var courier_detail = $("#orderCourierForm #country-select option:selected").attr("data");
		}
		else if (courier_type == 3){
			var courier_detail = $("#orderCourierForm #pargo_point_code").val();
		}
	  	var courier_cost = $("#cart-courier-cost").html().substr(2);
	  	var deliver_address1 = $("#orderCourierForm #deliver_address1").val();
	  	var deliver_city = $("#orderCourierForm #deliver_city").val();
	  	var deliver_code = $("#orderCourierForm #deliver_code").val();
	  	var total_cost = $("#cart-total-order-cost").html().substr(2);
	  	var cost = $("#orderCourierForm #cart-total-all-books-price").html().substr(2);
	  	 
	  	$("#orderCourierForm #courier_type").val(courier_type);
	  	$("#orderCourierForm #courier_cost").val(courier_cost);
	  	$("#orderCourierForm #courier_detail").val(courier_detail);
	  	$("#orderCourierForm #total_price").val(total_cost);
	  	$("#orderCourierForm #price").val(cost);

        if(courier_type == ""){
        	var error = true;
        	$('#orderCourierForm #courier-type').addClass("validation");
        	$('#cartSubmitStep2').fadeOut(500);   
        }
        else {
        	$('#orderCourierForm #courier-type').removeClass("validation");
        	$('#cartSubmitStep2').fadeIn(500);   
        }		  	
        if(courier_type == 5 && courier_detail == ""){
        	var error = true;
        	$('#orderCourierForm #country-select').addClass("validation");
        	$('#cartSubmitStep2').fadeOut(500);   
        }
        else {
        	$('#orderCourierForm #country-select').removeClass("validation");
        	$('#cartSubmitStep2').fadeIn(500);   
        }	  	
	  	
        if(courier_cost.length == 0){
            var error = true;
            $('#delivery_courier_error').fadeIn(500); 
            $('#cartSubmitStep2').fadeOut(500);   
            return false; 
        }else{
        	$('#delivery_courier_error').fadeOut(500);   
        	$('#cartSubmitStep2').fadeIn(500);   
        }

        if(deliver_address1.length == 0 || deliver_city.length == 0 || deliver_code.length == 0){
            var error = true;
            $('#delivery_address_error').fadeIn(500); 
            $('#cartSubmitStep2').fadeOut(500);   
            return false; 
        }else{
        	$('#delivery_address_error').fadeOut(500);   
        	$('#cartSubmitStep2').fadeIn(500);   
        }     
        
        if(total_cost.length == 0){
            var error = true;
            $('#delivery_courier_error').fadeIn(500); 
            $('#cartSubmitStep2').fadeOut(500);   
            return false; 
        }else{
        	$('#delivery_courier_error').fadeOut(500);   
        	$('#cartSubmitStep2').fadeIn(500);   
        }        
        
        if(error == false){
        	$('#cartSubmitStep2').fadeIn(500);   
        	$("#orderCourierForm").submit();
        }	    
        else {  
        	$('#cartSubmitStep2').fadeIn(500);   
        	$('#delivery_incomplete').fadeIn(500);   
        }         
//        e.preventDefault();
	});    
	//Courier submit end
	
    //Payment type start
    $("[id^=payment-]").click(function(e){
    	if ($(this).is(':checked')) {
    		var payment_type =$(this).val();    	
    		
    		$('#payment_type_error').fadeOut(500);   
    		$('#paymentSubmit').fadeIn(500);   
			$("[id^=payment-]").prop('checked', false);
			$(this).prop('checked', true);
			$("[id^=payment-check-]").removeClass( "selected-div" );
			$("#payment-check-"+payment_type).addClass("selected-div");
    	}
    });    	
    
    //Check delivery address & courier option on "back" load
    $("#courier-type").trigger('change');   
    $("#country-select").trigger('change');   
    $("#tc").trigger('change');
    
    if ($("#courier-type").val() == 3) {
    	$("#delivery-new").prop('checked', true);
    }
    
    if ($("#delivery-new").is(':checked') && $("#courier-type").val() != 3) {
    	$("#new_name, #new_1, #new_2, #new_city, #new_province, #new_country, #new_code, #new_phone").prop("disabled", false);
    }
    else if($("#delivery-new").is(':checked') && $("#courier-type").val() == 3){
    	$("#new_name, #new_1, #new_2, #new_city, #new_province, #new_country, #new_code, #new_phone").prop("disabled", true);
    }
    
    if ($("#tc").is(':checked')) {
    	$("#cartSubmitStep1").fadeIn("slow");
	} else {
		$("#cartSubmitStep1").fadeOut("slow");
	} 
    
    $("#tc").click(function(e){
    	if ($(this).is(':checked')) {
    		$("#cartSubmitStep1").fadeIn("slow");
    	} else {
    		$("#cartSubmitStep1").fadeOut("slow");
    	} 
    });    	
    
    //TOOLTIP;
    $('[data-toggle="tooltip"]').tooltip(); 

	//EMAIL	
	$('a.email').each(function ()
	{
		var text = $(this).text();
		var address = text.replace(" at ", "@");
		$(this).attr('href', 'mailto:' + address);
		$(this).text(address);
	});	
	
	//EMAIL with subject & other
	$('a.email-event').each(function ()
	{
		var subject =$(this).attr('data-type');    	
		var date =$(this).attr('data-date');    	
		var text = $(this).text();
		var address = text.replace(" at ", "@");
		$(this).attr('href', 'mailto:' + address + "?subject="+subject+": "+date);
		$(this).text(address);
	});	
	
	
	//Scroll to the top
	 $("#scrollToTop").bind("click",function(e){
	 e.preventDefault();
	 
	// Animate the scrolling motion.
	 $("html, body").animate({
	 scrollTop:0
	 },"slow");
	 //Set menu to static
	 $("#static-header").css({position: 'fixed'});
	 
	});
	 

	// Hide the scrollToTop button when the page loads.
	$("#scrollToTop").css("display", "none");

	// This function runs every time the user scrolls the page.
	$(window).scroll(function(){
	  if($(window).scrollTop() > 0){
		$("#scrollToTop").fadeIn("slow");
		} else {
		  $("#scrollToTop").fadeOut("slow");
		}
	});	
	
	//Read more/less start 
	var vLanguage = $('#searchForm #language').val();
    if(vLanguage == 'af'){	
		var vMore = "<span class='text-small-normal red right'>Wys meer<i class='fa fa-chevron-down icon-spacing' aria-hidden='true'></i></span>";
		var vLess = "<span class=\'text-small-normal red right\'>Wys minder<i class=\'fa fa-chevron-up icon-spacing\' aria-hidden=\'true\'></i></span>";
    }
    else {
		var vMore = "<span class='text-small-normal red right'>Show more<i class='fa fa-chevron-down icon-spacing' aria-hidden='true'></i></span>";
		var vLess = "<span class=\'text-small-normal red right\'>Show less<i class=\'fa fa-chevron-up icon-spacing\' aria-hidden=\'true\'></i></span>";
    }	
    $('[id^=showmore_]').each(function () {    	
    	$vId =$(this).attr('data-src');    	
		//var theId =$(this).attr('data-src');  	
		$(".showmore_"+$vId).showMore({
			speedDown: 300,
			        speedUp: 300,
			        height: '96px',
			        showText: vMore,
			        hideText: vLess
			});
    });	
	//Read more/less end 	
    
    //Add to shopping cart from home
    $('.my-cart-btn').on('click',function(){
        var itemImg =  $(this).parent().parent().children('.thumb-book-image').find("img").eq(0);
        //alert(itemImg);
        flyToElement($(itemImg), $('#cart-anchor'));
        addToCart($(this).data("id"));
    });    
    
    //Add to shopping cart from search results
    $('.my-cart-btn-s').on('click',function(){
        var itemImg =  $(this).parent().parent().parent().children('.thumb-book-image').find("img").eq(0);
        flyToElement($(itemImg), $('#cart-anchor'));
        addToCart($(this).data("id"));
    });    
   
    
    //Move from wishlist to shopping cart
    $("[id^=move-to-cart-]").click(function(e){
    	var vId = $(this).attr('data-id');	
    	var wishId = $(this).attr('data-src');	
    	var vUrl =$(this).attr('data-url');
    	
		var vLanguage = $('#searchForm #language').val();
	    if(vLanguage == 'af'){
		   	var vDeleteAlert = "Jammer, die boek is nie oorgelaai na jou mandjie nie! Probeer asseblief weer.\n\nKontak Graffiti indien die fout herhaaldelik voorkom.";
	    }
	    else if(vLanguage == 'en'){
		   	var vDeleteAlert = "An error occurred. The book was not moved to your cart. Please try again.\n\nPlease contact Graffiti if the error is not resolved.";
	    }    	    	
        var itemImg =  $(this).parent().parent().children('.col-center').find("img").eq(0)
        //flyToElement($(itemImg), $('#cart-anchor'));
        if(addToCart(vId) !== false){
	        //Delete from wishlist
	        $.post("order_process.php", {type: "delete-wish-book", wish_id: wishId},function(data){
	          	if (data == 'error') {
	          		alert(vDeleteAlert);
	            }
	          	else {
	          		window.location.href=vUrl;
	          	}
	       });    
        }
        else {
        	alert(vDeleteAlert);
        }
    });
    
    //Sort order change start
    $("#resultSort").on("change", function (event){
    	  var sortValue = $(this).val();
    	  var currentUrl = $("#current-url").val();
    	  if(sortValue.length > 0){
    		  window.location.href = currentUrl+"/"+sortValue;
    	  }
	})
    //Sort order change start    
    	
    //Stop pagination to link to samepage
	$('#pageSelf').click(function(e){
		e.preventDefault();
	})
	
	
	$("#bookinfoIcon").click(function(e){
		var vTitle = $(this).attr('data-title');
		var vDimensions = $(this).attr('data-dimensions');
		var vWeight = $(this).attr('data-weight');
		var vNoPages = $(this).attr('data-pages');
		var vFormat = $(this).attr('data-format');
	
		$("#bookinfo #heading").html(vTitle);
		$("#bookinfo #dimensions").html(vDimensions);
		$("#bookinfo #weight").html(vWeight);
		$("#bookinfo #no-pages").html(vNoPages);
		$("#bookinfo #format").html(vFormat);
	});
	
	//Order history start
    //Book info display
    $("[id^=orderhistoryshowbooks_]").click(function(e){
    	$vId =$(this).attr('data-id');    	
    	$("#orderhistorybooksdetail_"+$vId).removeClass( "no-display" );	      
    	$("#orderhistoryshowbooks_"+$vId).addClass( "no-display" );	      
    	$("#orderhistoryshowbooks_"+$vId).removeClass( "fa" );	 
    	$("#orderhistoryhidebooks_"+$vId).removeClass( "no-display" );	   
    	$("#orderhistoryhidebooks_"+$vId).addClass( "fa" );	 
    });    
    $("[id^=orderhistoryhidebooks_]").click(function(e){
		$vId =$(this).attr('data-id');    	
		$("#orderhistorybooksdetail_"+$vId).addClass( "no-display" );	      
		$("#orderhistoryshowbooks_"+$vId).removeClass( "no-display" );	    
		$("#orderhistoryshowbooks_"+$vId).addClass( "fa" );	 
		$("#orderhistoryhidebooks_"+$vId).addClass( "no-display" );	      
		$("#orderhistoryhidebooks_"+$vId).removeClass( "fa" );	 
	});
    
    //Payment display
    $("[id^=orderhistorypayicon_]").click(function(e){
		$vId =$(this).attr('data-id');    	
		var vBooksPrice = $(this).attr('data-pay-books');
		var vPostalPrice = $(this).attr('data-pay-postal');
		var vTotalPrice = $(this).attr('data-pay-total');
		var vPaid = $(this).attr('data-pay-paid');
		var vPaidType = $(this).attr('data-pay-type');

		$("#orderhistorypay #paid").html(vPaid);
		$("#orderhistorypay #method").html(vPaidType);
		$("#orderhistorypay #price").html(vBooksPrice);
		$("#orderhistorypay #delivery").html(vPostalPrice);
		$("#orderhistorypay #total").html(vTotalPrice);
	});    
    
    //Dispatch display
    $("[id^=orderhistorydispatchicon_]").click(function(e){
		$vId =$(this).attr('data-id');    	
		var vDispatch = $(this).attr('data-dispatch');
		var vMethod = $(this).attr('data-dispatch-method');
		var vCost = $(this).attr('data-dispatch-cost');
		var vTracking = $(this).attr('data-dispatch-tracking');
		var vDetail = $(this).attr('data-dispatch-detail');
		var vMessage = $(this).attr('data-dispatch-message');

		$("#orderhistorydispatch #dispatch").html(vDispatch);
		$("#orderhistorydispatch #method").html(vMethod);
		$("#orderhistorydispatch #cost").html(vCost);
		$("#orderhistorydispatch #tracking").html(vTracking);
		$("#orderhistorydispatch #detail").html(vDetail);
		$("#orderhistorydispatch #message").html(vMessage);
	});        
	//Order history end
	
	//Home page top seller circle, out of print banner start
	$('[id^=topSel_]').each(function () {
		var vId =$(this).attr('data-id');    	
        var itemImg =  $(this).find("img").eq(0); 
		var vTop = $(itemImg).height();
        $("#topSelCircle_"+vId).css({'top': vTop + "px"});
    });   
	$('[id^=topSelC_]').each(function () {
		var vId =$(this).attr('data-id');    	
        var itemImg =  $(this).find("img").eq(0); 
		var vTop = $(itemImg).height();
        $("#topSelCCircle_"+vId).css({'top': vTop + "px"});
    });   	
	$('[id^=newSel_]').each(function () {
		var vId =$(this).attr('data-id');    	
        var itemImg =  $(this).find("img").eq(0);
		var vTop = $(itemImg).height();
        $("#newSelCircle_"+vId).css({'top': vTop + "px"});
    }); 
	$('[id^=newSelC_]').each(function () {
		var vId =$(this).attr('data-id');    	
        var itemImg =  $(this).find("img").eq(0);
		var vTop = $(itemImg).height();
        $("#newSelCCircle_"+vId).css({'top': vTop + "px"});
    }); 
	$('[id^=specialSel_]').each(function () {
		var vId =$(this).attr('data-id');    	
        var itemImg =  $(this).find("img").eq(0);
		var vTop = $(itemImg).height();
        $("#specialSelCircle_"+vId).css({'top': vTop + "px"});
    }); 
	$('[id^=soonSel_]').each(function () {
		var vId =$(this).attr('data-id');    	
        var itemImg =  $(this).find("img").eq(0);
		var vTop = $(itemImg).height();
        $("#soonSelCircle_"+vId).css({'top': vTop + "px"});
    }); 	
	$('[id^=bookSel_]').each(function () {
		var vId =$(this).attr('data-id');    	
        var itemImg =  $(this).find("img").eq(0);
		var vTop = $(itemImg).height()-20;
        $("#bookSelCircle_"+vId).css({'top': vTop + "px"});
    }); 		
	$('[id^=outSel_]').each(function () {
		var vId =$(this).attr('data-id');    	
        var itemImg =  $(this).find("img").eq(0);
		var vTop = $(itemImg).height()-20;
		var vWidth = $(itemImg).width()+4;
        $("#bookOutBanner_"+vId).css({'top': vTop + "px", 'width': vWidth + "px"});
    }); 
	$('[id^=imageEvent_]').each(function () {
		var vId =$(this).attr('data-id');    	
        var itemImg =  $(this).find("img").eq(0);
		//var vTop = $(itemImg).height()-40;
		var vWidth = $(itemImg).width()+4;
        $("photoBanner_"+vId).css({'width': vWidth + "px"});
    }); 
	//Home page top seller circle, out of print banner end		
    
	//Trigger Home Page row height function
	$.fn.setHomeRowHeight();
	
	jQuery.ui.autocomplete.prototype._resizeMenu = function () {
		  var ul = this.menu.element;
		  ul.outerWidth(this.element.outerWidth());
		}
});
//########################################################################################################## document.ready END
$(function(){
	$('#searchForm #keyword').autocomplete({
			source: 'include/AutoCompleteSearch.php?section='+$('#searchForm #section').val(),
			minLength: 5,
			delay: 500,
			select: function(event,ui){
				$('#searchForm #cat').val(ui.item.value);
				$('#searchForm #autocomplete').val(1);
				$('#searchForm').submit();
			 }
	});
});

$("#searchForm #searchButton").click(function(e){
	var vSearchWord = $('#searchForm #cat').val();
	var vKeyword = $('#searchForm #keyword').val();
	if(vSearchWord.length == 0){
		$('#searchForm #cat').val(vKeyword);
	}
});


$('#password_forgot').on('click', function() {  alert(8);
$("#login").fadeOut(slow);
$("#password_reset").fadeIn(slow);
});



$('#password_forgot').on('click', function() {
$("#login").fadeOut(slow);
$("#password_reset").fadeIn(slow);
});


//Random string generator
function randomString( n ) {
	  var r="";
	  while(n--)r+=String.fromCharCode((r=Math.random()*62|0,r+=r>9?(r<36?55:61):48));
	  return r;
	}

$.fn.equalHeight = function() {
    var maxHeight = 0;
    return this.each(function(index, box) {
        var boxHeight = $(box).height();
        maxHeight = Math.max(maxHeight, boxHeight);
    }).height(maxHeight);

};

//window.onload = show_body;

//#################################Shopping cart start

$(document).on('hidden.bs.modal', function (e) {

});

//Fly to cart
function flyToElement(flyer, flyingTo) {
    var $func = $(this);
    var divider = 3;
    var flyerClone = $(flyer).clone();
    $(flyerClone).css({position: 'absolute', top: $(flyer).offset().top + "px", left: $(flyer).offset().left + "px", opacity: 1, 'z-index': 1000, height: "100px"});
    $('body').append($(flyerClone));
    var gotoX = $(flyingTo).offset().left + ($(flyingTo).width() / 2) - ($(flyer).width()/divider)/2;
    var gotoY = $(flyingTo).offset().top + ($(flyingTo).height() / 2) - ($(flyer).height()/divider)/2;
     
    $(flyerClone).animate({
        opacity: 0.4,
        left: gotoX,
        top: gotoY,
        width: $(flyer).width()/divider,
        height: $(flyer).height()/divider
    }, 700,
    function () {
        $(flyingTo).fadeOut('fast', function () {
            $(flyingTo).fadeIn('fast', function () {
                $(flyerClone).fadeOut('fast', function () {
                    $(flyerClone).remove();
                });
            });
        });
    });
	 var oldNum = +$('#cart-num').text()+1;
	 $('#cart-num').text(oldNum);    
}

function addToCart(theBookId){
   	var insertError = 0;  	        	
   	$.post("order_process.php", {type: "update-cart", book_id: theBookId},function(data){
	   	if (data == 0) {
	   		//window.location = vLanguage+"/"+vUrlError;
	   		$('#carteerror').modal('show');
		}
   	});
}

//#################################Shopping cat end

$(function(){
	  var $searchlink = $('#searchtoggl i');
	  var $searchbar  = $('#searchbar');
	  
	  $('#welcomeLine ul li a').on('click', function(e){
	    if($(this).attr('id') == 'searchtoggl') {
	    	e.preventDefault();
	      if(!$searchbar.is(":visible")) { 
	        $searchlink.removeClass('fa-search').addClass('fa-search-minus');
	      } else {
	        $searchlink.removeClass('fa-search-minus').addClass('fa-search');
	      }
	      $searchbar.slideToggle(300, function(){
	      });
	    }	   
	    if($(this).attr('id') == 'shoppingshow') {
	    	e.preventDefault();
	    }	 
	  });
	  $('#searchForm').submit(function(e){
	    //e.preventDefault(); // stop form submission
	  });
	});

$('#printForm').on('click', function() {  
	var divId =$(this).attr('data-src');
	var divToPrint=document.getElementById(divId);
	var newWin=window.open('','Print-Window');
	newWin.document.open();
	newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
	newWin.document.close();
	setTimeout(function(){newWin.close();},10);
});

//Home page row height set
$.fn.setHomeRowHeight = function() {
	$('[id^=home-book-row-]').each(function () {
	    var imageH = 0;
	    var headingH = 0;        
	    var authorH = 0;  
	    var discountH = 0;  
	    var priceH = 0;  
	    var shopH = 0;  
	    //thumb-book-image
	    $('.thumb-book-image', this).each(function () {
	        if (imageH < $(this).height()) {
	        	imageH = $(this).height();
	        }
	    });
	    $('.thumb-book-image', this).each(function () {
	        $(this).css("height", imageH + 'px');           
	    });        
	    //thumb-book-heading
	    $('.thumb-book-heading', this).each(function () {
	        if (headingH < $(this).height()) {
	        	headingH = $(this).height();
	        }
	    });
	    $('.thumb-book-heading', this).each(function () {
	        $(this).css("height", headingH + 'px');        
	    });                
	    //thumb-book-author
	    $('.thumb-book-author', this).each(function () {
	        if (authorH < $(this).height()) {
	        	authorH = $(this).height();
	        }
	    });
	    $('.thumb-book-author', this).each(function () {
	        $(this).css("height", authorH + 'px');         
	    });         
	    //thumb-book-discount
	    $('.thumb-book-discount', this).each(function () {
	        if (discountH < $(this).height()) {
	        	discountH = $(this).height();
	        }
	    });
	    $('.thumb-book-discount', this).each(function () {
	        $(this).css("height", discountH + 'px');      
	    });           
	    //thumb-book-price
	    $('.thumb-book-price', this).each(function () {
	        if (priceH < $(this).height()) {
	        	priceH = $(this).height();
	        }
	    });
	    $('.thumb-book-price', this).each(function () {
	        $(this).css("height", priceH + 'px');         
	    });                   
	    //thumb-book-shop
	    $('.thumb-book-shop', this).each(function () {
	        if (shopH < $(this).height()) {
	        	shopH = $(this).height();
	        }
	    });
	    $('.thumb-book-shop', this).each(function () {
	        $(this).css("height", shopH + 'px');          
	    });
	});	
}

