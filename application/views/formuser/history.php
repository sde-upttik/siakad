<div class="ks-column ks-page">
        <div class="ks-header">
            <section class="ks-title">
                <h3>Customer Profile</h3>
            </section>
        </div>

        <div class="ks-content">
            <div class="ks-body ks-profile">
                <div class="ks-header">
                    <div class="ks-user">
                        <img src="<?php echo base_url();?>FScript/assets/img/avatars/avatar-14.jpg" class="ks-avatar" width="100" height="100">
                        <div class="ks-info">
                            <div class="ks-name"><?=$detail->Name?></div>
                            <div class="ks-description"><?=$detail->NIM." - ".$detail->Description?></div>
                            <!--<div class="ks-rating">
                                <i class="fa fa-star ks-star" aria-hidden="true"></i>
                                <i class="fa fa-star ks-star" aria-hidden="true"></i>
                                <i class="fa fa-star ks-star" aria-hidden="true"></i>
                                <i class="fa fa-star ks-star" aria-hidden="true"></i>
                                <i class="fa fa-star-half-o ks-star" aria-hidden="true"></i>
                            </div>-->
                        </div>
                    </div>
                    <div class="ks-statistics">
                        <div class="ks-item">
                            <div class="ks-amount">869</div>
                            <div class="ks-text">orders</div>
                        </div>
                        <div class="ks-item">
                            <div class="ks-amount">131</div>
                            <div class="ks-text">reviews</div>
                        </div>
                        <div class="ks-item">
                            <div class="ks-amount">$3,004</div>
                            <div class="ks-text">rewand points</div>
                        </div>
                    </div>
                </div>
                <div class="ks-tabs-container ks-tabs-default ks-tabs-no-separator ks-full ks-light">
                    <ul class="nav ks-nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" data-toggle="tab" data-target="#overview" aria-expanded="true">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="tab" data-target="#contacts" aria-expanded="false">Contacts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="tab" data-target="#orders" aria-expanded="false">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="tab" data-target="#wish-list" aria-expanded="false">Wish list</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="tab" data-target="#storecredit" aria-expanded="false">Store credit</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="tab" data-target="#returns" aria-expanded="false">Returns</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="tab" data-target="#reward-points" aria-expanded="false">Reward points</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="tab" data-target="#settings" aria-expanded="false">Settings</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="overview" role="tabpanel" aria-expanded="false">
                            <div class="ks-overview-tab">
                                <div class="row">
                                    <div class="col-xl-9 ks-tables-container">
                                        <div class="card panel panel-default ks-information ks-light">
                                            <h5 class="card-header">
                                                <span class="ks-text">Daftar No.Registasi</span>
                                                <a href="#" class="btn btn-primary-outline ks-light">New Product</a>
                                            </h5>
                                            <div class="card-block ks-datatable">
                                                <table id="ks-sales-datatable" class="table table-bordered" style="width:100%" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>NIM</th>
                                                        <th>Form Name</th>
                                                        <th>Token</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
												
													<?php 
													for ($i=1; $i<=16; $i++){
														echo "<tr>
                                                        <td>
                                                            <a href='#'>".$detail->Name."</a>
                                                        </td>
                                                        <td>".$detail->NIM."</td>
                                                        <td>
                                                            <div class='ks-user'>
                                                                <!--<img class='ks-avatar' src='assets/img/avatars/ava-3.png' width='24' height='24'>-->
                                                                <span class='ks-name'>Form $i</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class='badge ks-circle badge-info'>".md5($detail->Name.$detail->NIM.$i)."</span>
                                                        </td>
                                                    </tr>";
													}
													?>
												
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="card panel panel-default ks-information ks-light">
                                            <h5 class="card-header">
                                                <span class="ks-text">Contact Info</span>
                                                <a href="#" class="btn btn-primary-outline ks-light ks-no-text"><span class="fa fa-pencil ks-icon"></span></a>
                                            </h5>
                                            <div class="card-block">
                                                <table class="ks-table-description">
                                                    <tr>
                                                        <td class="ks-icon">
                                                            <span class="fa fa-map-marker"></span>
                                                        </td>
                                                        <td class="ks-text">
                                                            <?=$detail->nmf?>
                                                        </td>
                                                    </tr>
													<tr>
                                                        <td class="ks-icon ks-fs-15">
                                                            <span class="fa fa-globe"></span>
                                                        </td>
                                                        <td class="ks-text">
                                                            <a href="#"><?=$detail->nmj?></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ks-icon ks-fs-16">
                                                            <span class="fa fa-phone"></span>
                                                        </td>
                                                        <td class="ks-text">
                                                            <?=$detail->Alamat1?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ks-icon">
                                                            <span class="fa fa-mobile-phone"></span>
                                                        </td>
                                                        <td class="ks-text">
                                                            <?=$detail->Phone?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="ks-icon ks-fs-14">
                                                            <span class="fa fa-envelope"></span>
                                                        </td>
                                                        <td class="ks-text">
                                                            <a href="#"><?=$detail->Email?></a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="contacts" role="tabpanel" aria-expanded="false">
                            Content 2
                        </div>
                        <div class="tab-pane" id="orders" role="tabpanel" aria-expanded="true">
                            Content 3
                        </div>
                        <div class="tab-pane" id="wish-list" role="tabpanel" aria-expanded="false">
                            Content 1
                        </div>
                        <div class="tab-pane" id="storecredit" role="tabpanel" aria-expanded="false">
                            Content 2
                        </div>
                        <div class="tab-pane" id="returns" role="tabpanel" aria-expanded="true">
                            Content 3
                        </div>
                        <div class="tab-pane" id="reward-points" role="tabpanel" aria-expanded="false">
                            Content 1
                        </div>
                        <div class="tab-pane" id="settings" role="tabpanel" aria-expanded="false">
                            Content 1
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>