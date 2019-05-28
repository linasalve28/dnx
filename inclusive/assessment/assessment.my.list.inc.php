<?php
// SQL IDENTIKEY CONFIRMED
include(FS_ASSESSMENT_FUNCTIONS."/request.list.function.php");

function main() {
	global $db;
	global $errorcode;
	global $outcome;
	global $s_identikey;
	global $s_username;
	global $dev;
?>
  <div class="m-heading-1 border-green m-bordered">
    <h3>My Assessments </h3>
    <p>Below are assessments that you created, and your responses to them.
    </p>
  </div>


<script>
	var modal_body="Are you certain you wish to reject this Assessment Request?";
	var modal_title="Delete Assessment Request";
	var modal_button="Delete";
	</script>
	
<div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-social-dribbble font-purple-soft"></i>
                                        <span class="caption-subject font-purple-soft bold uppercase">Responses</span>
                                    </div>
                                    
                                </div>
                                <div class="portlet-body">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a href="#tab_1_1" data-toggle="tab" aria-expanded="true" class="nav-link active"> Draft Responses</a>
                                        </li>
                                        <li class="">
                                            <a href="#tab_1_2" data-toggle="tab" aria-expanded="true" class="nav-link"> Submitted Responses </a>
                                        </li>

                                        <li class="">
                                            <a href="#tab_1_3" data-toggle="tab" aria-expanded="true" class="nav-link"> Response Received</a>
                                        </li>
                                        
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade active in" id="tab_1_1">   
                                     <?php display_inprogress_list("draft"); ?>
                                       
                                        </div>
                                        <div class="tab-pane fade" id="tab_1_2">
	                                   <?php display_inprogress_list("submitted"); ?>
                                       
                                        </div>
                                        <div class="tab-pane fade" id="tab_1_3">
	                                   <?php display_inprogress_list("submitted"); ?>
                                       
                                        </div>
                                     
                                                                            </div>
                                    <div class="clearfix margin-bottom-20"> </div>
                                    
                                    
                                </div>
                            </div>


</div>


<div class="modal fade" id="confirm-click" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="modal-confirm-title" style=""><h4>Alpha Request</h4>
            </div>
            <div class="modal-body" id="modal-confirm-body">Alpha Body Request
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok" id="modal-confirm-button">Delete</a>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
	// Confirmation Modal Controls
	
	$('.confirm-click').click(function(e) {
		if ($(this).data("title")) {
			$('#modal-confirm-title').html("<h4>"+$(this).data("title")+"</h4>");
			$('#modal-confirm-body').html($(this).data("body"));
			$('#modal-confirm-button').html($(this).data("button"));
			
		} else if (modal_title) {
			$('#modal-confirm-title').html("<h4>"+modal_title+"</h4>");
			$('#modal-confirm-body').html(modal_body);
			$('#modal-confirm-button').html(modal_button);
		} else {
			$('#modal-confirm-body').html('Are you sure you wish to proceed?');
			$('#modal-confirm-title').html('<h4>Confirm</h4>');
			$('#modal-confirm-button').html('Yes');
		}
		
	});
	$('#confirm-click').on('show.bs.modal', function(e) {
	    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});
});
</script>



  <?php
}
?>