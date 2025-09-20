<?php $pagetitle = "Upload new profile picture"; ?>
<?php require_once('../loaders/header.php'); ?>
<body onload='pageObj = new CurrentPage([], ""); updateCssSize();'>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<?php 
require_once('../php_classes/file_class.php');
?>

<article>
    <form method="post" action="../php_requests/update_pfp.php" enctype="multipart/form-data">
        <p>Your current profile picture:</p>
        <div>
            <?php
                $account_id = $_SESSION['account_id'];
                $params = array(
                    'account_id'=>$account_id,
                    'file_use'=>"pfp"
                );
                $pfp_file = new UserFile($params);
                $result = $pfp_file->loadFile();
                if($result){
                    ?><img class="pfp" src="<?php echo $pfp_file->getUrl(); ?>"><?php
                }
                else{
                    //print_r($pfp_file);
                }
            ?>
        </div>
        <p>Profile pictures must be square</p>
        <input hidden type="file" id="imageSubmission" name="imageSubmission[]" accept="image/jpeg, application/pdf" class="form_input"><br>           
        <label class="gen_button" for="imageSubmission">Choose image</label>
        <button class="gen_button floatright">Upload</button>
    </form>
    <div>

</article>

<?php require_once('../loaders/main_bottom.php'); ?>
</body>
</html>