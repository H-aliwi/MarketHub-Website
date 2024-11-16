<?php
session_start();
// if Admin is recored Welcome   
// if (isset($_SESSION['usernameA'])) {
    $pageTitle = "Control Page";

include("intil.php");
?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<style>

.card {
    box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
    margin-top:20px;
}
.avatar.sm {
    width: 2.25rem;
    height: 2.25rem;
    font-size: .818125rem;
}
.table-nowrap .table td, .table-nowrap .table th {
    white-space: nowrap;
}
.table>:not(caption)>*>* {
    padding: 0.75rem 1.25rem;
    border-bottom-width: 1px;
}
table th {
    font-weight: 600;
    background-color: #eeecfd !important;
    
}
.fa-plus:before {
    content: "\f067";
    margin-right: 4px;
}
</style>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

<div class="container">
    <div class="row">
        <div class="col-12 mb-3 mb-lg-5">
            <div class="overflow-hidden card table-nowrap table-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Items table</h5>
                    <a href="#!" class="btn btn-light btn-sm"><i class="fa-sharp fa-solid fa-plus"></i>Add New item</a>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="small text-uppercase bg-body text-muted">
                            <tr>
                                <th>Item title</th>
                                <th>Item State</th>
                                <th>Shop ID</th>
                                <th>Price</th>
                                <th>Listed Date</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr class="align-middle">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar5.png" class="avatar sm rounded-pill me-3 flex-shrink-0" alt="Customer">
                                        <div>
                                            <div class="h6 mb-0 lh-1">iphone 12</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Active</td>
                                <td>
                                    <span class="d-inline-block align-middle">1</span>
                                </td>
                                <td><span>20.300BD</span></td>
                                <td>01 June, 2021</td>
                                <td style="">
								<a href="#" class="table-link">
									<span class="fa-stack">
										<i class="fa fa-square fa-stack-2x"></i>
										<i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>
									</span>
								</a>
								<a href="#" class="table-link">
									<span class="fa-stack">
										<i class="fa fa-square fa-stack-2x"></i>
										<i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
									</span>
								</a>
								<a href="#" class="table-link danger">
									<span class="fa-stack" >
										<i class="fa fa-square fa-stack-2x" ></i>
										<i style="background-color: red;" class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
									</span>
								</a>
							</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php



    include($tmpl .'footer.php') ; //<!-- footer -->

// }


// //Redirect to login
// else{echo"You are to authzied to enter this page";
// header('location:index.php'); 
// }
?>
