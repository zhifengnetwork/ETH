<?php defined('IN_IA') or exit('Access Denied');?><!-- <div class="subnav-scene">

	<?php  if(empty($sysmenus['submenu']['route']) && !$sysmenus['submenu']['main']) { ?>

		<?php  echo $sysmenus['submenu']['subtitle'];?>

	<?php  } else { ?>

		<a href="<?php  echo webUrl($sysmenus['submenu']['route'])?>"><?php  echo $sysmenus['submenu']['subtitle'];?></a>

	<?php  } ?>

</div> -->



<?php  if(!empty($sysmenus['submenu']['items'])) { ?>

	<?php  if(is_array($sysmenus['submenu']['items'])) { foreach($sysmenus['submenu']['items'] as $submenu) { ?>

		<?php  if(!empty($submenu['items'])) { ?>
			
			<div class='menu-header <?php  if($submenu['active']) { ?>active data-active<?php  } ?>'>
				<div class="menu-icon icon-<?php  if($submenu['active']) { ?>uniE901<?php  } else { ?>1<?php  } ?>"></div>
				<h5><?php  echo $submenu['title'];?></h5>
			</div>
			
			<ul <?php  if($submenu['active']) { ?>style="display: block"<?php  } ?>>

				<?php  if(is_array($submenu['items'])) { foreach($submenu['items'] as $threemenu) { ?>

					<li <?php  if($threemenu['active']) { ?>class="active"<?php  } ?>>
						<a href="<?php  echo $threemenu['url'];?>" style="cursor: pointer;" data-route="<?php  echo $threemenu['route'];?>">
							<?php  echo $threemenu['title'];?>
						</a>
					</li>
				<?php  } } ?>

			</ul>

		<?php  } else { ?>
				
				<div class="menu-header <?php  if($submenu["active"]) { ?>active<?php  } ?>">
					<div class="menu-icon icon-<?php  if($submenu['active']) { ?>uniE901<?php  } else { ?>1<?php  } ?>"></div>
					<h5><?php  echo $submenu['title'];?></h5>
					<!-- <li class="" style=" position: relative"><a href="<?php  echo $submenu['url'];?>" style="cursor: pointer;" data-route="<?php  echo $submenu['route'];?>"><?php  echo $submenu['title'];?></a></li> -->

				</div>
				<ul <?php  if($submenu['active']) { ?>style="display: block"<?php  } ?>>

					<li <?php  if($threemenu['active']) { ?>class="active"<?php  } ?>>
						<a href="<?php  echo $submenu['url'];?>" style="cursor: pointer;"">
							<?php  echo $submenu['title'];?>
						</a>
					</li>

				</ul>
				
		<?php  } ?>

	<?php  } } ?>


<?php  } ?>
