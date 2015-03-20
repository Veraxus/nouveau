<?php
namespace NV;

/**
 * Includes shortcuts to speed up the easy generation of dynamic HTML using the
 * HtmlGen helper class.
 *
 * @since Nouveau 1.0
 */
class Html extends HtmlGen
{

    /**
     * @param $atts An associative array of attributes (such as href)
     * @param string $content
     * @param bool $echo
     *
     * @return string
     */
    public static function a( $href='#', $atts=array(), $content = '', $echo = false )
    {
        $atts   = parent::atts_default(
            array(
                'href' => $href,
            ),
            $atts
        );

        $return = parent::gen( 'a', $atts, $content );
        if ( $echo ) {
            echo $return;
        }
        return $return;
    }

    /**
     * @param array $atts
     * @param string $content
     * @param bool $echo
     *
     * @return string
     */
    public static function div( $atts = array(), $content = '', $echo = false )
    {
        $return = parent::gen( 'div', $atts, $content );
        if ( $echo ) {
            echo $return;
        }
        return $return;
    }

    /**
     * @param string $src
     * @param array $atts
     * @param bool $echo
     *
     * @return string
     */
    public static function img( $src = '', $atts = array(), $echo = false )
    {
        $atts   = parent::atts_default(
            array(
                'src' => ( !empty( $src ) ) ? $src : '',
                'alt' => '',
            ),
            $atts
        );

        $return = parent::gen( 'img', $atts, '', true );
        if ( $echo ) {
            echo $return;
        }
        return $return;
    }

    /**
     * @param string $name
     * @param array $atts
     * @param bool $echo
     *
     * @return string
     */
    public static function input( $name = '', $atts = array(), $echo = false )
    {
        $atts   = parent::atts_default(
            array(
                'id'    => ( !empty( $name ) ) ? $name : parent::randomId(),
                'name'  => ( !empty( $name ) ) ? $name : parent::randomId(),
                'type'  => 'text',
            ),
            $atts
        );

        $return = parent::gen( 'input', $atts );
        if ( $echo ) {
            echo $return;
        }
        return $return;
    }

    /**
     * @param string $name
     * @param array $atts
     * @param bool $echo
     *
     * @return type
     */
    public static function inputText( $name = '', $atts = array(), $echo = false )
    {
        return self::input( $name, $atts, $echo );
    }

    /**
     * @param string $name
     * @param array $atts
     * @param bool $echo
     *
     * @return string
     */
    public static function inputCheckbox( $name = '', $atts = array(), $echo = false )
    {
        $atts   = parent::atts_default(
            array(
                'id'    => ( !empty( $name ) ) ? $name : parent::randomId(),
                'name'  => ( !empty( $name ) ) ? $name : parent::randomId(),
                'type'  => 'checkbox',
            ),
            $atts
        );

        $return = parent::gen( 'input', $atts );
        if ( $echo ) {
            echo $return;
        }
        return $return;
    }

    /**
     * @param string $name
     * @param array $atts
     * @param bool $echo
     *
     * @return string
     */
    public static function inputRadio( $name = '', $atts = array(), $echo = false )
    {
        $atts   = parent::atts_default(
            array(
                'id'    => ( !empty( $name ) ) ? $name : parent::randomId(),
                'name'  => ( !empty( $name ) ) ? $name : parent::randomId(),
                'type'  => 'radio',
            ),
            $atts
        );

        $return = parent::gen( 'input', $atts );
        if ( $echo ) {
            echo $return;
        }
        return $return;
    }

    /**
     * @param string $for
     * @param array $atts
     * @param bool $echo
     *
     * @return string
     */
    public static function label( $for = '', $atts = array(), $echo = false )
    {
        $atts   = parent::atts_default(
            array(
                'for' => ( !empty( $for ) ) ? $for : '',
            ),
            $atts
        );

        $return = parent::gen( 'label', $atts );
        if ( $echo ) {
            echo $return;
        }
        return $return;
    }

}