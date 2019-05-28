<?php
	
	function main() { ?>
	<a href="/testcontent.php" data-target="#ajax" data-toggle="modal"><button type="button" class="btn btn-success" >Add Section Ajax</button></a>

<a href="#" data-href="delete.php?id=23" data-toggle="modal" data-target="#confirm-delete">Delete record #23</a>

<button class="btn btn-default" data-href="/delete.php?id=54" data-title="Delete this item" data-body="Are you sure you wish to delete this item?" data-toggle="modal" data-target="#confirm-delete">
    Delete record #54
</button>


<div class="modal fade" id="confirm-click" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="modal-confirm-title">
            </div>
            <div class="modal-body" id="modal-confirm-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok" id="modal-confirm-button">Delete</a>
            </div>
        </div>
    </div>
</div>
<button class="btn btn-default confirm-click" data-href="/delete.php?id=54" data-button="Send" data-title="Send a Reminder" data-body="Are you sure you wish to send a reminder?" data-toggle="modal" data-target="#confirm-click">
    Delete record #54
</button>
<button class="btn btn-default confirm-click" data-href="/delete.php?id=54" data-button="Send Reminder" data-title="Send Reminder" data-body="Are you sure you wish to send a reminder?" data-toggle="modal" data-target="#confirm-click">
    Set for each button
</button>
<button class="btn btn-default confirm-click" data-href="/delete.php?id=54" data-toggle="modal" data-target="#confirm-click">
  Set once on the page
</button>

	
	
	
<script>
<script>
$(function() {
	// Confirmation Modal Controls
	
	$('.confirm-click').click(function(e) {
		
		
		if ($(this).data("title")) {
			alert('1');
			$('#modal-confirm-title').html("<h4>"+$(this).data("title")+"</h4>");
		} else if (modal_title) {
				alert('2');
			$('#modal-confirm-title').html("<h4>"+modal_title+"</h4>");
		} else {
				alert('3');
			$('#modal-confirm-title').html("<h4>Confirm</h4>");
		}
		
		
		if ($(this).data("body")) {
			$('#modal-confirm-body').html($(this).data("body"));
		} else if (modal_body) {
			$('#modal-confirm-body').html(modal_body);
		} else {
			$('#modal-confirm-body').html("Do you wish to proceed?");
		}
		
	
		if ($(this).data("button")) {
			$('#modal-confirm-button').html($(this).data("button"));
		} else if (modal_button) {
			$('#modal-confirm-button').html(modal_button);
		} else {
			$('#modal-confirm-button').html("Yes");
		}
		
		
	});
	$('#confirm-click').on('show.bs.modal', function(e) {
	    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});
});
</script>
<script src="../assets/pages/scripts/ui-modals.min.js" type="text/javascript"></script>

 <div class="modal fade" id="ajax" role="basic" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <img src="../assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                                                    <span> &nbsp;&nbsp;Loading... </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

	
	<?php } ?>