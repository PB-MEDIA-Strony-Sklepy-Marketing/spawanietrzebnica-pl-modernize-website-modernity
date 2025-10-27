<?php
namespace Joomunited\WPSOLADDON;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class FilterLoading
 */
class FilterLoading
{
    /**
     * Init disallow width params
     *
     * @var integer
     */
    private $disallow_width = 0;
    /**
     * Init disallow height params
     *
     * @var integer
     */
    private $disallow_height = 0;
    /**
     * Init default exclude params
     *
     * @var array
     */
    private $default_exclude = array('wpmfgalleryimg', 'gravatar.com', 'secure.gravatar.com');
    /**
     * FilterLoading constructor.
     */
    public function __construct()
    {
        $advanced_option = get_option('wpsol_advanced_settings');
        if (!is_admin()) {
            if (isset($advanced_option['lazy_loading']) && $advanced_option['lazy_loading']) {
                add_action('wp', array($this, 'runFilterOnFrontend'));
            }

            if (isset($advanced_option['exclude_width_lazyload']) && !empty($advanced_option['exclude_width_lazyload'])) {
                $this->disallow_width = $advanced_option['exclude_width_lazyload'];
            }

            if (isset($advanced_option['exclude_height_lazyload']) && !empty($advanced_option['exclude_height_lazyload'])) {
                $this->disallow_height = $advanced_option['exclude_height_lazyload'];
            }

            // Filter iframe and HTML5 videos lazy loading
            if (isset($advanced_option['iframe_video_lazy_loading']) && $advanced_option['iframe_video_lazy_loading']) {
                add_filter('wpsol_addon_iframe_and_video_lazy_loading', array($this, 'iframeAndVideoLazyLoading'), 10, 2);
                add_action('wp_enqueue_scripts', array($this, 'enqueueIframeVideoScripts'));
            }
        }
    }

    /**
     * Filter image action on front-end
     *
     * @return void
     */
    public function runFilterOnFrontend()
    {
        add_filter('wpsol_addon_image_lazy_loading', array($this, 'filterImageFromContent'), 10, 2);
        add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
    }

    /**
     * Find image from content
     *
     * @param string $content HTML raw
     * @param array  $exclude List custom exclude
     *
     * @return mixed
     */
    public function filterImageFromContent($content, $exclude)
    {
        if (empty($content) || !is_string($content)) {
            return $content;
        }

        // Merge exclude to default exclude
        $this->default_exclude = array_merge($this->default_exclude, $exclude);

        $placeholder_url = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
        //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Check request, not action
        if (isset($_REQUEST['rest_route'])) {
            return $content;
        }

        if (preg_match_all('#<img\s[^>]*?src\s*=\s*[\'\"]([^\'\"]*?)[\'\"][^>]*?>#Usmi', $content, $matches)) {
            //fix conlict with plugin 'hide my WP'
            $rewriteImageUrl = false;
            $hmwp_options = json_decode(get_option('hmwp_options'), true);
            if (is_array($hmwp_options) && isset($hmwp_options['hmwp_upload_url'])) {
                $rewriteImageUrl = '/'.$hmwp_options['hmwp_upload_url'];
            }
            $matches[0] = array_unique($matches[0], SORT_REGULAR);
            foreach ($matches[0] as $imgtag) {
                // Exclude lazyload from something
                if ($this->strposa($imgtag, $this->default_exclude)) {
                    continue;
                }
                if (!preg_match("/src=['\"]data:image/is", $imgtag)) {
                    // Low quality image placeholder
                    preg_match('/src=["|\'](.*?)["|\']/i', $imgtag, $image_match);
                    if (empty($image_match)) {
                        continue;
                    }
                    if (isset($image_match[1])) {
                        $fullLinkImage = $this->getFullLink($image_match[1]);
                        if ($rewriteImageUrl && strpos($fullLinkImage, $rewriteImageUrl) !== false) {
                            $fullLinkImage = str_replace($rewriteImageUrl, '/wp-content/uploads', $fullLinkImage);
                        }
                        // Get size image
                        list($width_img, $height_img) = $this->getOriginalSize($fullLinkImage);

                        $check_size_to_lazyload = $this->checkAllowSizeImages($width_img, $height_img);
                        if (!$check_size_to_lazyload) {
                            continue;
                        }

                        $placeholder_url = $this->resizeImages($fullLinkImage);

                        if (!$placeholder_url) {
                            // If can not resize, get default placeholder
                            $placeholder_url = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
                        }
                    }

                    // replace the src and add the data-src attribute
                    $imgtag_data = preg_replace(
                        '/<img(.*?)src=/is',
                        '<img$1src="'.esc_attr($placeholder_url).'" data-wpsollazy-src=',
                        $imgtag
                    );
                    // replace the srcset
                    $imgtag_data = str_replace('srcset', 'data-wpsollazy-srcset', $imgtag_data);

                    // Add width and height attribute
                    if (!empty($width_img) && !preg_match('/(\s)+width=["|\'](.*?)["|\']/', $imgtag)) {
                        $imgtag_data = preg_replace(
                            '/<img/is',
                            '<img width="'.$width_img.'"',
                            $imgtag_data
                        );
                    }

                    if (!empty($height_img) && !preg_match('/(\s)+height=["|\'](.*?)["|\']/', $imgtag)) {
                        $imgtag_data = preg_replace(
                            '/<img/is',
                            '<img height="'.$height_img.'"',
                            $imgtag_data
                        );
                    }

                    // add the lazy class to the img element
                    if (preg_match('/class=["\']/i', $imgtag_data)) {
                        $imgtag_data = preg_replace(
                            '/class=(["\'])(.*?)["\']/is',
                            'class=$1wpsol-lazy wpsol-lazy-hidden $2$1',
                            $imgtag_data
                        );
                    } else {
                        $imgtag_data = preg_replace(
                            '/<img/is',
                            '<img class="wpsol-lazy wpsol-lazy-hidden"',
                            $imgtag_data
                        );
                    }
                    $noscript = '<noscript>'.$imgtag.'</noscript>';
                    $imgtag_data .= $noscript;

                    // Replace new img tag to old img tag
                    $content = str_replace($imgtag, $imgtag_data, $content);
                }
            }
        }

        return $content;
    }

    /**
     * Get original size of image
     *
     * @param string $link Link of imag
     *
     * @return array
     */
    public function getOriginalSize($link)
    {
        // Get image information
        $image_path_info = pathinfo($link);
        // Get local image
        $local_file = realpath($_SERVER['DOCUMENT_ROOT'] . parse_url($image_path_info['dirname'], PHP_URL_PATH));
        $file_name = '/' . $image_path_info['basename'];

        if (!$local_file || !file_exists($local_file . $file_name)) {
            // If it is an external image, not exist in the server (example : avatar image)
            // Or file was not found
            return null;
        }

        $size = getimagesize($local_file . $file_name);

        if (!$size) {
            return null;
        }

        return $size;
    }

    /**
     * Convert image from original to low quality
     *
     * @param string $img_src Link of image to resize
     *
     * @return string|boolean
     */
    public function resizeImages($img_src)
    {
        // Get image information
        $image_path_info = pathinfo($img_src);
        // Get image parameter
        $source_file = realpath($_SERVER['DOCUMENT_ROOT'] . parse_url($image_path_info['dirname'], PHP_URL_PATH));
        $input_file = '/' . $image_path_info['basename'];
        $output_file = '/small_' . $image_path_info['basename'];

        if (!$source_file || !file_exists($source_file . $input_file)) {
            // If it is an external image, not exist in the server (example : avatar image)
            // Or file was not found
            return false;
        }

        // Execute resize image to low quality
        $resizer = new \Joomunited\WPSOLADDON\ImageResizer(
            $source_file,
            $input_file,
            $source_file,
            $output_file,
            20,
            20,
            '',
            10
        );

        $imageContent = $resizer->output(false, false);
        if ($imageContent) {
            $type = pathinfo($output_file, PATHINFO_EXTENSION);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($imageContent);

            return $base64;
        }

        return false;
    }

    /**
     * Get full link of image
     *
     * @param string $link Link of image
     *
     * @return string
     */
    public function getFullLink($link)
    {
        // Removing query string
        $link = preg_replace('/(\?|\#|\&).*/', '', $link);

        // Determine if the request was over SSL (HTTPS).
        if (is_ssl()) {
            $http = 'https:';
        } else {
            $http = 'http:';
        }

        // Decode link
        if (strpos($link, '%') !== false) {
            $link = urldecode($link);
        }

        // Normalize
        if (strpos($link, '//') === 0) {
            $link = $http . $link;
        }

        // Add 'http://' if none is set
        if (strpos($link, '/') === 0) {
            // Use server http_host.
            $link = $http . '//' . $_SERVER['HTTP_HOST'] . $link;
        } elseif (strpos($link, 'http') === false && strpos($link, 'https') === false) {
            $link = $http . '//' . $link;
        }

        return $link;
    }

    /**
     * Check allow lazy loading for images
     *
     * @param integer $width_img  Width of imag
     * @param integer $height_img Height of imag
     *
     * @return boolean
     */
    public function checkAllowSizeImages($width_img, $height_img)
    {
        if (empty($width_img) && empty($height_img)) {
            return true;
        }

        if (empty($this->disallow_width) && empty($this->disallow_height)) {
            return true;
        }

        if (!empty($this->disallow_width) && empty($this->disallow_height)) {
            if ($width_img < $this->disallow_width) {
                return false;
            }
        }

        if (!empty($this->disallow_height) && empty($this->disallow_width)) {
            if ($height_img < $this->disallow_height) {
                return false;
            }
        }

        if (($width_img < $this->disallow_width) || ($height_img < $this->disallow_height)) {
            return false;
        }

        return true;
    }

    /**
     * Compare string with element of array
     *
     * @param string  $haystack Haystack
     * @param array   $needle   Needle
     * @param integer $offset   Offset
     *
     * @return boolean
     */
    public function strposa($haystack, $needle, $offset = 0)
    {
        if (!is_array($needle)) {
            $needle = array($needle);
        }

        foreach ($needle as $query) {
            if (empty($query)) {
                continue;
            }
            if (strpos($haystack, trim($query), $offset) !== false) {
                return true; // stop on first true result
            }
        }
        return false;
    }

    /**
     * Enqueue lazy load script
     *
     * @return void
     */
    public function enqueueScripts()
    {
        wp_enqueue_script(
            'wpsol-addon-lazy-load',
            plugins_url('assets/js/wpsol-addon-lazyload.min.js', dirname(__FILE__)),
            array('jquery'),
            '1.0',
            true
        );

        wp_enqueue_script(
            'wpsol-addon-ajax-lazyload',
            plugins_url('assets/js/wpsol-addon-ajax-lazyload.min.js', dirname(__FILE__)),
            array('jquery'),
            '1.0',
            true
        );

        wp_enqueue_style(
            'wpsol-addon-lazy-load-css',
            plugins_url('assets/css/wpsol-addon-lazyload.min.css', dirname(__FILE__))
        );
    }

    /**
     * Execute iframe and HTML5 lazy loading
     *
     * @param string $content HTML raw
     *
     * @return mixed
     */
    public function iframeAndVideoLazyLoading($content)
    {
        // Iframe lazy loading
        if (preg_match_all('@<iframe(?<atts>\s.+)>.*</iframe>@iUs', $content, $iframes, PREG_SET_ORDER)) {
            $iframes = array_unique($iframes, SORT_REGULAR);
            foreach ($iframes as $iframe) {
                if (preg_match('#<iframe[^>]*data-speed-no-transform[^>]*>#Usmi', $iframe['atts'])) {
                    // data-speed-no-transform tag found
                    continue;
                }

                // Given the previous regex pattern, $iframe['atts'] starts with a whitespace character.
                if (!preg_match('@\ssrc\s*=\s*(\'|")(?<src>.*)\1@iUs', $iframe['atts'], $atts)) {
                    continue;
                }

                if (preg_match('@\ssrc\s*=\s*(\'|")(?<src>.*)\1@iUs', $iframe[0])) {
                    $iframe_lazyload = preg_replace(
                        '/src=(["\'])(.*?)["\']/is',
                        'data-wpsollazy-src=$1$2$1',
                        $iframe[0]
                    );
                }

                if (empty($iframe_lazyload)) {
                    continue;
                }

                if (!preg_match('@\sloading\s*=\s*(\'|")(?:lazy|auto)\1@i', $iframe_lazyload)) {
                    $iframe_lazyload = str_replace('<iframe', '<iframe loading="lazy"', $iframe_lazyload);
                }

                $noscript = '<noscript>' . $iframe[0] . '</noscript>';
                $iframe_lazyload .= $noscript;

                $content = str_replace($iframe[0], $iframe_lazyload, $content);
                unset($iframe_lazyload);
            }
        }

        // Videos lazy loading
        if (preg_match_all('@<video(?<atts>\s.+)>(.*)</video>@iUs', $content, $videos, PREG_SET_ORDER)) {
            $videos = array_unique($videos, SORT_REGULAR);

            foreach ($videos as $video) {
                if (preg_match('#<video[^>]*data-speed-no-transform[^>]*>#Usmi', $video[0])) {
                    // data-speed-no-transform tag found
                    continue;
                }

                if (preg_match('@\spreload\s*=\s*(\'|")(.*?)\1@i', $video[0])) {
                    continue;
                }

                // Given the previous regex pattern, $iframe['atts'] starts with a whitespace character.
                if (preg_match('@\ssrc\s*=\s*(\'|")(?<src>.*)\1@iUs', $video[0])) {
                    $video_lazyload = preg_replace(
                        '/src=(["\'])(.*?)["\']/is',
                        'data-wpsollazy-src=$1$2$1',
                        $video[0]
                    );
                }

                if (empty($video_lazyload)) {
                    continue;
                }

                if (preg_match('@\sposter\s*=\s*(\'|")(?<poster>.*)\1@iUs', $video_lazyload, $atts)) {
                    $video_lazyload = preg_replace(
                        '/poster=["\'](.*?)["\']/is',
                        'data-wpsollazy-poster=$1$2',
                        $video_lazyload
                    );
                } else {
                    // add the lazy class to the img element
                    if (preg_match('/class=["\']/i', $video_lazyload)) {
                        $video_lazyload = preg_replace(
                            '/class=(["\'])(.*?)["\']/is',
                            'class=$1wpsol-extra-lazy-loader $2$1',
                            $video_lazyload
                        );
                    } else {
                        $video_lazyload = preg_replace(
                            '/<video/is',
                            '<video class="wpsol-extra-lazy-loader"',
                            $video_lazyload
                        );
                    }
                }

                $noscript = '<noscript>' . $video[0] . '</noscript>';
                $video_lazyload .= $noscript;

                $content = str_replace($video[0], $video_lazyload, $content);
                unset($video_lazyload);
            }
        }

        return $content;
    }

    /**
     * Enqueue iframe & HTML5 videos lazy load script
     *
     * @return void
     */
    public function enqueueIframeVideoScripts()
    {
        wp_enqueue_script(
            'wpsol-addon-iframe-video-lazy-load',
            plugins_url('/assets/js/wpsol-addon-iframe-video-lazyload.min.js', dirname(__FILE__)),
            array('jquery'),
            '1.0',
            true
        );
    }
}
