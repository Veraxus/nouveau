<?php

class MarkupGenTest extends WP_UnitTestCase {
	
	function test_markupgen_div() {
		$arr1 = array(
			'tag'     => 'div',
			'content' => 'This is content',
			'atts'    => array( 'class' => array( 'class1', 'class2' ) ),
			'solo'    => false,
		);
		
		$str1 = '<div class="class1 class2">This is content</div>';
		
		$mkup1 = \NV\Theme\Utilities\MarkupGenerator::gen_array( $arr1 );
		
		$this->assertEquals( $str1, $mkup1 );
		
	}

	function test_markupgen_img() {
		$arr2 = array(
			'tag'     => 'img',
			'content' => null,
			'atts'    => array( 'src' => 'img.png', 'alt' => 'Description' ),
			'solo'    => true,
		);

		$str2 = '<img src="img.png" alt="Description" />';

		$mkup2 = \NV\Theme\Utilities\MarkupGenerator::gen_array( $arr2 );

		$this->assertEquals( $str2, $mkup2 );
	}

	function test_markupgen_recurse() {
		$arr2 = array(
			'tag'     => 'img',
			'content' => null,
			'atts'    => array( 'src' => 'img.png', 'alt' => 'Description' ),
			'solo'    => true,
		);
		$arr3 = array(
			'tag'     => 'div',
			'content' => $arr2,
			'atts'    => array( 'class' => array( 'class1', 'class2' ) ),
			'solo'    => false,
		);

		$str2 = '<img src="img.png" alt="Description" />';
		$str3 = '<div class="class1 class2">' . $str2 . '</div>';

		$mkup3 = \NV\Theme\Utilities\MarkupGenerator::gen_array( $arr3 );

		$this->assertEquals( $str3, $mkup3 );
	}
	
}

