<?php
function main() {

    ?>
    <link rel="stylesheet" type="text/css" href="/trustbase.gateway.css">
    <!--Quick Menu -->
    <div class="row">
        <div class="col-xl-3 col-sm-6">
            <a href="<?php echo DOMAIN_PATH; ?>/controller/assessment/list">
                <div class="card card-shadow mb-4">
                    <div class="card-body">
                        <div class="media d-flex align-items-center ">
                            <div class="mr-4 rounded-circle bg-warning sr-icon-box bubble-shadow-small">
                                <i class="vl_user-male"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="mb-0 weight500">Assessments</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6">
            <a href="<?php echo DOMAIN_PATH; ?>/controller/assessment/list">
                <div class="card card-shadow mb-4">
                    <div class="card-body">
                        <div class="media d-flex align-items-center">
                            <div class="mr-4 rounded-circle bg-purple sr-icon-box bubble-shadow-small">
                                <i class="vl_download"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="mb-0 weight500">Data Manager</h4>

                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6">
            <a href="<?php echo DOMAIN_PATH; ?>/controller/assessment/list">
                <div class="card card-shadow mb-4">
                    <div class="card-body">
                        <div class="media d-flex align-items-center">
                            <div class="mr-4 rounded-circle bg-danger sr-icon-box bubble-shadow-small">
                                <i class="vl_shopping-bag2"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="mb-0 weight500">Data Subject Requests</h4>

                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6">
            <a href="<?php echo DOMAIN_PATH; ?>/controller/assessment/list">
                <div class="card card-shadow mb-4">
                    <div class="card-body">
                        <div class="media d-flex align-items-center">
                            <div class="mr-4 rounded-circle bg-purple-light sr-icon-box bubble-shadow-small">
                                <i class="vl_cart-empty"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="mb-0 weight500">Request Assistance</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <!--Quick Menu -->
    <!--sales report & active user-->
    <div class="row">
        <div class="col-xl-8 col-md-7">
            <div class="card card-shadow mb-4">
                <div class="card-header border-0">
                    <div class="custom-title-wrap bar-primary">
                        <div class="custom-title">PrivacyBase Status Report</div>
                        <div class=" widget-action-link">
                            <div class="dropdown">
                                <a href="#" class="btn btn-transparent text-secondary dropdown-hover p-0" data-toggle="dropdown">
                                    <i class=" vl_ellipsis-fill-h"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right vl-dropdown">
                                    <a class="dropdown-item" href="#"> Edit</a>
                                    <a class="dropdown-item" href="#"> Delete</a>
                                    <a class="dropdown-item" href="#"> Settings</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-5">
            <div class="card text-light mb-4 basic-gradient bubble-shadow">
                <div class="widget-action-link">
                    <div class="dropdown">
                        <a href="#" class="btn btn-transparent text-white dropdown-hover p-0" data-toggle="dropdown">
                            <i class=" vl_ellipsis-fill-h"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right vl-dropdown">
                            <a class="dropdown-item" href="#"> Edit</a>
                            <a class="dropdown-item" href="#"> Delete</a>
                            <a class="dropdown-item" href="#"> Settings</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="widget-active-user">
                        <h5 class="mt-3 b-b1 mb-4">Data Subject Requests</h5>
                        <h1 class="mb-4">13</h1>
                        <h5 class="mt-3 b-b1 mb-5">Average Resolution Time</h5>
                        <h1 class="mb-4">26 Days</h1>
                        <h5 class="mt-5 mb-0">Request Types</h5>
                        <ul class="list-unstyled active-page-link">
                            <li><small>Access Request</small> <span>8</span></li>
                            <li><small>Deletion Request</small> <span>4</span></li>
                            <li><small>Automatic Processing</small> <span>6</span></li>
                            <li><small>Opt Out</small> <span>5</span></li>
                            <li><small>Copy of Information</small> <span>1</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/sales report & active user-->





    <?php
}

?>