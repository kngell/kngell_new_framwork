<?php $this->start('head'); ?>
<!-------Costum-------->
<link
    href="<?= $this->asset('css/custom/admin/dashboard/dashboard', 'css') ?? ''?>"
    rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="page-content">
    <h1 class="header-title h3 mb-4">
        <span class="text-highlight">E-Commerce</span> <span class="fw-300">Dashboard</span>
    </h1>
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="text-muted mb-1 text-truncate">Total Earnings
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="icon-sm bg-primary rounded float-end">
                                <i class="fal fa-usd-circle"></i>
                            </div>
                        </div>
                    </div>
                    <h2 class="my-1 fw-300">$24,431</h2>
                    <div class="mt-3">
                        <h6>Target <span class="float-end">59%</span></h6>
                        <div class="progress progress-sm m-0">
                            <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="59" aria-valuemin="0"
                                aria-valuemax="100" style="width: 59%">
                                <span class="sr-only">59% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="text-muted mb-1 text-truncate">Sales Today</p>
                        </div>
                        <div class="col-6">
                            <div class="icon-sm bg-success rounded float-end">
                                <i class="fal fa-shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                    <h2 class="my-1 fw-300">1,576</h2>
                    <div class="mt-3">
                        <h6>Target <span class="float-end">68%</span></h6>
                        <div class="progress progress-sm m-0">
                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="68" aria-valuemin="0"
                                aria-valuemax="100" style="width: 68%">
                                <span class="sr-only">68% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="text-muted mb-1 text-truncate">Pending Orders</p>
                        </div>
                        <div class="col-6">
                            <div class="icon-sm bg-info rounded float-end">
                                <i class="fal fa-user-clock"></i>
                            </div>
                        </div>
                    </div>
                    <h2 class="my-1 fw-300"><span>234</span></h2>
                    <div class="mt-3">
                        <h6>Target <span class="float-end">74%</span></h6>
                        <div class="progress progress-sm m-0">
                            <div class="progress-bar bg-info" role="progressbar" aria-valuenow="74" aria-valuemin="0"
                                aria-valuemax="100" style="width: 74%">
                                <span class="sr-only">74% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="text-muted mb-1 text-truncate">Payouts</p>
                        </div>
                        <div class="col-6">
                            <div class="icon-sm bg-warning rounded float-end">
                                <i class="fal fa-receipt"></i>
                            </div>
                        </div>
                    </div>
                    <h2 class="my-1 fw-300">$4,321</h2>
                    <div class="mt-3">
                        <h6>Target <span class="float-end">76%</span></h6>
                        <div class="progress progress-sm m-0">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="76" aria-valuemin="0"
                                aria-valuemax="100" style="width: 76%">
                                <span class="sr-only">76% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div> <!-- end row -->
    <div class="row">
        <div class="col-md-6 d-flex">
            <div class="card w-100 ">
                <div class="d-flex justify-content-between p-3">
                    <h5 class="card-title mb-0">Location</h5>
                    <div class="card-actions">
                        <div class="d-inline-block dropdown show">
                            <a href="#" data-bs-toggle="dropdown" data-display="static">
                                <i class="far fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Export</a>
                                <a class="dropdown-item" href="#">Profit</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4">
                    <div id="world_map" style="height: 340px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex">
            <div class="card flex-fill w-100 ">
                <div class="d-flex justify-content-between p-3">
                    <h5 class="card-title mb-0">Total Sales</h5>
                    <div class="card-actions float-end">
                        <div class="d-inline-block dropdown show">
                            <a href="#" data-bs-toggle="dropdown" data-display="static">
                                <i class="far fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Export</a>
                                <a class="dropdown-item" href="#">Profit</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4">
                    <div class="">
                        <canvas id="dashboard-doughnut-chartjs"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 d-flex">
            <div class="card flex-fill w-100 ">
                <div class="d-flex justify-content-between p-3">
                    <h5 class="card-title mb-0">Lifetime Sales</h5>
                    <div class="card-actions">
                        <div class="d-inline-block dropdown show">
                            <a href="#" data-bs-toggle="dropdown" data-display="static">
                                <i class="far fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Export</a>
                                <a class="dropdown-item" href="#">Profit</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4">
                    <canvas id="dashboard-line-chartjs"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex">
            <div class="card flex-fill w-100 ">
                <div class="d-flex justify-content-between p-3">
                    <h5 class="card-title mb-0">Top Selling Products</h5>
                    <div class="card-actions">
                        <div class="d-inline-block dropdown show">
                            <a href="#" data-bs-toggle="dropdown" data-display="static">
                                <i class="far fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Export</a>
                                <a class="dropdown-item" href="#">Profit</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Amout</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>PlayStation Store Gift Card</td>
                                    <td>$10</td>
                                    <td>100</td>
                                    <td>$1,000</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Water Sports Shoes</td>
                                    <td>$13.68</td>
                                    <td>100</td>
                                    <td>$1,368</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Wireless Security Camera</td>
                                    <td>$29.99</td>
                                    <td>100</td>
                                    <td>$2,999</td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>WiFi Sports Action Camera Ultra HD</td>
                                    <td>$50</td>
                                    <td>100</td>
                                    <td>$5,000</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Electronics Universal Smartphone</td>
                                    <td>$6.99</td>
                                    <td>100</td>
                                    <td>$699</td>
                                </tr>
                                <tr>
                                    <th scope="row">5</th>
                                    <td>WD 4TB Elements Portable External Hard Drive</td>
                                    <td>$89.99</td>
                                    <td>100</td>
                                    <td>$8,999</td>
                                </tr>
                                <tr>
                                    <th scope="row">6</th>
                                    <td>Unlisted by Kenneth Cole Men's Dress Shirt Slim Fit Checks and Stripes</td>
                                    <td>19.99</td>
                                    <td>100</td>
                                    <td>$1,999</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 d-flex">
            <div class="card flex-fill w-100 ">
                <div class="d-flex justify-content-between p-3">
                    <h5 class="card-title mb-0">Revenue</h5>
                    <div class="card-actions">
                        <div class="d-inline-block dropdown show">
                            <a href="#" data-bs-toggle="dropdown" data-display="static">
                                <i class="far fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Export</a>
                                <a class="dropdown-item" href="#">Profit</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4">
                    <canvas id="dashboard-progress-bar-chartjs"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex">
            <div class="card flex-fill w-100 ">
                <div class="d-flex justify-content-between p-3">
                    <h5 class="card-title mb-0">Expect and Actual</h5>
                    <div class="card-actions float-end">
                        <div class="d-inline-block dropdown show">
                            <a href="#" data-bs-toggle="dropdown" data-display="static">
                                <i class="far fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Export</a>
                                <a class="dropdown-item" href="#">Profit</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4">
                    <canvas id="dashboard-bar-chartjs"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript"
    src="<?= $this->asset('js/custom/admin/dashboard', 'js') ?? ''?>">
</script>
<?php $this->end();
