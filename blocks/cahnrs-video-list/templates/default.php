<div class="<?php echo esc_attr( $attrs['className']); ?>">
	
		<?php 
			$counter = 1;
			foreach($video_items as $video_item){
				

				$video_id = $video_item['id'];

				$video_urls = get_post_meta($video_id,'_video_id');
			
				 ?>
			<div class="individual-video" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $counter; ?>">
				<div class="video-image-container">

					<div class="video-image">
						<?php echo get_the_post_thumbnail( $video_id, 'video-thumb' ); ?>
					</div>
				</div>
				

				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $counter; ?>">
					<?php echo wp_kses_post( $video_item['title'] ); ?>
				</button>

				<!-- Modal -->
				<div class="modal fade" id="exampleModal-<?php echo $counter; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">

						<iframe src="<?php echo $video_urls[0]; ?>" name="<?php echo $video_item['title']; ?>" frameborder="0" width="900" height="700"></iframe>

					</div>
				</div>
				</div>

				<?php if ( empty( $attrs['hideCaption'] ) && ! empty( $video_item['caption'] ) ) { ?>
					
					<?php
						echo "<p>". wp_kses_post( wp_strip_all_tags( $video_item['caption'] ) ) . "</p>";
				} 
				?>
				<?php //if ( empty( $attrs['hideDate'] ) && ! empty( $video_item['date'] ) ) { ?>
					<!-- <div class="wsu-meta-date"><time><?php //echo wp_kses_post( $video_item['date'] ); ?></time></div> -->
				<?php //} //End If ?>
			</div> <!-- .individual-video -->
			<?php
		
		
	
			
$counter ++;
	
		} //End Foreach
		?>
</div>





