<?php
/**
 * @version    3.0.x
 * @package    GridGallery
 * @author     SPEDI srl http://www.spedi.it
 * @copyright  Copyright (c) Spedi srl.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die;

// if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
if (!JComponentHelper::isEnabled('com_phocagallery', true)) {
	return JFactory::getApplication()->enqueueMessage(JText::_('Phoca Gallery is not installed on your system'), 'error');
}
if (! class_exists('PhocaGalleryLoader')) {
    require_once( JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_phocagallery'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'loader.php');
}
phocagalleryimport('phocagallery.path.path');
phocagalleryimport('phocagallery.path.route');
phocagalleryimport('phocagallery.library.library');
// phocagalleryimport('phocagallery.text.text');
// phocagalleryimport('phocagallery.access.access');
// phocagalleryimport('phocagallery.file.file');
// phocagalleryimport('phocagallery.file.filethumbnail');
// phocagalleryimport('phocagallery.image.image');
// phocagalleryimport('phocagallery.image.imagefront');
// phocagalleryimport('phocagallery.render.renderfront');
// phocagalleryimport('phocagallery.render.renderdetailwindow');
// phocagalleryimport('phocagallery.ordering.ordering');
// phocagalleryimport('phocagallery.picasa.picasa');
?>
<?php if($list) : ?>
<section class="gallery-module slide-auto-layout wrapper gid-<?php echo $gal_id ?>">
	<?php if($module->showtitle) : ?>
		<div class="container">
			<div class="row">
				<div class="col-12 title-section">
					<h2><?php echo $module->title ?></h2>
					<?php if($description) : ?>
						<p><?= $description ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="container<?php echo $container ?>">
		<div class="row grid-gallery">
			<!-- Swiper -->
		  <div class="swiper-container">
		    <div class="swiper-wrapper">
					<?php if($shuffle) : ?>
						<?php shuffle($list) ?>
					<?php endif; ?>
					<?php foreach($list as $k => $item) : ?>

						<?php if($k >= $limit) : ?>
							<?php break; ?>
						<?php endif; ?>

						<?php if($magnific) : ?>
							<?php $flink = JUri::base(true)."/images/phocagallery/".$item->filename; ?>
						<?php else: ?>
							<?php $flink = JRoute::_(PhocaGalleryRoute::getCategoryRoute($item->catid, $item->alias)); ?>
						<?php endif; ?>

						<?php $hidden = ''; ?>
						<?php if($k > 10) : ?>
							<?php $hidden = 'd-none'; ?>
						<?php endif; ?>

			      <div class="swiper-slide">
							<a class="magnific-overlay" title="<?php echo $item->title ?>" href="<?php echo $flink ?>">
								<img src="<?php echo JUri::base(true)."/images/phocagallery/".$item->filename; ?>" alt="<?= $item->title ?>" style="height: <?= $height ?>px">
							</a>
						</div>
					<?php endforeach; ?>
		    </div>
		  </div>

			<?php if($linkYN) : ?>
				<div class="col-12 d-flex align-items-center justify-content-center mt-4">
					<p class="mb-0"><a href="<?php echo $link ?>" title="<?php echo $link_text ?>" class="btn btn-primary"><?php echo $link_text ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></a></p>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>

<?php

$document->addScriptDeclaration("
  jQuery(document).ready(function($){

		var swiper = new Swiper('.slide-auto-layout.gid-".$gal_id." .grid-gallery .swiper-container', {
      slidesPerView: 'auto',
      spaceBetween: ".$margin.",
			loop: true,
			// breakpoints: {
      //   576: {
      //     slidesPerView: 1,
      //     spaceBetween: 10,
      //   }
      // }

      // pagination: {
      //   el: '.swiper-pagination',
      //   clickable: true,
      // },
    });


    $('.slide-auto-layout.gid-".$gal_id." .grid-gallery').magnificPopup({
	    delegate:'a.magnific-overlay',
	    type:'image',
	    gallery:{enabled:true}
	  })

  });
");
 ?>
<?php endif; ?>
