
<?php


    $video_url = get_post_custom_values( '_video_id' );

    echo '<pre>';
//print_r(get_post_custom($post_id));
echo '</pre>';

        ?>
<div class="individual-video" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $counter; ?>" role="button" tabindex="0">
    <div class="video-image-container">

        <div class="video-image">
            <?php echo get_the_post_thumbnail( $video_id, 'video-thumb' ); ?>
        </div>
    </div>
    

    <h2 class="wsu-title">
        <?php echo wp_kses_post( get_the_title() ); ?>
    </h2>

    <?php
        echo "<p class='wsu-caption'>". wp_kses_post( wp_strip_all_tags( get_the_excerpt() ) ) . "</p>";
    ?>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal-<?php echo $counter; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <iframe src="<?php echo $video_url[0]; ?>" name="<?php echo $video_item['title']; ?>" frameborder="0" width="900" height="700"></iframe>

        </div>
    </div>
    </div>
        
        
    <?php //if ( empty( $attrs['hideDate'] ) && ! empty( $video_item['date'] ) ) { ?>
        <!-- <div class="wsu-meta-date"><time><?php //echo wp_kses_post( $video_item['date'] ); ?></time></div> -->
    <?php //} //End If ?>
</div> <!-- .individual-video -->

