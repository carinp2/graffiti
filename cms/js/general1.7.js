$(document).ready(function (){
	
	//New sort orderstart
	$( "#booksLandingNewTable tbody" ).sortable({
	    cancel: ":input,button,[contenteditable]",
	    axis: "y",
	    update: function (event, ui) {
	        var data = $(this).sortable('serialize');
	        $.ajax({
	            data: data,
	            type: 'POST',
	            url: 'book_process.php?type=update-new-rank',
	            success: function(response) {
	            	$("#query-message").html("<h4 class='success-message'><i class='fa fa-check fa-lg space-right green' aria-hidden='true'></i>Sukses! Posisies is verander. Herlaai die blad om die veranderinge te sien.</h4>");
	            },
	            error: function(response) {
		        	$("#query-message").html("<h4 class='error-message'><i class='fa fa-times fa-lg space-right red' aria-hidden='true'></i>Fout! Posisies is nie verander nie.</h4>");
		        }
	        });
	    }
	});
	//New sort order end
	
	//Soon sort orderstart
	$( "#booksLandingSoonTable tbody" ).sortable({
	    cancel: ":input,button,[contenteditable]",
	    axis: "y",
	    update: function (event, ui) {
	        var data = $(this).sortable('serialize');
	        $.ajax({
	            data: data,
	            type: 'POST',
	            url: 'book_process.php?type=update-soon-rank',
	            success: function(response) {
	            	$("#query-message").html("<h4 class='success-message'><i class='fa fa-check fa-lg space-right green' aria-hidden='true'></i>Sukses! Posisies is verander. Herlaai die blad om die veranderinge te sien.</h4>");
	            },
	            error: function(response) {
		        	$("#query-message").html("<h4 class='error-message'><i class='fa fa-times fa-lg space-right red' aria-hidden='true'></i>Fout! Posisies is nie verander nie.</h4>");
		        }
	        });
	    }
	});
	//Soon sort order end	
	
	//Top seller sort orderstart
	$( "#booksLandingTopTable tbody" ).sortable({
	    cancel: ":input,button,[contenteditable]",
	    axis: "y",
	    update: function (event, ui) {
	        var data = $(this).sortable('serialize');
	        $.ajax({
	            data: data,
	            type: 'POST',
	            url: 'book_process.php?type=update-topseller-rank',
	            success: function(response) {
	            	$("#query-message").html("<h4 class='success-message'><i class='fa fa-check fa-lg space-right green' aria-hidden='true'></i>Sukses! Posisies is verander. Herlaai die blad om die veranderinge te sien.</h4>");
	            },
	            error: function(response) {
		        	$("#query-message").html("<h4 class='error-message'><i class='fa fa-times fa-lg space-right red' aria-hidden='true'></i>Fout! Posisies is nie verander nie.</h4>");
		        }
	        });
	    }
	});
	//Top seller sort order end		
	
	// ####################### DataTables start   
  //Export to Excel end
	
	//Book list
    var booksTable = $('#tableBooks').dataTable( {
		 "order": [[8, "desc" ]],
        "iDisplayLength": 50,
        "aLengthMenu": [[50, 100, 150, 200, 250, -1], [50, 100, 150, 200, 250, "All"]],
        "columns": [{"orderable": false,"searchable": false},null,null,null,{"searchable": false},{"searchable": false},{"searchable": false}, {"searchable": false},{"searchable": false},{"searchable": false},
        	{"searchable": false},{"searchable": false},{"searchable": false},null,{"searchable": false}],
	    fixedHeader: {
	        footer: true
	    }
    });
    
	//Rotating image list
	var rotateTable = $('#rotateTable').DataTable( {
        rowReorder: true,
        "iDisplayLength": 15,
        "aLengthMenu": [[15, 30, 45, -1], [15, 30, 45, "All"]],
        "columns": [null,{"orderable": false, "searchable": false},{"searchable": false},{"searchable": false},{"searchable": false},{"orderable": false, "searchable": false}],
        "sDom": '<"top"i>rt<"bottom"><"clear">',   	
	});	
	
	//Orders list
	var orderTable = $("#orderTable").DataTable( {
        "order": [[0, "desc"],[ 4, "desc" ]],
        //"iDisplayLength": $("#orderTable").attr('data-length'),
        "aLengthMenu": [[15, 30, 45, -1], [15, 30, 45, "All"]],
        "columns": [null,null,null,null,null,null,null,null,null,null,null,{"searchable": false},{"searchable": false},{"searchable": false},null, null,{"orderable": false, "searchable": false},{"orderable": false, "searchable": false}],
	    fixedHeader: {
	        footer: true
	    } 	
	});	

	//Clients list
	var clientsTable = $("#clientsTable").DataTable( {
        "iDisplayLength": 15,
        "aLengthMenu": [[15, 30, 45, -1], [15, 30, 45, "All"]],
        "columns": [null,null,null,null,null,null,null,null,null,null,{"orderable": false, "searchable": false}],
	    fixedHeader: {
	        footer: true
	    }
	});	
	
	//Wishlist list
	var wishlistTable = $("#wishlistTable").DataTable( {
        "iDisplayLength": 15,
        "aLengthMenu": [[15, 30, 45, -1], [15, 30, 45, "All"]]
	});		
	
	//Koerierkoste list
	var courierTable = $("#courierTable").DataTable( {
        "iDisplayLength": 30,
        "aLengthMenu": [[30, 60, 90, -1], [30, 60, 90, "All"]],
        "columns": [null,null,null,null,null,null,null,null,null,{"orderable": false, "searchable": false}],
	    fixedHeader: {
	        footer: true
	    }
	});		

	//Publishers list
	var publishersTable = $("#publishersTable").DataTable( {
		 "order": [[2, "asc" ]],
        "iDisplayLength": 30,
        "aLengthMenu": [[30, 60, 90, -1], [30, 60, 90, "All"]],
        "columns": [null,null,null,{"orderable": false, "searchable": false}],
	    fixedHeader: {
	        footer: true
	    }
	});		

	//Newsletters list
	var newslettersTable = $("#newslettersTable").DataTable( {
        "iDisplayLength": 10,
        "aLengthMenu": [[10, 20, -1], [10, 20, "All"]],
        "columns": [null,null,null,{"orderable": false, "searchable": false}],
	    fixedHeader: {
	        footer: true
	    }
	});	
	
	//Clients list
	var eventsTable = $("#eventsTable").DataTable( {
        "iDisplayLength": 15,
        "aLengthMenu": [[15, 30, 45, -1], [15, 30, 45, "All"]],
        "columns": [null,null,null,null,null,null,null,{"orderable": false, "searchable": false},{"orderable": false, "searchable": false},{"orderable": false, "searchable": false}],
	    fixedHeader: {
	        footer: true
	    }
	});	
	//Users list
	var usersTable = $("#usersTable").DataTable( {
        "iDisplayLength": 10,
        "aLengthMenu": [[10, 20, -1], [10, 20, "All"]],
        "columns": [null,null,null,{"orderable": false, "searchable": false},{"orderable": false, "searchable": false},{"orderable": false, "searchable": false},{"orderable": false, "searchable": false}],
	    fixedHeader: {
	        footer: true
	    }
	});		
		
	//Stock update table
	var stockTable = $("#stockTable").DataTable( {
        "iDisplayLength": 100,
        "aLengthMenu": [[100, 200, 300, -1], [100, 200, 300, "All"]],
        "columns": [null,null,null,null]
	});	
	
	//Out of print table
	var outOfPrintTable = $("#outOfPrintTable").DataTable( {
        "iDisplayLength": 50,
        "aLengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
        "columns": [null,null,null],
	    fixedHeader: {
	        footer: true
	    }
	});	
	
	//Rotating image reorder
	rotateTable.on( 'row-reorder', function ( e, diff, edit ){
	    for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
	    	var rowData = rotateTable.row( diff[i].node ).data();
	    	$.post("rotate_process.php", {type: "update-rotate-rank", rotate_id: rowData[1], rank: diff[i].newData},function(result){
		    	if(result == 'success'){
		    		$("#query-message").html("<h4 class='success-message'><i class='fa fa-check fa-lg space-right green' aria-hidden='true'></i>Sukses! Posisies is verander.</h4>");
		    	}
		    	else if(result == 'error'){
		    		$("#query-message").html("<h4 class='error-message'><i class='fa fa-times fa-lg space-right red' aria-hidden='true'></i>Fout! Posisies is nie verander nie.</h4>");
		    	}
		    	return false;
	    	});            
		}
	});		
	
	//Language table
	var languageTable = $('#languageTable').DataTable( {
        "iDisplayLength": 50,
        "aLengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
        "columns": [{"searchable": false},null, null,{ "orderable": false , "searchable": false}],
        "order": [ 1, 'asc' ],
	    fixedHeader: {
	        footer: true
	    }
	});
// ####################### DataTables end 	
    
    //TOOLTIP;
    $('[data-toggle="tooltip"]').tooltip(); 
	
	//EMAIL	
	$('.email').each(function (){
		var text = $(this).text();
		var address = text.replace(" at ", "@");
		$(this).attr('href', 'mailto:' + address);
		$(this).text(address);
	});
	
	//BACK BUTTON
	$('#backButton').click(function(){//TODO add url
		parent.history.back();
		return false;
	});

}); // #######################################################  Ready function end

//Book list table functions start    
$(".saveButton").click( function() {
	$("[id^=tr_]").children('td').removeClass("bg-success");
	$("[id^=tr_]").children('td').removeClass("bg-error");
	var vBookId = $(this).attr('data-id');
	var vPrice = $("#price_"+vBookId).val();
	var vSpecial = $("#special_"+vBookId).val();
	var vSpecial_price  = $("#special_price_"+vBookId).val();
	var vNew  = $("#new_"+vBookId).val();
	var vTop_seller  = $("#top_seller_"+vBookId).val();
	//var vTop_seller_rank  = $("#top_seller_rank_"+vBookId).val();
	var vOut_print  = $("#out_print_"+vBookId).val();
	var vInstock  = $("#instock_"+vBookId).val();
	var vPublisher = $("#publisher_"+vBookId).val();
	var vDefault_discount = $("#default_discount_"+vBookId).val();
	var vPublishDate = $("#pub_"+vBookId).val();
	var vSoonDiscount = $("#soon_discount_"+vBookId).val();
	var vSoon = $("#soon_"+vBookId).val();

	$.post("book_process.php", {type: "edit", book_id: vBookId, price: vPrice, special: vSpecial, special_price: vSpecial_price, bnew: vNew, top_seller: vTop_seller, out_print: vOut_print, in_stock: vInstock, publisher: vPublisher, default_discount:vDefault_discount, date_publish: vPublishDate, soon_discount: vSoonDiscount, soon: vSoon},function(result){
		if(result == 'success'){
			$("#tr_"+vBookId).children('td').addClass("bg-success");
			$("#tr_"+vBookId).children('td:last-child').removeClass("bg-success");
       	 }
         else if(result == 'error'){
        	//alert("Die boek info is nie verander nie. Probeer asb weer!");
        	$("#tr_"+vBookId).children('td').addClass("bg-error");
			$("#tr_"+vBookId).children('td:last-child').removeClass("bg-error");
         }
      	 return false;
	});
});    

$("[id^=editBookButton_]").click( function() {
	var vBookId = $(this).attr('data-id');
	window.location.href = "index.php?page=books&type=edit&id="+vBookId;
});    

$("[id^=deleteBookButton_]").click( function() {
	var vBookId = $(this).attr('data-id');
	theUrl = "book_process.php?page=books&type=delete-sql&id="+vBookId;
	if (confirm("Die boek sal uitgevee word.\n\nKlik 'OK' om voort te gaan!")) {
		document.location.href = theUrl;
	}
	else {
		return false;
	}
});    

$("#deleteBookImage").click( function() {
	var vBookId = $(this).attr('data-id');
	var vPath = $(this).attr('data-path');
	theUrl = "book_process.php?page=books&type=delete-image-sql&id="+vBookId+"&path="+vPath;
	if (confirm("Die boek prent sal uitgevee word.\n\nKlik 'OK' om voort te gaan!")) {
		document.location.href = theUrl;
	}
	else {
		return false;
	}
});    
//Book list table functions end    

//Language table functions start
$(".saveLanguageButton").click( function() {
	$("[id^=tr_]").children('td').removeClass("bg-success");
	$("[id^=tr_]").children('td').removeClass("bg-error");
	var vLanguageId = $(this).attr('data-id');
	var vAf = $("#af_"+vLanguageId).val();
	var vEng = $("#en_"+vLanguageId).val();
	//alert(vLanguageId);
	$.post("language_process.php", {type: "language", language_id: vLanguageId, af: vAf, en: vEng},function(result){
		if(result == 'success'){
			$("#tr_"+vLanguageId).children('td').addClass("bg-success");
			$("#tr_"+vLanguageId).children('td:last-child').removeClass("bg-success");
       	 }
         else if(result == 'error'){
        	$("#tr_"+vLanguageId).children('td').addClass("bg-error");
			$("#tr_"+vLanguageId).children('td:last-child').removeClass("bg-error");
         }
      	 return false;
	});
});    
//Langugae table functions end

//Rotating images table functions start
$("#rotateForm .saveRotateButton").click( function() {
	$("[id^=tr_]").children('td').removeClass("bg-success");
	$("[id^=tr_]").children('td').removeClass("bg-error");
	var vRotateId = $(this).attr('data-id');
	var vUrl = $("#url_"+vRotateId).val();
	var vAlt = $("#alt_"+vRotateId).val();
	$.post("rotate_process.php", {type: "save-rotate", rotate_id: vRotateId, url: vUrl, alt: vAlt},function(result){
    	if(result == 'success'){
			$("#tr_"+vRotateId).children('td').addClass("bg-success");
			$("#tr_"+vRotateId).children('td:last-child').removeClass("bg-success");
    	}
    	else if(result == 'error'){
        	$("#tr_"+vRotateId).children('td').addClass("bg-error");
			$("#tr_"+vRotateId).children('td:last-child').removeClass("bg-error");
    	}		
      	 return false;
	});
});    

$("#rotateForm #addRotateButton").click( function() {
    var error = false;
	var vUrl = $("#rotateForm #new_url").val();
	var vAlt = $("#rotateForm #new_alt").val();
	var vBlobPath = $("#rotateForm #new_blob_path").val();

    if(vUrl.length == 0){
        var error = true;
        $('#rotateForm #new_url').addClass("validation");
    } else {   
        $('#rotateForm #new_url').removeClass("validation");
    }
    if(vAlt.length == 0){
        var error = true;
        $('#rotateForm #new_alt').addClass("validation");
    } else {   
        $('#rotateForm #new_alt').removeClass("validation");
    }
    if(vBlobPath.length == 0){
        var error = true;
        $('#rotateForm #new_blob_path').addClass("validation");
    } else {   
        $('#rotateForm #new_blob_path').removeClass("validation");
    }
    
    if(error == false){
    	$('#rotateForm #submitError').fadeOut(500);  
    	$( "#rotateForm" ).submit();
    }  
    else{
    	event.preventDefault();
        $('#rotateForm #submitError').fadeIn(500);                     
    }      		
});    

$(".deleteRotateButton").click( function() {
	var vRotateId = $(this).attr('data-id');
	var vBlobPath = $(this).attr('data-path');
	if(confirm("Die roterende prent en info sal uitgevee word.\n\nKlik 'OK' om voort te gaan.")){
		$.post("rotate_process.php", {type: "delete-rotate", rotate_id: vRotateId, blob_path: vBlobPath},function(result){
	    	if(result == 'success'){
	    		location.reload();
	    		$("#query-message").html("<h4 class='success-message'><i class='fa fa-check fa-lg space-right green' aria-hidden='true'></i>Sukses! Die roterende prent is uitgevee.</h4>");
	    	}
	    	else if(result == 'error'){
	    		$("#query-message").html("<h4 class='error-message'><i class='fa fa-times fa-lg space-right red' aria-hidden='true'></i>Fout! Die roterende prent is nie uitgevee nie.</h4>");
	    	}		
	      	 return false;
		});
}
}); 

//Limit blob upload formats
$('#rotateForm #new_blob_path').change(function () {
    var ext = this.value.match(/\.(.+)$/)[1].toLowerCase();
    switch (ext) {
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
        	$('#rotateForm #fileTypeError').fadeOut(500); 
        	$('#rotateForm #new_blob_path').removeClass("validation");        	
            if (window.File && window.FileReader && window.FileList && window.Blob){
                var fsize = $('#new_blob_path')[0].files[0].size;
                if(fsize <= 1048576){
                	$('#addRotateButton').fadeIn(500); 
                	$('#rotateForm #fileSizeError').fadeOut(500); 
                	$('#rotateForm #blob_path').removeClass("validation");
                	$('#rotateForm #fileTypeError').fadeOut(500);  
                }
                else {
                	$('#addRotateButton').fadeOut(500); 
                	$('#rotateForm #fileError').fadeOut(500); 
                	$('#rotateForm #fileTypeError').fadeOut(500);  
                	$('#rotateForm #new_blob_path').addClass("validation");
                	$('#rotateForm #fileSizeError').fadeIn(500);  
                }
            }
        	else{
                alert("Please upgrade your browser, because your current browser lacks some new features we need!");
            }	    
            
            var file = $('#rotateForm #new_blob_path')[0].files[0];
            if(file) {
            	var img = new Image();
            	img.src = window.URL.createObjectURL( file );
            	img.onload = function() {
                var width = img.naturalWidth,
                height = img.naturalHeight;
                window.URL.revokeObjectURL( img.src );          
                    if(width == 1170){
                    	$('#rotateForm #filePhysicalWidthError').fadeOut(500);  
                    	$('#addRotateButton').fadeIn(500); 
                    }
                    else {
                    	$('#rotateForm #filePhysicalWidthError').fadeIn(500);  
                    	$('#addRotateButton').fadeOut(500); 
                    }
                    if(height == 410){
                    	$('#rotateForm #filePhysicalHeightError').fadeOut(500);  
                    	$('#addRotateButton').fadeIn(500); 
                    }
                    else {
                    	$('#rotateForm #filePhysicalHeightError').fadeIn(500);  
                    	$('#addRotateButton').fadeOut(500); 
                    }            
            	};
            }
            break;
        default:
        	$('#rotateForm #new_blob_path').addClass("validation");
        	$('#rotateForm #fileTypeError').fadeIn(500);  
        	$('#addRotateButton').fadeOut(500); 
    }
});
//Rotating images table functions end

//Orders table functions start
//Order emails start
$("[id^=paid_]").on('change', function() {
	$("#pre_load").fadeIn("slow");
	if($(this).val() == 1){
	var vOrderId = $(this).attr('data-id');
	var vClientId = $(this).attr('data-client');
	var vOrderAmount = $(this).attr('data-amount');
	var vOrderSalt = $(this).attr('data-ref');
	var vInStock = $(this).attr('data-instock');
	var vCourierType = $(this).attr('data-couriertype');
	   $.post("cms_order_process.php", {type: "paid", order_id: vOrderId, client_id: vClientId, amount: vOrderAmount, salt: vOrderSalt, instock: vInStock, courier: vCourierType},function(result){
		   	if (result == "success") {
		   		location.reload();
		     }
		   	else{
		   		alert("Die epos is nie gestuur nie!");
		   	}
		  });       	
	}
});

$("[id^=processed_]").on('change', function() {
	if($(this).val() == 1){
		$("#pre_load").fadeIn("slow");
		var vOrderId = $(this).attr('data-id');
		var vClientId = $(this).attr('data-client');
		var vOrderAmount = $(this).attr('data-amount');
		var vOrderSalt = $(this).attr('data-ref');
		var vCourierType = $(this).attr('data-couriertype');
	   $.post("cms_order_process.php", {type: "processed", order_id: vOrderId, client_id: vClientId, amount: vOrderAmount, salt: vOrderSalt, courier: vCourierType},function(result){
		   	if (result == "success") {
		   		location.reload();
		     }
		   	else{
		   		alert("Die epos is nie gestuur nie!");
		   	}
		  });       	
	}
});

$("[id^=tracking_email_]").on('click', function() {
	var vOrderId = $(this).attr('data-id');
	var vPosted = $("#posted_"+vOrderId).val();
	if(vPosted == 1){
		var vClientId = $(this).attr('data-client');
		var vCourierType = $(this).attr('data-courier');
		var vOrderSalt = $(this).attr('data-ref');
		var vTracking = $("#tracking_no_"+vOrderId).val();
		if(vTracking.length == 0){
			$("#tracking_no_"+vOrderId).addClass("validation");
			$("#trackingError_"+vOrderId).fadeIn(500);  
		}
		else {
			$("#tracking_no_"+vOrderId).removeClass("validation");
			$("#trackingError_"+vOrderId).fadeOut(500);  			
			$("#pre_load").fadeIn("slow");
				   $.post("cms_order_process.php", {type: "posted", order_id: vOrderId, client_id: vClientId, courier_type: vCourierType, salt: vOrderSalt, tracking: vTracking},function(result){
					   	if (result == "success") {
					   		location.reload();
					     }
					   	else{
					   		alert("Die epos is nie gestuur nie!");
					   	}
					  });       	
		}
	}
	else {
		$("#pre_load").fadeOut("slow");
	}
});

$("[id^=completed_]").on('change', function() {
	if($(this).val() == 1){
	var vOrderId = $(this).attr('data-id');
	   $.post("cms_order_process.php", {type: "completed", order_id: vOrderId},function(result){
		   	if (result == "success") {
		   		location.reload();
		     }
		   	else{
		   		alert("Die data is nie verander nie!!");
		   	}
		  });       	
	}
}); 

$("[id^=settled_]").on('change', function() {
	if($(this).val() == 1){
	var vOrderId = $(this).attr('data-id');
	   $.post("cms_order_process.php", {type: "settled", order_id: vOrderId},function(result){
		   	if (result == "success") {
		   		location.reload();
		     }
		   	else{
		   		alert("Die data is nie verander nie!!");
		   	}
		  });       	
	}
});

$("[id^=printInvoiceButton_]").on('click', function() {
	var vOrderId = $(this).attr('data-id');
	var vClientId = $(this).attr('data-clientid');
	$vUrl = "cms_order_process.php?type=invoice_print&order_id="+vOrderId+"&client_id="+vClientId;
	window.open($vUrl,"printWindow");
	   //$.post("cms_order_process.php", {type: "invoice_print", order_id: vOrderId, client_id: vClientId},function(result){
		//  });       	
});

//Order emails end

$("[id^=saveOrder_]").on('click', function() {
	$("[id^=tr_]").children('td').removeClass("bg-success");
	$("[id^=tr_]").children('td').removeClass("bg-error");	
	var vOrderId = $(this).attr('data-id');
	var vCourierType = $("#courier-type_"+vOrderId).val();
	var vCourierCost = $("#courier_cost_"+vOrderId).val();
	var vTotalCost = $("#total_cost_"+vOrderId).val();
	var vTrackingNo = $("#tracking_no_"+vOrderId).val();
	var vPaymentType = $("#payment-type_"+vOrderId).val();
	var vNote = $("#note_"+vOrderId).val();
	   $.post("cms_order_process.php", {type: "order", order_id: vOrderId, note: vNote, courier_type: vCourierType, courier_cost: vCourierCost, total_cost: vTotalCost, tracking_no: vTrackingNo, payment_type: vPaymentType},function(result){
	    	if(result == 'success'){
				$("#tr_"+vOrderId).children('td').addClass("bg-success");
				$("#tr_"+vOrderId).children('td:last-child').removeClass("bg-success");
	    	}
	    	else if(result == 'error'){
	        	$("#tr_"+vOrderId).children('td').addClass("bg-error");
				$("#tr_"+vOrderId).children('td:last-child').removeClass("bg-error");
	    	}		
	      	 return false;
		  });       	
});

$("[id^=deleteOrderButton_]").on('click', function() {
	var vOrderId = $(this).attr('data-id');
	if(confirm("Die bestelling sal uitgevee word.\n\nKlik 'OK' om voort te gaan.")){
	   $.post("cms_order_process.php", {type: "delete", order_id: vOrderId},function(result){
	    	if(result == 'success'){
		   		location.reload();
	    	}
	    	else if(result == 'error'){
		   		alert("Die bestelling is nie uitgevee nie!!");
	    	}		
	      	 return false;
		  });       	
	}
});

$("[id^=orderbooks_]").click(function(e){
	$vId =$(this).attr('data-id');    	
	var vBooks = $(this).attr('data-books');

	$("#orderbooks #books").html(vBooks);
});    
//Orders table functions end

//Courier table functions start
$("[id^=saveCourierButton_]").on('click', function() {
	$("[id^=tr_]").children('td').removeClass("bg-success");
	$("[id^=tr_]").children('td').removeClass("bg-error");	
	var vCourierId = $(this).attr('data-id');
	var vAf = $("#af_"+vCourierId).val();
	var vEn = $("#en_"+vCourierId).val();
	var vRate1 = $("#rate_1_"+vCourierId).val();
	var vRate2 = $("#rate_2_"+vCourierId).val();
	var vRate3 = $("#rate_3_"+vCourierId).val();
	var vRate4 = $("#rate_4_"+vCourierId).val();
	var vRate5 = $("#rate_5_"+vCourierId).val();
	var vRate6 = $("#rate_6_"+vCourierId).val();
	var vRate7 = $("#rate_7_"+vCourierId).val();
	   $.post("courier_process.php", {type: "edit", courier_id: vCourierId, af: vAf, en: vEn, rate1: vRate1, rate2: vRate2, rate3: vRate3, rate4: vRate4, rate5: vRate5, rate6: vRate6, rate7: vRate7},function(result){
	    	if(result == 'success'){
				$("#tr_"+vCourierId).children('td').addClass("bg-success");
				$("#tr_"+vCourierId).children('td:last-child').removeClass("bg-success");
	    	}
	    	else if(result == 'error'){
	        	$("#tr_"+vCourierId).children('td').addClass("bg-error");
				$("#tr_"+vCourierId).children('td:last-child').removeClass("bg-error");
	    	}		
	      	 return false;
		  });       	
});

//Publishers table functions start
$("[id^=savePublisherButton_]").on('click', function() {
	$("[id^=tr_]").children('td').removeClass("bg-success");
	$("[id^=tr_]").children('td').removeClass("bg-error");	
	var vPublisherId = $(this).attr('data-id');
	var vPublisher = $("#publisher_"+vPublisherId).val();
	var vSupplier = $("#supplier_"+vPublisherId).val();
	
   $.post("publisher_process.php", {type: "edit", publisher_id: vPublisherId, publisher: vPublisher, supplier: vSupplier},function(result){
    	if(result == 'success'){
			$("#tr_"+vPublisherId).children('td').addClass("bg-success");
			$("#tr_"+vPublisherId).children('td:last-child').removeClass("bg-success");
    	}
    	else if(result == 'error'){
        	$("#tr_"+vPublisherId).children('td').addClass("bg-error");
			$("#tr_"+vPublisherId).children('td:last-child').removeClass("bg-error");
    	}		
      	 return false;
	  });       	
});

$("[id^=deletePublisherButton_]").click( function() {
	var vPublisherId = $(this).attr('data-id');
	theUrl = "publisher_process.php?type=delete&id="+vPublisherId;
	if (confirm("Die uitgewer sal uitgevee word.\n\nKlik 'OK' om voort te gaan!")) {
		document.location.href = theUrl;
	}
	else {
		return false;
	}
});    
//Publisher table functions end

//Clients table functions start
$("[id^=saveClient_]").on('click', function() {
	$("[id^=tr_]").children('td').removeClass("bg-success");
	$("[id^=tr_]").children('td').removeClass("bg-error");	
	var vClientId = $(this).attr('data-id');
	var vSpecial_discount = $("#special_discount_"+vClientId).val();
	
   $.post("clients_process.php", {type: "edit", client_id: vClientId, special_discount: vSpecial_discount},function(result){
    	if(result == 'success'){
			$("#tr_"+vClientId).children('td').addClass("bg-success");
			$("#tr_"+vClientId).children('td:last-child').removeClass("bg-success");
    	}
    	else if(result == 'error'){
        	$("#tr_"+vClientId).children('td').addClass("bg-error");
			$("#tr_"+vClientId).children('td:last-child').removeClass("bg-error");
    	}		
      	 return false;
	  });
});

//Clients table functions end

//Newsletter functions start
$("#newslettersForm #addNewslettersButton").click( function() {
    var error = false;
	var vBlobPath = $("#newslettersForm #newsletter_blob_path").val();

    if(vBlobPath.length == 0){
        var error = true;
        $('#newslettersForm #newsletter_blob_path').addClass("validation");
    } else {   
        $('#newslettersForm #newsletter_blob_path').removeClass("validation");
    }
    
    if(error == false){
    	$('#newslettersForm #submitError').fadeOut(500);  
    	$( "#newslettersForm" ).submit();
    }  
    else{
    	event.preventDefault();
        $('#newslettersForm #submitError').fadeIn(500);                     
    }      		
});    

//Limit blob upload formats
$('#newslettersForm #newsletter_blob_path').change(function () {
    var ext = this.value.match(/\.(.+)$/)[1].toLowerCase();
        if(ext == "pdf"){
        	$('#newslettersForm #fileTypeError').fadeOut(500); 
        	$('#newslettersForm #newsletter_blob_path').removeClass("validation");        	
            if (window.File && window.FileReader && window.FileList && window.Blob){
                var fsize = $('#newslettersForm #newsletter_blob_path')[0].files[0].size;
                if(fsize <= 1048576){
                	$('#newslettersForm #fileSizeError').fadeOut(500); 
                	$('#newslettersForm #newsletter_blob_path').removeClass("validation");
                	$('#newslettersForm #fileTypeError').fadeOut(500);  
                }
                else {
                	$('#newslettersForm #fileTypeError').fadeOut(500);  
                	$('#newslettersForm #newsletter_blob_path').addClass("validation");
                	$('#newslettersForm #fileSizeError').fadeIn(500);  
                }
            }
        	else{
                alert("Please upgrade your browser, because your current browser lacks some new features we need!");
            }	  
        }
        else {
	    	$('#newslettersForm #newsletter_blob_path').addClass("validation");
	    	$('#newslettersForm #fileTypeError').fadeIn(500);  
        }
});
//Newsletter functions end

//Check ISBN in database start
$("#bookForm #isbn").on('change', function() {
    var vIsbn = $('#bookForm #isbn').val(); 
    var vCurrentIsbn = $('#bookForm #current_isbn').val();
	if(vIsbn != vCurrentIsbn){	    
	   $.post("book_process.php", {type: "check-isbn", isbn: vIsbn},function(result){
	   	if (result == "exist") {
	   		$('#isbn_exist').fadeIn(500);   
	   		$("#bookForm #isbn").addClass("validation");
	   		$('#submitBook').fadeOut(500);   
	     }
	   	else{
	   		$('#isbn_exist').fadeOut(500);   
	   		$("#bookForm #isbn").removeClass("validation");
	   		$('#submitBook').fadeIn(500);   
	   	}
	  });       
	}
});

$("#bookForm #special_price").on('change', function() {
	var vSpecialPrice = $(this).val();
	if (vSpecialPrice > 0) {
		$("#bookForm #special").prop('checked', true);
    }
	else if(vSpecialPrice == 0 || vSpecialPrice == ""){
		$("#bookForm #special").prop('checked', false);
	}
});

//Get SubCategories from Category
$("#bookForm #category").on('change', function() {
	var vCategory = $(this).val();
	$.fn.getSubCategories(vCategory);
});

$.fn.getSubCategories = function(pCategory) {
	$.ajax({
		 type: 'post',
		 url: 'general_process.php',
		 data: {type: "get_sub_cat", category: pCategory},
		 success: function (response) {
			 $('#bookForm #sub_category').html(response);
		 }
	});
}

$("#bookForm #top_seller_rank").on('change', function() {
	var vRank = $(this).val();
	if (vRank > 0) {
		$("#bookForm #top_seller").prop('checked', true);
    }
	else if(vRank == 0 || vRank == ""){
		$("#bookForm #top_seller").prop('checked', false);
	}
});

//Check for integer without . and ,
$("#bookForm #price").on('change', function() {
	checkInt("#bookForm", "#price", "#priceError");
});

$("#bookForm #special_price").on('change', function() {
	checkInt("#bookForm", "#special_price", "#specialPriceError");
});

//Limit blob upload formats
$("#bookForm #blob_path").change(function () {
    var ext = this.value.match(/\.(.+)$/)[1].toLowerCase();
    switch (ext) {
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
        	$('#bookForm #submitBook').fadeIn(500);           	
        	$('#fileError').fadeOut(500); 
        	$('#blob_path').removeClass("validation");
        	
            if (window.File && window.FileReader && window.FileList && window.Blob){
                var fsize = $('#blob_path')[0].files[0].size;
                if(fsize <= 1048576){
                	$('#fileSizeError').fadeOut(500); 
                	$('#blob_path').removeClass("validation");
                	$('#bookForm #submitBook').fadeIn(500);   
                }else{
                	$('#fileError').fadeOut(500); 
                	$('#blob_path').addClass("validation");
                	$('#fileSizeError').fadeIn(500);  
                	$('#bookForm #submitBook').fadeOut(500);   
                }
            }
        	else{
                alert("Please upgrade your browser, because your current browser lacks some new features we need!");
            }	            	
        	
            break;
        default:
        	$('#bookForm #submitBook').fadeOut(500);    	
        	$('#blob_path').addClass("validation");
        	$('#fileError').fadeIn(500);  
    }
});
	
	//Submit book start
	$("#submitBook").click( function() {
        var error = false;
        
        var language = $('#language').val();
        var isbn = $('#isbn').val();
        var title = $('#title').val();
        var category = $('#category').val();
        var sub_category = $('#sub_category').val();
        var price = $('#price').val();
        var date_publish = $('#date_publish').val();
        var special_price = $('#special_price').val();
        var publisher = $('#publisher').val();

        if(language.length == 0){
            var error = true;
            $('#language').addClass("validation");
        } else {        	
            $('#language').removeClass("validation");
        } 
        if(isbn.length == 0){
            var error = true;
            $('#isbn').addClass("validation");
        } else {        	
            $('#isbn').removeClass("validation");
        } 
        if(title.length == 0){
            var error = true;
            $('#title').addClass("validation");
        } else {        	
            $('#title').removeClass("validation");
        } 
        if(category.length == 0){
            var error = true;
            $('#category').addClass("validation");
        } else {        	
            $('#category').removeClass("validation");
        }
        if(sub_category.length == 0){
            var error = true;
            $('#sub_category').addClass("validation");
        } else {        	
            $('#sub_category').removeClass("validation");
        }
        if(price.length == 0){
            var error = true;
            $('#price').addClass("validation");
        } else {   
            $('#price').removeClass("validation");
        }
        if(date_publish.length == 0){
            var error = true;
            $('#date_publish').addClass("validation");
        } else {        	
            $('#date_publish').removeClass("validation");
        }
        if(special_price.length > 1 && special_price > 0){
        	$("#bookForm #special").prop('checked', true);
        }
        else {
        	$("#bookForm #special").prop('checked', false);
        }
        if(publisher.length == 0){
            var error = true;
            $('#publisher').addClass("validation");
        } else {        	
            $('#publisher').removeClass("validation");
        } 
        
        if(error == false){
        	$('#submitError').fadeOut(500);  
        	$( "#bookForm" ).submit();
        }  
        else{
        	event.preventDefault();
            $('#submitError').fadeIn(500);                     
        }                 
	});    
	//Submit book end
	
	//########################################################################### ui-widget start	
	//Seach book start
	$("#searchBook").click( function() {
    	$('#searchBookForm').fadeIn(500);  
    	$('#publisherBookForm').fadeOut(500);  
    	$('#subCategoryBookForm').fadeOut(500);
    	$('#authorBookForm').fadeOut(500);  
    	$('#titleBookForm').fadeOut(500); 
	});
	
	$(function(){
		$('#book-input').autocomplete({
			source: 'autocompleteBook.php',
				minLength: 9,//search after two characters
				select: function(event,ui){
					var vId = ui.item.id;
				    document.location.href = "index.php?page=books&type=searchBook&id="+vId;
				 }				
		});
	});
	//Search book end	
	
	//Books per Publisher start
	$("#searchBookPublisher").click( function() {
    	$('#publisherBookForm').fadeIn(500);  
    	$('#searchBookForm').fadeOut(500);  
    	$('#subCategoryBookForm').fadeOut(500);  
    	$('#authorBookForm').fadeOut(500);  
    	$('#titleBookForm').fadeOut(500); 
	});	
	
	$(function(){
		$('#publisher-input').autocomplete({
			source: 'autocompletePublisher.php',
				minLength: 3,//search after two characters
				select: function(event,ui){
					var vId = ui.item.id;
				    document.location.href = "index.php?page=books&type=searchBookPublisher&id="+vId;
				 }				
		});
	});	
	//Books per Publisher start

	//Search Books per Sub-category start
	$("#searchBookSubCategory").click( function() {
    	$('#subCategoryBookForm').fadeIn(500);  
    	$('#publisherBookForm').fadeOut(500);  
    	$('#searchBookForm').fadeOut(500);  
    	$('#authorBookForm').fadeOut(500);  
    	$('#titleBookForm').fadeOut(500); 
	});
	
	$("#subcatForm #sub-category").change(function () {
		var subCat = $("#subcatForm #sub-category").val();
	    if(subCat > 0){
	    	document.location.href = "index.php?page=books&type=searchBookSubCategory&id="+subCat;
	    }
	});    
	//Search Books per Sub-category end	
	
	//Books per Author start
	$("#searchBookAuthor").click( function() {
		$('#authorBookForm').fadeIn(500);  
    	$('#publisherBookForm').fadeOut(500);  
    	$('#searchBookForm').fadeOut(500);  
    	$('#subCategoryBookForm').fadeOut(500);  
    	$('#titleBookForm').fadeOut(500); 
	});	
	
	$(function(){
		$('#author-input').autocomplete({
			source: 'autocompleteAuthor.php',
				minLength: 3,//search after two characters
				select: function(event,ui){
					var vId = ui.item.id;
				    document.location.href = "index.php?page=books&type=searchBookAuthor&id="+vId;
				 }				
		});
	});	
	//Books per Author start	

	//Search Books per title start
	$("#searchBookTitle").click( function() {
		$('#titleBookForm').fadeIn(500);  
    	$('#subCategoryBookForm').fadeOut(500);  
    	$('#publisherBookForm').fadeOut(500);  
    	$('#searchBookForm').fadeOut(500);  
    	$('#authorBookForm').fadeOut(500);  
	});
	
	$("#titleForm #titleSubmit").click(function () {
    	event.preventDefault();
		var vTitle = $("#titleForm #id").val();
	    if(vTitle.length > 0){
	    	$("#titleForm").submit();
	    }
	});    
	//Search Books per title end		
	
	//Seach orders per client start
	$("#searchClientOrder").click( function() {
    	$('#isbnSearchForm').fadeOut(500);  
    	$('#referenceSearchForm').fadeOut(500);  
    	$('#clientSearchForm').fadeIn(500);      	
	});
	
	$(function(){
		$('#client-input').autocomplete({
			source: 'autocompleteClientOrder.php',
				minLength: 3,//search after 3 characters
				select: function(event,ui){
					var vId = ui.item.id;
				    document.location.href = "index.php?page=orders&type=client&id="+vId;
				 }				
		});
	});
	//Seach orders per client end		
	
	//Seach orders per client start
	$("#searchRefOrder").click( function() {
    	$('#clientSearchForm').fadeOut(500);  
    	$('#isbnSearchForm').fadeOut(500);  
    	$('#referenceSearchForm').fadeIn(500);  
	});
	
	$(function(){
		$('#ref-input').autocomplete({
			source: 'autocompleteReferenceOrder.php',
				minLength: 3,//search after 3 characters
				select: function(event,ui){
					var vId = ui.item.id;
				    document.location.href = "index.php?page=orders&type=reference&id="+vId;
				 }				
		});
	});
	//Seach orders per client end			
	
	//Search per ISBN
	$("#searchIsbnForm").click( function() {
		$('#referenceSearchForm').fadeOut(500);  
    	$('#clientSearchForm').fadeOut(500);  
    	$('#isbnSearchForm').fadeIn(500);  
	});
	
	$(function(){
		$('#isbn-input').autocomplete({
			source: 'autocompleteIsbnOrder.php',
				minLength: 5,//search after 3 characters
				select: function(event,ui){
					var vId = ui.item.id;
				    document.location.href = "index.php?page=orders&type=isbn&id="+vId;
				 }		
		});

	});
	//Search per ISBN end				
	
	//########################################################################### ui-widget end
	
	//User table functions start
	$("[id^=saveUserButton_]").on('click', function() {
		$("[id^=tr_]").children('td').removeClass("bg-success");
		$("[id^=tr_]").children('td').removeClass("bg-error");	
		var vUsertId = $(this).attr('data-id');
		var vName = $("#name_"+vUsertId).val();
		var vSurname = $("#surname_"+vUsertId).val();
		var vEmail = $("#email_"+vUsertId).val();
		var vRights = $("#rights_"+vUsertId).val();
		var vPassword = $("#password_"+vUsertId).val();
		var vSections = $('input[name="sections_'+vUsertId+'\\[\\]"]:checked').
	    map(function(i, elem) { return $(this).val(); }).get();		
		
		if(vEmail.length == 0){
			$("#email_"+vUsertId).addClass("validation");
			$('#submitError').fadeIn(500);         
			return false;
		}
		else{
			$("#email_"+vUsertId).removeClass("validation");
			$('#submitError').fadeOut(500);        
		}

	   $.post("users_process.php", {type: "edit-sql", user_id: vUsertId, name: vName, surname: vSurname, email: vEmail, rights: vRights, sections: vSections, password: vPassword},function(result){
	    	if(result == 'success'){
				$("#tr_"+vUsertId).children('td').addClass("bg-success");
				$("#tr_"+vUsertId).children('td:last-child').removeClass("bg-success");
	    	}
	    	else if(result == 'error'){
	        	$("#tr_"+vUsertId).children('td').addClass("bg-error");
				$("#tr_"+vUsertId).children('td:last-child').removeClass("bg-error");
	    	}		
	      	 return false;
		  });       	
	});
	
	//User table functions start
	$("[id^=addUserButton]").on('click', function() {
		var error = false;
		var vName = $("#name").val();
		var vSurname = $("#surname").val();
		var vEmail = $("#email").val();
		var vRights = $("#rights").val();
		var vPassword = $("#password").val();
		var vSections = $('input[name="sections\\[\\]"]:checked').
	    map(function(i, elem) { return $(this).val(); }).get();		

        if(vName.length == 0){
            error = true;
            $('#name').addClass("validation");
        } else {        	
            $('#name').removeClass("validation");
        }
        if(vSurname.length == 0){
            error = true;
            $('#surname').addClass("validation");
        } else {        	
            $('#surname').removeClass("validation");
        }
        if(vEmail.length == 0){
            error = true;
            $('#email').addClass("validation");
        } else {        	
            $('#email').removeClass("validation");
        }
        if(vRights.length == 0){
            error = true;
            $('#rights').addClass("validation");
        } else {        	
            $('#rights').removeClass("validation");
        }
        if(vPassword.length == 0){
            error = true;
            $('#password').addClass("validation");
        } else {        	
            $('#password').removeClass("validation");
        }
        if(vSections.length == 0){
            error = true;
            $('#rights-td').addClass("validation");
        } else {        	
            $('#rights-td').removeClass("validation");
        }
        
        if(error == false){
        	$('#submitError').fadeOut(500);  
        	$( "#usersForm" ).submit();
        }  
        else{
        	event.preventDefault();
            $('#submitError').fadeIn(500);                     
        }              
	});	

	$("[id^=deleteUserButton_]").click( function() {
		var vUserId = $(this).attr('data-id');
		theUrl = "users_process.php?type=delete&id="+vUserId;
		if (confirm("Die gebruiker sal uitgevee word.\n\nKlik 'OK' om voort te gaan!")) {
			document.location.href = theUrl;
		}
		else {
			return false;
		}
	});    
	//User table functions end	
	
	//Events list table functions start    
	//Check for integer without . and ,price_
	$("#eventsTable [id^=price_]").on('change', function() {
		var theElement = $(this).attr('id');
		checkInt("#eventsTable", "#"+theElement, "popup");
	});
	
	$("#eventsForm #price").on('change', function() {
		var theElement = $(this).attr('id');
		checkInt("#eventsForm", "#price", "#priceError");//theForm, theInput, theError
	});	
	
	//Check image type and size start
	$('#eventsForm #poster_path').change(function () {
		$('#submitEvent').fadeIn(500); 
	    var ext = this.value.match(/\.(.+)$/)[1].toLowerCase();
	    
	    switch (ext) {
	        case 'jpg':
	        case 'jpeg':
	        case 'png':
	        case 'gif':
	        	$('#eventsForm #filePosterError').fadeOut(500); 
	        	$('#eventsForm #poster_path').removeClass("validation");        	
	            if (window.File && window.FileReader && window.FileList && window.Blob){
	                var fsize = $('#poster_path')[0].files[0].size;
	                if(fsize <= 1048576){
	                	$('#submitEvent').fadeIn(500); 
	                	$('#eventsForm #filePosterSizeError').fadeOut(500); 
	                	$('#eventsForm #blob_path').removeClass("validation");
	                	$('#eventsForm #filePosterError').fadeOut(500);  
	                }
	                else {
	                	$('#submitEvent').fadeOut(500); 
	                	$('#eventsForm #filePosterError').fadeOut(500); 
	                	$('#eventsForm #poster_path').addClass("validation");
	                	$('#eventsForm #filePosterSizeError').fadeIn(500);  
	                }
	            }
	        	else{
	                alert("Please upgrade your browser, because your current browser lacks some new features we need!");
	            }	    
	            
	            var file = $('#eventsForm #poster_path')[0].files[0];
	            if(file) {
	            	var img = new Image();
	            	img.src = window.URL.createObjectURL( file );
	            	img.onload = function() {
	                var width = img.naturalWidth,
	                height = img.naturalHeight;
	                window.URL.revokeObjectURL( img.src );          
	                    if(width <= 900){
	                    	$('#eventsForm #filePosterPhysicalWidthError').fadeOut(500);  
	                    	$('#submitEvent').fadeIn(500); 
	                    }
	                    else {
	                    	$('#eventsForm #filePosterPhysicalWidthError').fadeIn(500);  
	                    	$('#submitEvent').fadeOut(500); 
	                    }
	                    if(height <= 900){
	                    	$('#eventsForm #filePosterPhysicalHeightError').fadeOut(500);  
	                    	$('#submitEvent').fadeIn(500); 
	                    }
	                    else {
	                    	$('#eventsForm #filePosterPhysicalHeightError').fadeIn(500);  
	                    	$('#submitEvent').fadeOut(500); 
	                    }            
	            	};
	            }
	            break;
	        default:
	        	$('#eventsForm #poster_path').addClass("validation");
	        	$('#eventsForm #filePosterError').fadeIn(500);  
	        	$('#submitEvent').fadeOut(500); 
	    }
	});	
	//Check image type and size end	
	
	
	$("[id^=saveEventsButton_]").click( function() {
		$("[id^=tr_]").children('td').removeClass("bg-success");
		$("[id^=tr_]").children('td').removeClass("bg-error");
		var vEventId = $(this).attr('data-id');
		var vName = $("#eventsTable #name_"+vEventId).val();
		var vDate = $("#eventsTable #date_"+vEventId).val();
		var vTime  = $("#eventsTable #time_"+vEventId).val();
		var vDetail  = $("#eventsTable #detail_"+vEventId).val();
		var vRsvp  = $("#eventsTable #rsvp_"+vEventId).val();
		var vPrice  = $("#eventsTable #price_"+vEventId).val();
		var vLocation  = $("#eventsTable #location_"+vEventId).val();
		
		if(vName.length == 0){
			$("#name_"+vEventId).addClass("validation");
			$('#submitError').fadeIn(500);         
			return false;
		}
		else{
			$("#name_"+vEventId).removeClass("validation");
			$('#submitError').fadeOut(500);        
		}
		if(vDate.length == 0){
			$("#date_"+vEventId).addClass("validation");
			$('#submitError').fadeIn(500);         
			return false;
		}
		else{
			$("#date_"+vEventId).removeClass("validation");
			$('#submitError').fadeOut(500);        
		}		
		if(vTime.length == 0){
			$("#time_"+vEventId).addClass("validation");
			$('#submitError').fadeIn(500);         
			return false;
		}
		else{
			$("#time_"+vEventId).removeClass("validation");
			$('#submitError').fadeOut(500);        
		}			
		if(vRsvp.length == 0){
			$("#rsvp_"+vEventId).addClass("validation");
			$('#submitError').fadeIn(500);         
			return false;
		}
		else{
			$("#rsvp_"+vEventId).removeClass("validation");
			$('#submitError').fadeOut(500);        
		}				
		if(vPrice.length == 0){
			$("#price_"+vEventId).addClass("validation");
			$('#submitError').fadeIn(500);         
			return false;
		}
		else{
			$("#price_"+vEventId).removeClass("validation");
			$('#submitError').fadeOut(500);        
		}				
		if(vLocation.length == 0){
			$("#location_"+vEventId).addClass("validation");
			$('#submitError').fadeIn(500);         
			return false;
		}
		else{
			$("#location_"+vEventId).removeClass("validation");
			$('#submitError').fadeOut(500);        
		}		

		$.post("events_process.php", {type: "edit", event_id: vEventId, name: vName, date: vDate, time: vTime, detail: vDetail, rsvp:vRsvp, price: vPrice, location: vLocation},function(result){
			if(result == 'success'){
				$("#tr_"+vEventId).children('td').addClass("bg-success");
				$("#tr_"+vEventId).children('td:last-child').removeClass("bg-success");
	       	 }
	         else if(result == 'error'){
	        	$("#tr_"+vEventId).children('td').addClass("bg-error");
				$("#tr_"+vEventId).children('td:last-child').removeClass("bg-error");
	         }
	      	 return false;
		});
	});    
	
	$("[id^=deleteEventsButton_]").click( function() {
		var vEventsId = $(this).attr('data-id');
		theUrl = "events_process.php?type=delete&id="+vEventsId;
		if (confirm("Die funksie en advertensie sal uitgevee word.\n\nKlik 'OK' om voort te gaan!")) {
			document.location.href = theUrl;
		}
		else {
			return false;
		}
	});    
	
	$("[id^=deleteEventPhoto]").click( function() {
		var vPhotoId = $(this).attr('data-id');
		var vPhotoPath= $(this).attr('data-path');
		var vEventId= $(this).attr('data-event');
		var vReturn= $(this).attr('data-return');
		theUrl = "events_process.php?type=delete-photo&id="+vPhotoId+"&path="+vPhotoPath+"&event-id="+vEventId+"&return="+vReturn;
		if (confirm("Die foto sal uitgevee word.\n\nKlik 'OK' om voort te gaan!")) {
			document.location.href = theUrl;
		}
		else {
			return false;
		}
	});    	
	
	$("[id^=deleteEventImage]").click( function() {
		var vEventId = $(this).attr('data-id');
		var vPosterPath= $(this).attr('data-path');
		theUrl = "events_process.php?type=delete-poster&id="+vEventId+"&path="+vPosterPath;
		if (confirm("Die advertensie sal uitgevee word.\n\nKlik 'OK' om voort te gaan!")) {
			document.location.href = theUrl;
		}
		else {
			return false;
		}
	});    	
	
	$("[id^=submitEvent]").on('click', function() {
		var error = false;
		var vName = $("#name").val();
		var vDate = $("#date").val();
		var vTime = $("#time").val();
		var vLocation = $("#location").val();
		var vDetail = $("#detail").val();
		var vRsvp = $("#rsvp").val();
		var vPrice = $("#price").val();
		var vPosterPath = $("#poster_path").val();
		var vCurrentPosterPath = $("#current_poster_path").val();


        if(vName.length == 0){
            error = true;
            $('#name').addClass("validation");
        } else {        	
            $('#name').removeClass("validation");
        }
        if(vDate.length == 0){
            error = true;
            $('#date').addClass("validation");
        } else {        	
            $('#date').removeClass("validation");
        }
        if(vTime.length == 0){
            error = true;
            $('#time').addClass("validation");
        } else {        	
            $('#time').removeClass("validation");
        }
        if(vLocation.length == 0){
            error = true;
            $('#location').addClass("validation");
        } else {        	
            $('#location').removeClass("validation");
        }        
        if(vDetail.length == 0){
            error = true;
            $('#detail').addClass("validation");
        } else {        	
            $('#detail').removeClass("validation");
        }
        if(vRsvp.length == 0){
            error = true;
            $('#rsvp').addClass("validation");
        } else {        	
            $('#rsvp').removeClass("validation");
        }
        if(vPrice.length == 0){
            error = true;
            $('#price').addClass("validation");
        } else {        	
            $('#price').removeClass("validation");
        }
        if(vPosterPath.length == 0 && vCurrentPosterPath.length == 0){
            error = true;
            $('#poster_path').addClass("validation");
        } else {        	
            $('#poster_path').removeClass("validation");
        }        
        
        if(error == false){
        	$('#submitError').fadeOut(500);  
        	$( "#eventsForm" ).submit();
        }  
        else{
        	event.preventDefault();
            $('#submitError').fadeIn(500);                     
        }              
	});		
	
	$('#eventsForm [id^=photos_]').change(function () {
		var vEventId = $(this).attr('data-id');
		var fileTypeError = false;
		var fileSizeError = false;
		var filePhysicalSizeError = false;
		var files = event.target.files;
		for (var i=0; i < files.length; i++) {
			  	var fileName =  files[i].webkitRelativePath;
			   	var ext = fileName.match(/\.(.+)$/)[1].toLowerCase();
			    switch (ext) {
			        case 'jpg':
			        case 'jpeg':
			        case 'png':
			        case 'gif':
			            if (window.File && window.FileReader && window.FileList && window.Blob){
			                var fsize = files[i].size;
			                if(fsize > 500000){
			                	fileSizeError = true;
			                }
			            }
			        	else{
			                alert("Please upgrade your browser, because your current browser lacks some new features we need!");
			            }	    
			            break;
			        	default:
			        	fileTypeError = true;
			    }
		  }
		if(fileTypeError == true){
        	$("#eventsForm #filePhotosError_"+vEventId).fadeIn(500);  
        	$("#eventsForm #submitEventsPhotosButton_"+vEventId).fadeOut(500);  
		}
		else {
        	$("#eventsForm #filePhotosError_"+vEventId).fadeOut(500);  
        	$("#eventsForm #submitEventsPhotosButton_"+vEventId).fadeIn(500);          	
		}
		if(fileSizeError == true){
        	$("#eventsForm #filePhotosSizeError_"+vEventId).fadeIn(500);  
        	$("#eventsForm #submitEventsPhotosButton_"+vEventId).fadeOut(500);          	
		}
		else {
        	$("#eventsForm #filePhotosSizeError_"+vEventId).fadeOut(500);  
        	$("#eventsForm #submitEventsPhotosButton_"+vEventId).fadeIn(500);          	
		}		
	});	
	//Events list table functions end    	
	
	//Batch  functions start
	$('#stockUpdateForm #stock_file').change(function () {
		$('#stockUpdateForm #submitFile').fadeIn(500); 
	    var ext = this.value.match(/\.(.+)$/)[1].toLowerCase();
	    
	    switch (ext) {
	        case 'xls':
	        case 'xlsx':
	        	$('#stockUpdateForm #fileTypeError').fadeOut(500); 
	        	$('#stockUpdateForm #stock_file').removeClass("validation");        	
	            break;
	        default:
	        	$('#stockUpdateForm #submitFile').fadeOut(500); 	        	
	        	$('#stockUpdateForm #stock_file').addClass("validation");
	        	$('#stockUpdateForm #fileTypeError').fadeIn(500);  
	    }
	});	
	$('#outOfPrintForm #out_of_print_file').change(function () {
		$('#outOfPrintForm #submitFile').fadeIn(500); 
	    var ext = this.value.match(/\.(.+)$/)[1].toLowerCase();
	    
	    switch (ext) {
	        case 'xls':
	        case 'xlsx':
	        	$('#outOfPrintForm #fileTypeError').fadeOut(500); 
	        	$('#outOfPrintForm #out_of_print_file').removeClass("validation");        	
	            break;
	        default:
	        	$('#outOfPrintForm #submitFile').fadeOut(500); 	        	
	        	$('#outOfPrintForm #out_of_print_file').addClass("validation");
	        	$('#outOfPrintForm #fileTypeError').fadeIn(500);  
	    }
	});	
	$('#loadBookListForm #load_book_list_file').change(function () {
		$('#loadBookListForm #submitFile').fadeIn(500); 
	    var ext = this.value.match(/\.(.+)$/)[1].toLowerCase();
	    
	    switch (ext) {
	        case 'xls':
	        case 'xlsx':
	        	$('#loadBookListForm #fileTypeError').fadeOut(500); 
	        	$('#loadBookListForm #load_book_list_file').removeClass("validation");        	
	            break;
	        default:
	        	$('#loadBookListForm #submitFile').fadeOut(500); 	        	
	        	$('#loadBookListForm #load_book_list_file').addClass("validation");
	        	$('#loadBookListForm #fileTypeError').fadeIn(500);  
	    }
	});		
	
	$(function(){
		$('#inPrintPublisherForm #publisher-id-select').autocomplete({
			source: 'autocompletePublisher.php',
				minLength: 2,//search after two characters
				select: function(event,ui){
					var vId = ui.item.id;
					$("#inPrintPublisherForm #publisher-id").val(vId);
				    //document.location.href = "index.php?page=books&type=searchBookPublisher&id="+vId;
				 }				
		});
	});		
	//Batch  functions start	
	
//############################################################################################## Standard code
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val("www.smc-synergy.co.za/downloads/"+$(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
  $('#copyMessage').fadeIn().delay(1500).fadeOut();
}

//Check image types
var blobT = ["jpg", "jpeg", "png", "gif"];
function checkBlob(string) {
    var match = false;
    for(var i=0;i<blobT.length && !match;i++) {
        if(string.indexOf(blobT[i]) > -1) {
            match = true;
        }
    }
    return match;
}

function GetXmlHttpObject() {
  var vXmlHttp=null;
  try {
    // Firefox, Opera 8.0+, Safari
    vXmlHttp=new XMLHttpRequest();
  }
  catch (e) {
    // Internet Explorer
    try {
      vXmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch (e) {
      vXmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
  return vXmlHttp;
}

function getXMLHTTP() {
	var xmlhttp=false;	
	try{
		xmlhttp=new XMLHttpRequest();
	}
	catch(e)	{		
		try{			
			xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e){
			try{
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e1){
				xmlhttp=false;
			}
		}
	}
	 	
	return xmlhttp;
} 

function urlencode(s) {
  s = encodeURIComponent(s);
  return s.replace(/~/g,'%7E').replace(/%20/g,'+');
} 

function show_body(){
    $(function (){
        $("#pre_load").fadeOut(500);
    });
} 

function getData(theValue, theType, theTable){
	strURL =  "parts/GetValues.php?selected_value="+theValue+"&type="+theType+"&table="+theTable;	
	var req = getXMLHTTP();
	 if (req){
		 req.onreadystatechange = function(){
			 if (req.readyState == 4) {
				 if (req.status == 200) {                  
					 document.getElementById(theTable).innerHTML=req.responseText;
				 }
				 else{ 
					 alert("There was a problem while using XMLHTTP:\n");
				 }
			 }            
		 };
		 req.open("GET", strURL, true); //open url using get method
		 req.send(null);
	 }
} 

function updateData(pType, pTable, pField, pId, pValue) {
	if(pType == "update"){
		var vUrl="parts/UpdateValues.php?";
	}

  handleIndicator("pre_load");
  vXmlHttp=GetXmlHttpObject();
  if (vXmlHttp==null) {
    alert ("Your browser does not support AJAX!");
    return;
  } 
  vUrl+="type="+urlencode(pType);  
  vUrl+="&table="+urlencode(pTable);
  vUrl+="&field="+urlencode(pField);
  vUrl+="&value="+urlencode(pValue);
  vUrl+="&id="+urlencode(pId);  
  vXmlHttp.open("GET",vUrl,true);
  vXmlHttp.send(null);
} 

function handleIndicator(pDivName) {
	show(pDivName);
	setTimeout("hide('"+pDivName+"')", 500);
} 

function show(obj) {
	var div = document.getElementById(obj);
	div.style.display = '';
} 

function hide(obj) {
	var div = document.getElementById(obj);
	div.style.display = 'none';
} 

function getPageContent(theValue){
	document.location.href = "index.php?page=content&selected="+theValue+"&type=edit";
} 

function getService(theValue){
	document.location.href = "index.php?page=services&selected="+theValue+"&type=edit";
} 

function checkInt(theForm, theInput, theError){
	//Check for integer without . and ,
	var theFormInput = theForm+" "+theInput;
		var vPrice = $(theFormInput).val();
		if(Math.floor(vPrice) == +vPrice && $.isNumeric(vPrice)){
			if (vPrice.indexOf(".") == -1) {
				$(theError).fadeOut(500);   
				$(theInput).removeClass("validation");		
			}
			else {
				if(theError != "popup"){
					$(theError).fadeIn(500);   
				}
				else if(theError == "popup"){
					alert("Slegs getalle word toegelaat bv. 100.<br>Verwyder alle punte(.), spasies en kommas(,)!");
				}				
				$(theInput).addClass("validation");
			}
	    }
		else {
			if(theError != "popup"){
				$(theError).fadeIn(500);   
			}
			else if(theError == "popup"){
				alert("Slegs getalle word toegelaat bv. 100.<br>Verwyder alle punte(.), spasies en kommas(,)!");
			}							
			$(theError).addClass("validation");
		}
}