<?php
/**
 * The main template file.
 */

global $wp_query;
get_header(); ?>

    <?php 
        $args = array(
            'post_type' => 'home_slider', 
            'posts_per_page' => 5,
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
        <?php $img_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); ?>
            <img src="<?php echo $img_url[0]; ?>">
            <figcaption class="flex-caption">
                <h3><?php the_title(); ?></h3>
                <p><?php echo get_post_meta( $post->ID, 'sp_slide_desc', true ); ?></p>
                <a class="btn" href="#"><?php echo get_post_meta( $post->ID, 'sp_slide_btn_name', true ); ?></a>
            </figcaption>
        </li>
    <?php endwhile; wp_reset_postdata(); ?>    
        </ul>
    </section> <!-- #featured-slideshow -->

    <section id="main-services">
        <div class="container clearfix">
            <h4 class="section-title"><?php _e( 'Explore Our Products and Services', SP_TEXT_DOMAIN ); ?></h4>
            <p class="section-desc"><?php _e( 'Choose your suitable intereste rate for each kind of your business', SP_TEXT_DOMAIN ); ?></p>
        
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
            $out = '';
            $args = array(
                'post_type'        => 'service',
                'posts_per_page'   => -1, 
                'post_status'      => 'publish'
                );
            $custom_query = get_posts($args);
            if ( $custom_query ) {
            $out = '<div class="services-carousel flexslider">';
            $out .= '<ul class="slides">';
            foreach ( $custom_query as $post ) : setup_postdata( $post ); 
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
            endforeach; 
            wp_reset_postdata();
                $out .= '</ul>';
            }
            echo $out;
            ?>     
        </div> <!-- .container .clearfix -->
    </section> <!-- #services-carousel -->

    <section id="loan-process">
        <div class="container clearfix">
            <h4 class="section-title"><?php _e( 'How Seilanithi Work for Your Business', SP_TEXT_DOMAIN ); ?></h4>
            <p class="section-desc"><?php _e( 'Seilanithih can help you in three easy steps', SP_TEXT_DOMAIN ); ?></p>
            <div class="one-third">
                <div class="step-num"><img src="<?php echo SP_ASSETS_THEME; ?>images/process-step-1.png"></div>
                <h5 class="step-title">ANALYSIS YOUR BUSINESS</h5>
                <p>Our Credit officer will orient you regarding our loan and saving product and fill up loan application, submit documents.</p>
            </div>
             <div class="one-third">
                <div class="step-num"><img src="<?php echo SP_ASSETS_THEME; ?>images/process-step-2.png"></div>
                <h5 class="step-title">VERIFY YOUR DOCUMENTS</h5>
                <p>Our Credit officer will check all the documents, conduct home visit and loan appraisal for approval.</p>
            </div>
             <div class="one-third last">
                <div class="step-num"><img src="<?php echo SP_ASSETS_THEME; ?>images/process-step-3.png"></div>
                <h5 class="step-title">LOAN DISBURSEMENT</h5>
                <p>Our Credit officer and accountant/cashier verify all the document (photos, signature, thumb print) to make cash/loan disbursement.</p>
            </div>
        </div>
    </section> <!-- loan-process -->

	<section id="customers">
        <div class="container clearfix">
            <div class="two-fourth">
                <h4 class="section-title"><?php _e( 'FAQ', SP_TEXT_DOMAIN ); ?></h4>
                <div class="accordion small one clearfix" data-opened="0">
                <section>
                    <h4>May I cancel my loan?</h4>
                    <div>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.  Cum sociis natoque penati magnis dis parturient montes.</p>
                    <p>Lid est laborum dolo rumes fugats untras. Etha rums ser quidem rerum facilis dolores nemis onis fugats vitaes nemo minima rerums unsers sadips amets. Ut enim ad minim veniam, quis nostrud Neque porro quisquam est.</p>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.  Cum sociis natoque penati magnis dis parturient montes.</p>
                    </div>
                </section>
                <section>
                    <h4>Who can use products and services of Seilanithih?</h4>
                    <div>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.  Cum sociis natoque penati magnis dis parturient montes.</p>
                    <p>Lid est laborum dolo rumes fugats untras. Etha rums ser quidem rerum facilis dolores nemis onis fugats vitaes nemo minima rerums unsers sadips amets. Ut enim ad minim veniam, quis nostrud Neque porro quisquam est.</p>
                    </div>
                </section>
                <section>
                    <h4>What is SPM mean?</h4>
                    <div>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.  Cum sociis natoque penati magnis dis parturient montes.</p>
                    <p>Lid est laborum dolo rumes fugats untras. Etha rums ser quidem rerum facilis dolores nemis onis fugats vitaes nemo minima rerums unsers sadips amets. Ut enim ad minim veniam, quis nostrud Neque porro quisquam est.</p>
                    </div>
                </section>
                 <section>
                    <h4>How can I be shareholder in Seilanithih Limited?</h4>
                    <div>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.  Cum sociis natoque penati magnis dis parturient montes.</p>
                    <p>Lid est laborum dolo rumes fugats untras. Etha rums ser quidem rerum facilis dolores nemis onis fugats vitaes nemo minima rerums unsers sadips amets. Ut enim ad minim veniam, quis nostrud Neque porro quisquam est.</p>
                    </div>
                </section>
                <section>
                    <h4>Can I clear my loan payment before deadline?</h4>
                    <div>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.  Cum sociis natoque penati magnis dis parturient montes.</p>
                    <p>Lid est laborum dolo rumes fugats untras. Etha rums ser quidem rerum facilis dolores nemis onis fugats vitaes nemo minima rerums unsers sadips amets. Ut enim ad minim veniam, quis nostrud Neque porro quisquam est.</p>
                    </div>
                </section>
                </div> <!-- accordion -->
                <a class="learn-more" href="#"><?php _e( 'See all FAQs', SP_TEXT_DOMAIN ); ?></a>
            </div>
            <div class="two-fourth last">
                <h4 class="section-title"><?php _e( 'Happy Clients', SP_TEXT_DOMAIN ); ?></h4>
                
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
                <a class="learn-more" href="#"><?php _e( 'All Clients Success Business', SP_TEXT_DOMAIN ); ?></a>
            </div>
        </div>   
    </section> <!-- #customers -->
<?php get_footer(); ?>