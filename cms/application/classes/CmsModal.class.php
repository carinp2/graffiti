<?php
/**
 * @author Carin Pretorius - CEIT Development
 * Created on 2016-11-02
 */

class CmsModal {

	public static function addPublisherForm(){
		$vString = "<div id=\"add-publisher\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">";
			$vString .= "<div class=\"modal-dialog\" role=\"document\">";
				$vString .= "<div class=\"modal-content\" id=\"narrow-form\">";
					$vString .= "<form class=\"form-horizontal loginFrm form-no-space\" name=\"publisherForm\" id=\"publisherForm\" method=\"post\" action=\"publisher_process.php\">";
						$vString .= "<div class=\"modal-header\">";
							$vString .="<div class=\"row\">";
								$vString .="<div class=\"col-xs-12 green\">";
									$vString .= "<i class=\"icon-window-close close\" data-dismiss=\"modal\"></i>";
									$vString .= "<h4 class=\"modal-title red\">Nuwe Uitgewer</h4>";
								$vString .="</div>";
							$vString .="</div>";
						$vString .= "</div>";//header
						$vString .= "<div class=\"modal-body\">";
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<label for=\"id\" class=\"modal-label\">Id:</label>";
										$vString .= "<input class=\"modal-input\" type=\"text\" name=\"new_id\" id=\"new_id\" size=\"10\" maxlength=\"10\">";
										$vString .= "<article>";
											$vString .= "<div>";
												  $vString .= "<div id=\"id_exist\" class=\"error\" style=\"display:none;\">Die ID bestaan reeds in die databasis.</div>";
											$vString .= "</div>";
										$vString .= "</article>";
									$vString .= "</div>";
								$vString .= "</div>";
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<label for=\"new_publisher\" class=\"modal-label\">Uitgewer:</label>";
										$vString .= "<input class=\"modal-input\" type=\"text\" name=\"new_publisher\" id=\"new_publisher\" size=\"50\" maxlength=\"50\">";
										$vString .= "<article>";
											$vString .= "<div>";
												  $vString .= "<div id=\"publisher_exist\" class=\"error\" style=\"display:none;\">Die Uitgewer bestaan reeds in die databasis.</div>";
											$vString .= "</div>";
										$vString .= "</article>";
									$vString .= "</div>";
								$vString .= "</div>";
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\">";
										$vString .= "<label for=\"new_supplier\" class=\"modal-label\">Verskaffer:</label>";
										$vString .= "<input class=\"modal-input\" type=\"text\" name=\"new_supplier\" id=\"new_supplier\" size=\"50\" maxlength=\"50\">";
									$vString .= "</div>";
								$vString .= "</div>";
					            $vString .= "<article>";
						            $vString .= "<div>";
										  $vString .= "<div id=\"completePublisherError\" class='error' style=\"display:none;\">Voltooi asb. die verpligte velde</div>";
									$vString .= "</div>";
								$vString .= "</article>";
						$vString .= "</div>";//body
							$vString .= "<div class=\"modal-footer modal-footer-cms\">";
									$vString .="<div class=\"row\">";
										$vString .="<div class=\"col-xs-12\">";
											$vString .= "<input type=\"hidden\" name=\"type\" id=\"type\" value=\"add\">";
											$vString .= "<button type=\"submit\" id=\"publisherSubmit\" class=\"btn btn-primary space-right\">Stoor</button>";
											$vString .= "<button type=\"submit\" id=\"formClose\" class=\"btn btn-primary\" data-dismiss=\"modal\">Maak toe</button>";
										$vString .="</div>";
									$vString .="</div>";
							$vString .="</div>";//footer
						$vString .= "</form>";
				$vString .= "</div>";//content
			$vString .= "</div>";//dialog
		$vString .= "</div>";

		$vString .= "<Script>
			$('#publisherForm #publisherSubmit').click(function(e){
				$('#completePublisherError').fadeOut(500);
				e.preventDefault();
				var error = false;

				var vId = $('#publisherForm #new_id').val();
				var vPublisher = $('#publisherForm #new_publisher').val();
				var vSupplier = $('#publisherForm #new_supplier').val();

				if(vId.length == 0){
			      	var error = true;
			      	$('#publisherForm #new_id').addClass('validation');
			  	} else {
			      	$('#publisherForm #new_id').removeClass('validation');
			  	}
				if(vPublisher.length == 0){
					var error = true;
			      	$('#publisherForm #new_publisher').addClass('validation');
				 } else {
				      $('#publisherForm #new_publisher').removeClass('validation');
				 }
				 if(vSupplier.length == 0){
				      var error = true;
				      $('#publisherForm #new_supplier').addClass('validation');
				 } else {
				      $('#publisherForm #new_supplier').removeClass('validation');
				 }

				 if(error == false){
				  	$('#completePublisherError').fadeOut(500);
				  	$('#publisherForm').submit();
				 }
				 else{
				  	event.preventDefault();
				    $('#completePublisherError').fadeIn(500);
				 }
			});

			$('#publisherForm #new_id').on('change', function() {
				var vId = $('#publisherForm #new_id').val();
			   $.post('publisher_process.php', {type: 'check-id', new_id: vId},function(result){
			   	if (result == 'exist') {
			   		$('#id_exist').fadeIn(500);
			   		$('#publisherForm #new_id').addClass('validation');
			   		$('#publisherForm #publisherSubmit').fadeOut(500);
			     }
			   	else{
			   		$('#id_exist').fadeOut(500);
			   		$('#publisherForm #new_id').removeClass('validation');
			   		$('#publisherForm #publisherSubmit').fadeIn(500);
			   	}
			  });
			});

			$('#publisherForm #new_publisher').on('change', function() {
				var vPublisher = $('#publisherForm #new_publisher').val();
			   $.post('publisher_process.php', {type: 'check-publisher', new_publisher: vPublisher},function(result){
			   	if (result == 'exist') {
			   		$('#publisher_exist').fadeIn(500);
			   		$('#publisherForm #new_publisher').addClass('validation');
			   		$('#publisherForm #publisherSubmit').fadeOut(500);
			     }
			   	else{
			   		$('#publisher_exist').fadeOut(500);
			   		$('#publisherForm #new_publisher').removeClass('validation');
			   		$('#publisherForm #publisherSubmit').fadeIn(500);
			   	}
			  });
			});

			</Script>";

		return General::prepareStringForDisplay($vString);
	}

	public static function orderBooks(){
		$vString = "<div id=\"orderbooks\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">";
			$vString .= "<div class=\"modal-dialog\" role=\"document\">";
				$vString .= "<div class=\"modal-content\" id=\"narrow-form\">";
						$vString .= "<div class=\"modal-header\">";
							$vString .="<div class=\"row\">";
								$vString .="<div class=\"col-xs-12 green\">";
									$vString .= "<i class=\"icon-window-close close\" data-dismiss=\"modal\"></i>";
									$vString .= "<h4 class=\"modal-title red\">Boeke in bestelling</h4>";
								$vString .="</div>";
							$vString .="</div>";
						$vString .= "</div>";//header
						$vString .= "<div class=\"modal-body\">";
							$vString .="<div class=\"row\">";
								$vString .= "<div class=\"col-xs-12\"><span  id=\"books\"></span></div>";
								$vString .= "</div>";
						$vString .= "</div>";//body
							$vString .= "<div class=\"modal-footer modal-footer-cms\">";
									$vString .="<div class=\"row\">";
										$vString .="<div class=\"col-xs-12\">";
											$vString .= "<button type=\"submit\" id=\"formClose\" class=\"btn btn-primary\" data-dismiss=\"modal\">Maak toe</button>";
										$vString .="</div>";
									$vString .="</div>";
							$vString .="</div>";//footer
				$vString .= "</div>";//content
			$vString .= "</div>";//dialog
		$vString .= "</div>";

		return General::prepareStringForDisplay($vString);
	}

//	public static function waybillGenerator(){
//		$vString = "<div id=\"waybill_ie\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">";
//			$vString .= "<div class=\"modal-dialog\" role=\"document\">";
//				$vString .= "<div class=\"modal-content\" id=\"narrow-form\">";
//						$vString .= "<div class=\"modal-header\">";
//							$vString .="<div class=\"row\">";
//								$vString .="<div class=\"col-xs-12 green\">";
//									$vString .= "<i class=\"icon-window-close close\" data-dismiss=\"modal\"></i>";
//									$vString .= "<h4 class=\"modal-title red\">Waybill</h4>";
//								$vString .="</div>";
//							$vString .="</div>";
//						$vString .= "</div>";//header
//						$vString .= "<div class=\"modal-body\">";
//							$vString .="<div class=\"row\">";
//								$vString .= "<div class=\"col-xs-12\"><span  id=\"waybill_address\"></span></div>";
//								$vString .= "</div>";
//						$vString .= "</div>";//body
//							$vString .= "<div class=\"modal-footer modal-footer-cms\">";
//									$vString .="<div class=\"row\">";
//										$vString .="<div class=\"col-xs-12\">";
//											$vString .= "<button type=\"submit\" id=\"formClose\" class=\"btn btn-primary\" data-dismiss=\"modal\">Maak toe</button>";
//										$vString .="</div>";
//									$vString .="</div>";
//							$vString .="</div>";//footer
//				$vString .= "</div>";//content
//			$vString .= "</div>";//dialog
//		$vString .= "</div>";
//
//		return General::prepareStringForDisplay($vString);
//	}

	public static function loadCmsModals(){
		$vString = "";
		$vAddPublisher = CmsModal::addPublisherForm();
		$vString .= $vAddPublisher;

		$vOrderBooks = CmsModal::orderBooks();
		$vString .= $vOrderBooks;

		return $vString;
	}

}
?>