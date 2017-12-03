<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/reset.css">
	<link rel="stylesheet/less" type="text/css" href="assets/less/styles.less">
	<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<style>
.kv-avatar .krajee-default.file-preview-frame,.kv-avatar .krajee-default.file-preview-frame:hover {
    margin: 0;
    padding: 0;
    border: none;
    box-shadow: none;
    text-align: center;
}
.kv-avatar {
    display: inline-block;
}
.kv-avatar .file-input {
    display: table-cell;
    width: 213px;
}
.kv-reqd {
    color: red;
    font-family: monospace;
    font-weight: normal;
}
</style>

</head>
<body>
	<!-- markup -->
<!-- note: your server code `avatar_upload.php` will receive `$_FILES['avatar']` on form submission -->
<!-- the avatar markup -->
<form class="form form-vertical" action="/avatar_upload.php" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-4 text-center">
            <div class="kv-avatar">
                <div class="file-loading">
                    <input id="avatar-1" name="avatar-1" type="file" required>
                </div>
            </div>
            <div class="kv-avatar-hint"><small>Select file < 1500 KB</small></div>
        </div>
        <div class="col-sm-8">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="email">Email Address<span class="kv-reqd">*</span></label>
                <input type="email" class="form-control" name="email" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="pwd">Password<span class="kv-reqd">*</span></label>
                <input type="password" class="form-control" name="pwd" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" name="fname" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" name="lname" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <hr>
            <div class="text-right"> 
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </div>
    </div>
</form>
<div id="kv-avatar-errors-1" class="center-block" style="width:800px;display:none"></div>
<!-- the fileinput plugin initialization -->

<script>less = { env: 'development'};</script>
<script src="assets/js/less.js"></script>
<script>less.watch();</script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/animated.js"></script>
<script src="assets/js/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript" src="assets/js/main.js"></script>
<script src="assets/js/angular.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/js/back-to-top.js"></script>
<script src="assets/controller/SkillsController.js"></script>

<script>
var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
    'onclick="alert(\'Call your custom code here.\')">' +
    '<i class="glyphicon glyphicon-tag"></i>' +
    '</button>'; 
$("#avatar-1").fileinput({
    overwriteInitial: true,
    maxFileSize: 1500,
    showClose: false,
    showCaption: false,
    browseLabel: '',
    removeLabel: '',
    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
    removeTitle: 'Cancel or reset changes',
    elErrorContainer: '#kv-avatar-errors-1',
    msgErrorClass: 'alert alert-block alert-danger',
    defaultPreviewContent: '<img src="/uploads/avatar/default.jpg" alt="Your Avatar">',
    layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
    allowedFileExtensions: ["jpg", "png", "gif"]
});
</script>
</body>
</html>