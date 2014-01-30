<?php foreach ($images as $image) : ?>
<?php if(strpos($image, 'uploads/small_thumbnail/') === 0) : ?>
<a href="images/<?php echo basename($image); ?>"><img src="<?php echo $image; ?>"></a>
<?php else : ?>
<img src="<?php echo $images[0]; ?>">
<?php endif; ?>
<?php endforeach;?>