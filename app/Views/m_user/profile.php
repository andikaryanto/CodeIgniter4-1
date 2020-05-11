<div class="content">
        <div class="container-fluid">
            <div class = "row">
                <div class="col-md-8">
                    <!--      Wizard container        -->
                    <div class="wizard-container">
                        <div class="card card-wizard active" data-color="green" id="wizardProfile">
                            <form action="<?= baseUrl('saveprofile')?>" method="post" enctype="multipart/form-data">
                            <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                                <div class="card-header text-center">
                                    <h3 class="card-title">
                                    Build Your Profile
                                    </h3>
                                    <h5 class="card-description">This information will let us know more about you.</h5>
                                </div>
                                <div class="card-body">
                                    <!-- <div class="tab-content"> -->
                                        <div class="tab-pane active" id="about">
                                            <!-- <h5 class="info-text"> Let's start with the basic information (with validation)</h5> -->
                                            <div class="row justify-content-center">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="picture-container">
                                                        <div class="picture">
                                                            <img src="<?= baseUrl($_SESSION['userprofile']['PhotoPath'].$_SESSION['userprofile']['PhotoName'])?>" class="picture-src" id="wizardPicturePreview" title="">
                                                            <input type="file" id="wizard-picture" name = "file" accept="image/x-png,image/jpeg">
                                                        </div>
                                                        <h6 class="description">Choose Picture</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group bmd-form-group">
                                                    <label class="bmd-label-floating"><?= lang('ui_completename')?></label>
                                                    <input type="text" class="form-control" name = "completename" value = "<?= $model->CompleteName?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group bmd-form-group">
                                                    <label class="bmd-label-floating"><?= lang('ui_email')?></label>
                                                    <input type="email" class="form-control" name = "email"  value = "<?= $model->Email?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group bmd-form-group">
                                                    <label class="bmd-label-floating"><?= lang('ui_telephone')?></label>
                                                    <input type="text" class="form-control" name = "phone"  value = "<?= $model->Phone?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group bmd-form-group">
                                                    <label class="bmd-label-floating"><?= lang('ui_address')?></label>
                                                    <textarea type="text" class="form-control" name = "address" rows = "2"><?= $model->Address?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group bmd-form-group">
                                                    <label class="bmd-label-floating"><?= lang('ui_aboutme')?></label>
                                                    <textarea type="text" class="form-control" name = "aboutme" rows = "5"><?= $model->AboutMe?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 text-right">
                                                    <button type = "submit" class = "btn btn-primary"><?= lang('ui_save')?></button>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- </div> -->
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- wizard container -->
                </div>
                <div class="col-md-4">
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <a href="#pablo">
                                <img class="img" src="<?= baseUrl($_SESSION['userprofile']['PhotoPath'].$_SESSION['userprofile']['PhotoName'])?>">
                            </a>
                            </div>
                            <div class="card-body">
                            <h6 class="card-category text-gray"><?= $_SESSION['userdata']['Username']?></h6>
                            <h4 class="card-title"><?= $model->CompleteName?></h4>
                            <p class="card-description">
                                <?= $model->AboutMe?>
                            </p>
                            <a href="#pablo" class="btn btn-primary btn-round">Follow<div class="ripple-container"></div></a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
      </div>