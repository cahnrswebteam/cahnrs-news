
<div class="<?php echo esc_attr( $attrs['className']); ?>">
	
		<?php 
			$counter = 1;
			foreach($video_items as $video_item){
				//Retrieves ID of the custom post type
				$video_id = $video_item['id'];

				//Retrieves the URL of the Youtube Video
				$video_url = get_post_meta($video_id,'_video_id');

				//Strips out everything except the ID of the Youtube Video
				preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_url[0], $match);
			
				$youtube_id = $match[1];
				
				//Creates new YouTube URL to be used for embed
				$youtube_URL_with_id = 'https://www.youtube.com/embed/' . $youtube_id ."?rel=0" ;
		
				 ?>
			<div class="individual-video" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $counter; ?>">
				<div class="video-image-container">

					<div class="video-image">
						<?php echo get_the_post_thumbnail( $video_id, 'video-thumb' ); ?>
					</div>
				</div>
				

				<h2 class="wsu-title">
					<?php echo wp_kses_post( $video_item['title'] ); ?>
				</h2>

				<?php if ( empty( $attrs['hideCaption'] ) && ! empty( $video_item['caption'] ) ) { ?>
					
					<?php
						echo "<p class='wsu-caption'>". wp_kses_post( wp_strip_all_tags( $video_item['caption'] ) ) . "</p>";
				} 
				?>

				<!-- Modal -->
				<div class="modal fade" id="exampleModal-<?php echo $counter; ?>" tabindex="-1" role="dialog" aria-modal="true" aria-describeby="videoTitle">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header" >
								<?php echo  '<p class="sr-only" id="videoTitle">' . wp_kses_post( $video_item['title'] ) . ' video modal.</p>'; ?>

								<button type="button" class="close" data-dismiss="modal" aria-label="Close Modal">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>

							<iframe src="<?php echo $youtube_URL_with_id; ?>" name="<?php echo $video_item['title']; ?>" frameborder="0" width="900" height="700"></iframe>

						</div>
					</div>
				</div>
				<button data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $counter; ?>">
        			<?php echo "View " . wp_kses_post( $video_item['title'] ) . " video."; ?>
    			</button>
			</div> <!-- .individual-video -->
			<?php
			
			//Counter used to give unique ID number to modal. This allows the click functionality for the modal to work correctly. 
			$counter ++;
			
	
		} //End Foreach
		?>

		
</div>





