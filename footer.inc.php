<?php
if($DisplayMenu)
{
?>

</div>
</div>
        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Company
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Portfolio
                            </a>
                        </li>
                        <li>
                            <a href="#">
                               Blog
                            </a>
                        </li>
                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; 2016 <a href="http://www.creative-tim.com/">Creative Tim</a>, made with love for a better web
                </p>
            </div>
        </footer>

    </div>
</div>


    <div class="fixed-plugin">
    <div class="dropdown show-dropdown">
        <a href="#" data-toggle="dropdown">
        <i class="fa fa-cog fa-2x"> </i>
        </a>
        <ul class="dropdown-menu">
            <li class="header-title">Configuration</li>
            <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger">
                    <p>Sidebar Image</p>
                    <div class="switch switch-sidebar-image"
                        data-on-label="ON"
                        data-off-label="OFF">
                        <input type="checkbox" checked/>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger">
                    <p>Sidebar Mini</p>
                    <div class="switch  switch-sidebar-mini"
                        data-on-label="ON"
                        data-off-label="OFF">
                        <input type="checkbox"/>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger">
                    <p>Fixed Navbar</p>
                    <div class="switch  switch-navbar-fixed"
                        data-on-label="ON"
                        data-off-label="OFF">
                        <input type="checkbox"/>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger">
                    <p>Filters</p>
                    <div class="pull-right">
                        <span class="badge filter" data-color="black"></span>
                        <span class="badge filter badge-azure" data-color="azure"></span>
                        <span class="badge filter badge-green" data-color="green"></span>
                        <span class="badge filter badge-orange active" data-color="orange"></span>
                        <span class="badge filter badge-red" data-color="red"></span>
                        <span class="badge filter badge-purple" data-color="purple"></span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="header-title">Sidebar Images</li>
            <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="assets/img/full-screen-image-1.jpg">
                </a>
            </li>
            <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="assets/img/full-screen-image-2.jpg">
                </a>
            </li>
            <li class="active">
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="assets/img/full-screen-image-3.jpg">
                </a>
            </li>
            <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="assets/img/full-screen-image-4.jpg">
                </a>
            </li>

            <li class="button-container">
                <div class="">
                    <a href="http://www.creative-tim.com/product/light-bootstrap-dashboard" target="_blank" class="btn btn-info btn-block">Get Free Demo</a>
                </div>
                <div class="">
                    <a href="http://www.creative-tim.com/product/light-bootstrap-dashboard-pro" target="_blank" class="btn btn-info btn-block btn-fill">Buy Now!</a>
                </div>
            </li>

            <li class="header-title">Thank you for 452 shares!</li>

            <li class="button-container">
                <button id="twitter" class="btn btn-social btn-twitter btn-round"><i class="fa fa-twitter"></i> &middot; 182</button>
                <button id="facebook" class="btn btn-social btn-facebook btn-round"><i class="fa fa-facebook-square"> &middot; 270</i></button>
            </li>

        </ul>
    </div>
</div>
<?php 
}
?>
</body>

<!--  Forms Validations Plugin -->
<script src="<?php echo $URL ?>assets/js/jquery.validate.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?php echo $URL ?>assets/js/moment.min.js"></script>
<!--  Date Time Picker Plugin is included in this js file -->
<script src="<?php echo $URL ?>assets/js/bootstrap-datetimepicker.js"></script>
<!--  Select Picker Plugin -->
<script src="<?php echo $URL ?>assets/js/bootstrap-selectpicker.js"></script>
<!--  Checkbox, Radio, Switch and Tags Input Plugins -->
<script src="<?php echo $URL ?>assets/js/bootstrap-checkbox-radio-switch-tags.js"></script>
<!--  Charts Plugin -->
<script src="<?php echo $URL ?>assets/js/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="<?php echo $URL ?>assets/js/bootstrap-notify.js"></script>
<!-- Sweet Alert 2 plugin -->
<script src="<?php echo $URL ?>assets/js/sweetalert2.js"></script>
<!-- Vector Map plugin -->
<script src="<?php echo $URL ?>assets/js/jquery-jvectormap.js"></script>
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js"></script>
<!-- Wizard Plugin    -->
<script src="<?php echo $URL ?>assets/js/jquery.bootstrap.wizard.min.js"></script>
<!--  Bootstrap Table Plugin    -->
<script src="<?php echo $URL ?>assets/js/bootstrap-table.js"></script>
<!--  Plugin for DataTables.net  -->
<script src="<?php echo $URL ?>assets/js/jquery.datatables.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?php echo $URL ?>assets/js/fullcalendar.min.js"></script>
<!-- Light Bootstrap Dashboard Core javascript and methods -->
<script src="<?php echo $URL ?>assets/js/light-bootstrap-dashboard.js"></script>
<!--   Sharrre Library    -->
<script src="<?php echo $URL ?>assets/js/jquery.sharrre.js"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo $URL ?>assets/js/demo.js"></script>

</html>