<div class="cahnrs-video-wrapper">
    <iframe width="560" height="315" src="<?php echo esc_url( $video_url ); ?>?rel=0" frameborder="0" allowfullscreen></iframe>
    <p><?php echo wp_kses_post( $post->post_excerpt ); ?></p>
</div>