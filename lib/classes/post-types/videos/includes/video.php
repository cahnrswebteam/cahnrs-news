<div class="cahnrs-video-wrapper">
    <iframe title="YouTube Embedded Video" width="560" height="315" src="<?php echo esc_url( $video_url ); ?>?rel=0" frameborder="0" allowfullscreen></iframe>
    <p><?php echo wp_kses_post( $post->post_excerpt ); ?></p>

    <div class="video-transcript">
        <div class="wsu-accordion">
            <h2 id="unique-id-1__title" class="wsu-accordion__title"><button class="wsu-accordion__title-button wsu-accordion--toggle" aria-expanded="false" aria-controls="unique-id-1__content">Transcript</button></h2>
            <div id="unique-id-1__content" class="wsu-accordion__content" aria-labelledby="unique-id-1__title" style="">
                <div class="wsu-accordion__content-inner" tabindex="0">
                    <?php 
                        $video_transcript = get_post_custom_values( '_video_transcript' );
                        echo $video_transcript[0]; 
                    ?>
                </div>
            </div>
        </div>
        
    </div>
</div>