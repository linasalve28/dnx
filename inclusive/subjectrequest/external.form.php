<?php
	function main() { ?>
		
		
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Data Subject Request</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="name">Name</label>  
  <div class="col-md-4">
  <input id="name" name="name" type="text" placeholder="" class="form-control input-md">
  <span class="help-block">Please enter your full name</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email Address</label>  
  <div class="col-md-4">
  <input id="email" name="email" type="text" placeholder="" class="form-control input-md">
  <span class="help-block">Enter your email address</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="phone">Phone Number</label>  
  <div class="col-md-4">
  <input id="phone" name="phone" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Request Type</label>
  <div class="col-md-4">
    <select id="selectbasic" name="selectbasic" class="form-control">
      <option value="1">Access my information</option>
      <option value="2">Updated/Correct Information</option>
            <option value="2">Request deletion of data</option>
                  <option value="2">Data Portability</option>
                        <option value="2">Other</option>
                  
    </select>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="details">Additional Details</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="details" name="details"></textarea>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit Request</button>
  </div>
</div>

</fieldset>
</form>
	
<?php
	}
?>