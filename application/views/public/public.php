<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view('includes/public-head'); ?>

</head>
<body>
<!--Header-->
<?php $this->load->view('includes/public-body-header'); ?>
<!--Content-->
<?php $this->load->view($main_view); ?>
<!--Footer-->
<?php $this->load->view('includes/public-body-footer'); ?>

<!--Script-->
<?php $this->load->view('includes/public-foot'); ?>
</body>
</html>

