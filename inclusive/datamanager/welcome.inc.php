<?php
function main() {
		
?>
<link rel="stylesheet" type="text/css" href="/trustbase.gateway.css">
			<style>
				.card-icon i {
					
				background-color: #13232F;	
				color:white;
				}
</style>			
			<div class="m-heading-1 border-green m-bordered">
    <h3>Data Manager</h3>
    <p>
	    Data Manager allows you to record, map and determine how data is flowing through your company. Using roles such as Data Controllers and Data Processors, you can also determine who is responsible for the data. 
    </p>

  </div>
			
		<div class="row margin-bottom-20">
                        <div class="col-lg-3 col-md-6">
	                          
		                    <div class="portlet light card-radius">
                                <div class="card-icon">
                                    <i class="icon-shuffle theme-font"></i>
                                </div>
                                <div class="card-title">
                                    <span> Data Subject Group</span>
                                </div>
                                <div class="card-desc">
                                    <span> Data Subjects are people you collect information on.<br>&nbsp;
                                       </span>
                                    <div class="page-actions">
                    <div class="btn-group">
                        <button type="button" class="btn btn-circle btn-outline blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-plus"></i>&nbsp;
                            <span class="hidden-sm hidden-xs">I want to...</span>&nbsp;
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="/inclusive/datamanager/ajax/dsg.form.php?function=add" class="f4">
                                    <i class="icon-docs"></i> Create New Data Subject Group</a>
                            </li>
                                   <li class="divider"> </li>
                            <li>
                                <a href="/controller/dsglist">
                                    <i class="icon-tag"></i> View Existing Groups </a>
                            </li>

                                                 </ul>
                    </div>
                </div>
                                </div>
                            </div>
	                       
                        </div>
                        <div class="col-lg-3 col-md-6">
	                                                    <div class="portlet light card-radius">
                                <div class="card-icon">
                                    <i class="icon-layers theme-font"></i>
                                   <!-- <span class="badge badge-default"> 7 </span> -->
                                </div>
                                <div class="card-title">
                                    <span> Data Transfers </span>
                                </div>
                                <div class="card-desc">
                                    <span> View how data enters and leaves your company</span>
                                    
                                    <!-- start -->
                                     <style>
	                                     .textwhite:hover {
		                                     color: white;
	                                     }
	                                     </style>     <br><br>
                    <div class="btn-group">
                        <button type="button" class="btn btn-circle btn-outline blue dropdown-toggle " data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-plus"></i>&nbsp; 
                            <span class="hidden-sm hidden-xs textwhite">I want to...</span>&nbsp;
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="/controller/dtaform?function=add">
                                    <i class="icon-docs"></i> Create a new Data Transfer</a>
                            </li>
                                   <li class="divider"> </li>
                            <li>
                                <a href="/controller/dtalist">
                                    <i class="icon-tag"></i> View Existing Data Transfers </a>
                            </li>
                                             </ul>
                    </div>

                                <!-- end -->
                                </div>
                            </div>
	                         
                        </div>
                        <div class="col-lg-3 col-md-6">
                        <a href="/controller/dsrlist">
	                        <div class="portlet light card-radius">
                                <div class="card-icon">
                                    <i class="icon-users theme-font"></i>
                                </div>
                                <div class="card-title">
                                    <span> Subject Data Requests </span>
                                </div>
                                <div class="card-desc">
                                    <span> View and manage requests from Data Subjects
                                        </span>
                                </div>
                            </div>
                        </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            
                        </div>
                    </div>
<?php
}	                    
?>