<?php
/**
 * Template Name: Home
 */

get_header(); 

$home_meta = get_post_meta( $post->ID );
?>

    <?php 
        $args = array(
            'post_type' => 'home_slider', 
            'posts_per_page' => $home_meta['sp_slide_num'][0],
            'post_status' => 'publish'
        );
        $custom_query = new WP_Query( $args );
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($){
        $("#featured-slideshow").flexslider({
            animation: "slide",
            pauseOnHover: true
        });
    });     
    </script>
    <section id="featured-slideshow" class="flexslider">
        <ul class="slides">
    <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>    
        <li>
        <?php 
        $img_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); 
        $slide_link = (get_post_meta( $post->ID, 'sp_slide_btn_url', true ) == '') ? '#' : get_post_meta( $post->ID, 'sp_slide_btn_url', true );
        ?>
            <img src="<?php echo $img_url[0]; ?>">
            <figcaption class="flex-caption">
                <h3><a href="<?php echo $slide_link; ?>"><?php the_title(); ?></a></h3>
                <p><?php echo get_post_meta( $post->ID, 'sp_slide_desc', true ); ?></p>
                <a class="btn" href="<?php echo $slide_link; ?>">
                    <?php echo get_post_meta( $post->ID, 'sp_slide_btn_name', true ); ?>
                </a>
            </figcaption>
        </li>
    <?php endwhile; wp_reset_postdata(); ?>    
        </ul>
    </section> <!-- #featured-slideshow -->

    <section id="main-services">
        <div class="container clearfix">
            <h4 class="section-title"><?php echo $home_meta['sp_service_title'][0]; ?></h4>
            <p class="section-desc"><?php echo $home_meta['sp_service_desc'][0]; ?></p>
        
            <script type="text/javascript">
            jQuery(document).ready(function($){
                $(".services-carousel").flexslider({
                    animation: "slide",
                    controlNav: false,
                    itemWidth: 295,
                    itemMargin: 20,
                    initDelay:3000
                });
            });     
            </script>
            <?php
            $args = array(
                'post_type'        => 'service',
                'posts_per_page'   => $home_meta['sp_service_num'][0], 
                'post_status'      => 'publish'
                );
            $custom_query = new WP_Query( $args );

            $out = '<div class="services-carousel flexslider">';
            $out .= '<ul class="slides">';
            
            while ( $custom_query->have_posts() ) : $custom_query->the_post();
            
                $out .= '<li>';
                $out .= '<div class="loan-item">';
                if ( has_post_thumbnail() ) :
                    $out .= '<a href="' . get_the_permalink() . '">' . get_the_post_thumbnail($post->ID, 'thumb-medium') . '</a>'; 
                else : 
                    $out .= '<img src="' . SP_ASSETS_THEME .'images/placeholder/thumb-medium.png">';   
                endif;
                $out .= '<h5><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h5>';
                $out .= '<p>' . get_the_excerpt() . '</p>';
                $out .= '<div class="feature-loan clearfix">';
                $out .= '<div><span class="left">' . __( 'Loan amount', SP_TEXT_DOMAIN ) . '</span><span class="right">' . get_post_meta( $post->ID, 'sp_loan_amount', true ) . '</span></div>';
                $out .= '<div><span class="left">' . __( 'Period', SP_TEXT_DOMAIN ) . '</span><span class="right">' . get_post_meta( $post->ID, 'sp_loan_period', true ) . '</span></div>';
                $out .= '<div><span class="left">' . __( 'Rate', SP_TEXT_DOMAIN ) . '</span><span class="right">' . get_post_meta( $post->ID, 'sp_loan_rate', true ) . '</span></div>';
                $out .= '</div>';
                $out .= '<a class="btn" href="' . get_the_permalink() . '">' . __( 'Learn more', SP_TEXT_DOMAIN ) .'</a>';
                $out .= '</div>';
                $out .= '</li>';

            endwhile;
            wp_reset_postdata(); 
            
            $out .= '</ul>';

            echo $out;
            ?>     
        </div> <!-- .container .clearfix -->
    </section> <!-- #services-carousel -->
    <?php if ( !empty($home_meta['sp_process_bg'][0]) ) : ?>
        <style type="text/css">
        #loan-process { background:url(<?php echo $home_meta['sp_process_bg'][0]; ?>);}
        </style>
    <?php endif; ?>
    <section id="loan-process">
        <div class="container clearfix">
            <h4 class="section-title"><?php echo $home_meta['sp_process_title'][0]; ?></h4>
            <p class="section-desc"><?php echo $home_meta['sp_process_desc'][0]; ?></p>
            <div class="one-third">
                <div class="step-num"><img src="<?php echo SP_ASSETS_THEME; ?>images/process-step-1.png"></div>
                <h5 class="step-title"><?php echo $home_meta['sp_process_step_1'][0]; ?></h5>
                <p><?php echo $home_meta['sp_process_txt_1'][0]; ?></p>
            </div>
             <div class="one-third">
                <div class="step-num"><img src="<?php echo SP_ASSETS_THEME; ?>images/process-step-2.png"></div>
                <h5 class="step-title"><?php echo $home_meta['sp_process_step_2'][0]; ?></h5>
                <p><?php echo $home_meta['sp_process_txt_2'][0]; ?></p>
            </div>
             <div class="one-third last">
                <div class="step-num"><img src="<?php echo SP_ASSETS_THEME; ?>images/process-step-3.png"></div>
                <h5 class="step-title"><?php echo $home_meta['sp_process_step_3'][0]; ?></h5>
                <p><?php echo $home_meta['sp_process_txt_3'][0]; ?></p>
            </div>
        </div>
    </section> <!-- loan-process -->

	<section id="customers">
        <div class="container clearfix">
            <div class="two-fourth">
                <h4 class="section-title"><?php echo $home_meta['sp_faq_title'][0]; ?></h4>
                <div class="accordion small one clearfix" data-opened="0">
                <?php 
                $out = '';
                $args = array(
                    'post_type' => 'faq',
                    'post_status' => 'publish',
                    'posts_per_page' => $home_meta['sp_faq_num'][0],
                    );
                $custom_query = new WP_Query( $args );

                while ( $custom_query->have_posts() ) : $custom_query->the_post();
                    
                    $content = get_the_content();
                    $content = apply_filters( 'the_content', get_the_content() );
                    $content = str_replace( ']]>', ']]&gt;', $content );

                    $out .= '<section>';
                    $out .= '<h4>' . get_the_title() . '</h4>';
                    $out .= '<div>' . $content . '</div>';
                    $out .= '</section>';
                endwhile;
                wp_reset_postdata(); 

                echo $out;
                ?>
                </div> <!-- accordion -->
                <?php echo $home_meta['sp_faq_page_id'][0]; ?>
                <a class="learn-more" href="<?php echo get_page_link($home_meta['sp_faq_page_id'][0]); ?>"><?php _e( 'See all FAQs', SP_TEXT_DOMAIN ); ?></a>
            </div>
            <div class="two-fourth last">
                <h4 class="section-title"><?php echo $home_meta['sp_client_title'][0]; ?></h4>
                <?php 
                $out = '';
                $args = array(
                    'post_type' => 'client',
                    'post_status' => 'publish',
                    'posts_per_page' => 1,
                    );
                $custom_query = new WP_Query( $args );

                while ( $custom_query->have_posts() ) : $custom_query->the_post();

                    $testimonial_photo = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'large');
                    $testimonial_text = get_the_content();
                    $testimonial_cite = get_post_meta(get_the_ID(), 'sp_testimonial_cite', true);
                    $testimonial_cite_subtext = get_post_meta(get_the_ID(), 'sp_testimonial_cite_subtext', true);

                    $out .= '<figure class="testimonial light">';
                    $out .= '<blockquote>';
                    $out .= $testimonial_text;
                    $out .= '</blockquote>';
                    if ( has_post_thumbnail() ) :
                        $out .= '<a href="' . $testimonial_photo[0] . '">' . get_the_post_thumbnail(get_the_ID(), 'thumbnail') . '</a>';
                    else :
                        $out .= '<img class="wp-image-placeholder" src="' . SP_ASSETS_THEME .'images/placeholder/people-placeholder.jpg">'; 
                    endif;
                    $out .= '<figcaption>';
                    $out .= '<p>' . get_the_title() . '</p>';
                    $out .= '<span>' . do_shortcode($testimonial_cite) . '</span>';
                    if ( $testimonial_cite_subtext )
                        $out .= '<span>' . do_shortcode($testimonial_cite_subtext) . '</span>';
                    $out .= '</figcaption>';
                    $out .= '</figure>';
                
                endwhile;
                wp_reset_postdata(); 

                echo $out;
                ?>
                <a class="learn-more" href="<?php echo get_page_link($home_meta['sp_client_page_id'][0]); ?>"><?php _e( 'All Clients Success Business', SP_TEXT_DOMAIN ); ?></a>
            </div>
        </div>   
    </section> <!-- #customers -->
<?php get_footer(); ?>