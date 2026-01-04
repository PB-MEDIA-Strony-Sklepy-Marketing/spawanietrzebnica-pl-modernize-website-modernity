<?php
namespace Joomunited\WPSOLADDON;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class ImageDimensions
 */
class ImageDimensions
{
    /**
     * ImageDimensions constructor.
     */
    public function __construct()
    {
        $advanced_option = get_option('wpsol_advanced_settings');
        if (!is_admin()) {
            // Filter image dimensions
            if (isset($advanced_option['image_dimensions']) && $advanced_option['image_dimensions']) {
                add_filter('wpsol_addon_sol_specify_image_dimensions', array($this, 'specifyImageDimensions'), 10, 2);
            }
        }
    }


    /**
     * Specify image dimensions and insert it into images.
     *
     * @param string $content Buffer Page HTML contents.
     *
     * @return string Buffer Page HTML contents after inserting dimentions into images.
     */
    public function specifyImageDimensions($content)
    {
        
        $set_images_regex = '<img(?:[^>](?!(height|width)=[\'\"](?:\S+)[\'\"]))*+>';
        
        preg_match_all('/'.$set_images_regex.'/is', $content, $images_match);
        
        $images_to_replace_array = array();
        
        $images = $images_match[0];
        
        foreach ($images as $image) {
            $image_url = $this->getImageUrl($image); // Get both type of URLs Full or Relative AND also handle layload attribute

            if (empty($image_url)) {
                continue;
            }
            
            $image_url = $this->convertRelativeToFullUrl($image_url);
        
            if ($image_url === false) {
                continue;
            }
            
            $image_extension = strtolower(pathinfo($image_url, PATHINFO_EXTENSION));
            
            if (strtolower($image_extension) === 'svg') {
                $svgfile = simplexml_load_file($image_url);
                if (!empty($svgfile)) {
                    $xmlattributes = $svgfile->attributes();
                    $sizes[3] = 'width="'.$xmlattributes->width.'" height="'.$xmlattributes->height.'"' ;
                }
            } else {
                $sizes = getimagesize($image_url);
            }
            
            if (empty($sizes[3])) {
                continue;
            }
        
            $images_to_replace_array[ $image ] = $this->specifyImageWidthHeight($image, $sizes[3]);
        }
        
        return str_replace(array_keys($images_to_replace_array), $images_to_replace_array, $content);
    }

    /**
     * Check if we can specify image dimensions for one image.
     *
     * @param string $image Full img tag.
     *
     * @return string Get img src attribute.
     */
    public function getImageUrl($image)
    {
         
        preg_match('/\s+data-wpsollazy-src\s*=\s*[\'"](?<url>[^\'"]+)/i', $image, $src_match);

        if (!empty($src_match['url'])) {
            return $src_match['url'];
        }

        preg_match('/\s+src\s*=\s*[\'"](?<url>[^\'"]+)/i', $image, $src_match);
        
        if (!empty($src_match['url'])) {
            return $src_match['url'];
        }
    }

    /**
     * Convert relative url to full url.
     *
     * @param string $image_url Url to be converted.
     *
     * @return string Get converted url otherwise false.
     */
    public function convertRelativeToFullUrl($image_url)
    {
        
        $url_host = wp_parse_url($image_url, PHP_URL_HOST);
        
        if (empty($url_host)) {
            $relative_url        = ltrim(wp_make_link_relative($image_url), '/');
            $image_url = ABSPATH. $relative_url;
            if (!file_exists($image_url)) {
                $image_url = false;
            }
        } else {
            $site_url_components = wp_parse_url(site_url('/'));
            if ($url_host === $site_url_components['host']) { // internal url
                $relative_url        = ltrim(wp_make_link_relative($image_url), '/');
                $image_url = ABSPATH. $relative_url;
                if (!file_exists($image_url)) {
                    $image_url = false;
                }
            }
        }
        
        if (!empty($image_url)) {
            return $image_url;
        } else {
            return false;
        }
    }

    /**
     * Specify the width and height attributes for the img tag.
     *
     * @param string $image      IMG tag.
     * @param string $image_size Width/Height attributes in ready state like [height="100" width="100"].
     *
     * @return string IMG tag after adding attributes otherwise return the input img when error.
     */
    public function specifyImageWidthHeight($image, $image_size)
    {

        $modified_image = preg_replace('/(height|width)=[\'"](?:\S+)*[\'"]/i', '', $image);
        $modified_image = preg_replace('/<\s*img/i', '<img ' . $image_size, $modified_image);

        if ($modified_image === null) {
            return $image;
        }
        
        return $modified_image;
    }
}
