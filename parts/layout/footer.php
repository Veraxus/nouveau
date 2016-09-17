	<footer id="footer" class="row">
	
		<div id="copyright">
			<?php
			printf(
				__( 'Copyright &copy; %s %s. All Rights Reserved.', 'nvLangScope' ),
				date( 'Y' ),
				get_bloginfo( 'name' )
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