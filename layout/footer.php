        <footer id="footer" class="row">

            <nav id="nav-mobile" role="navigation" class="show-for-small">
                <?php  wp_nav_menu(array('theme_location'=>'mobile')); ?>
            </nav>

            <div id="copyright">
                <?php
                    printf(__( 'Copyright &copy; %s %s. All Rights Reserved.', 'nvLangScope' ),
                        date('Y'),
                        get_bloginfo('name')
                    );
                ?>
            </div>

        </footer>

        <!-- start wp_footer() hooks -->
        <?php wp_footer(); ?>
        <!-- end wp_footer() hooks -->

    </div>
    <!-- /#frame -->

</body>
</html>