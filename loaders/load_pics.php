
<?php
$file_params = array('blog_id'=>$blog->blog_id);
//echo $blog->blog_id;
$file_array = UserFile::loadFiles($file_params);
//print_r($file_array);
for($i = 0; $i < count($file_array); $i++):
    $sizes = explode('"', getimagesize($file_array[$i]->getUrl())[3]);
    $height = $sizes[3];
    $width = $sizes[1];
?>  
    <div onclick="popupimage('<?php echo $file_array[$i]->getUrl(); ?>')" class="blog_pic" style="background-size: calc(min(100%, <?php echo $width; ?>px)) auto; background-image: url('<?php echo $file_array[$i]->getUrl(); ?>');"></div>
<?php endfor; ?>