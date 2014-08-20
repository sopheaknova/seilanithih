 
    <?php if ( is_active_sidebar('footer-sidebar') ): ?>
    <aside class="footer-widgets">
        <div class="container clearfix">
            <?php dynamic_sidebar('footer-sidebar'); ?> 
        </div> <!-- .container .clearfix -->
    </aside>
    <?php endif; ?>
    
    <footer id="footer" class="clearfix">

        <div class="footer-1 clearfix">
            <?php if ( ot_get_option( 'footer-logo' ) ): ?>
                <img class="footer-logo" src="<?php echo ot_get_option( 'footer-logo' ); ?>" />
            <?php else : ?>
                <img class="footer-logo" src="<?php echo SP_BASE_URL; ?>assets/images/footer-logo.png" />
            <?php endif; ?>
            <div class="join-icons"><?php echo sp_show_social_icons(); ?></div>
        </div> <!-- .footer-1 -->    
        
        <div class="footer-2 clearfix">
        	<nav id="footer-nav" class="clearfix">
            	<?php echo sp_footer_navigation(); ?>
        	</nav>
            <div class="copyright">
                <?php if ( ot_get_option( 'copyright' ) ): ?>
                    <p><?php echo ot_get_option( 'copyright' ); ?></p>
                <?php else: ?>
                    <p><?php bloginfo(); ?> &copy; <?php echo date( 'Y' ); ?>. <?php _e( 'All Rights Reserved.', SP_TEXT_DOMAIN ); ?></p>
                <?php endif; ?>
            </div><!--/#copyright-->
        </div> <!-- .footer-2 -->
        
        <?php if ( ot_get_option( 'credit' ) != 'off' ): ?>
        <p class="credit"><?php echo ot_get_option( 'credit-text' ); ?></p><!--/#credit-->
        <?php endif; ?><!--/#credit-->
        
    </footer><!-- #footer -->

    </div> <!-- #content-container -->
</div> <!-- #wrapper -->

<?php wp_footer(); ?>

</body>
</html>