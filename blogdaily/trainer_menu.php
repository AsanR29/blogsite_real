<?php $pagetitle = '
    <div id="createprompt" class="textcenter">
        <a class="titlesize notalink" href="../blogdaily/create_trainer.php">Create a Trainer</a>
    </div>'; ?>
<?php require_once('../loaders/header.php'); ?>
<?php
    if(isset($_SESSION['username']) && $_SESSION['username']){
        $username = $_SESSION['username'];
    }
    else{
        header('location: ../blogdaily/search.php');
    }
?>
<body onload='
    pageObj = new CurrentPage([], "../loaders/load_trainers.php");
    createLoadable("../loaders/load_trainers.php", "trainer_section", "<?php echo $username; ?>", 0);
    updateCssSize();'>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<article>
    <?php require_once('../loaders/nav_middle.php'); ?>
    <div id="trainer_section">
    </div>
</article>

<?php require_once('../loaders/main_bottom.php'); ?>
</body>
</html>