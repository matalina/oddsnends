<?php
/**
 * Image Controller
 * @package Project's Name
 * @author Alicia Wilkerson
 * @version 1.0.0
 */

/**
 * @package Project's Name
 * @subpackage Controllers
 */
class Image extends CI_Controller {
  /**
   * Initialize Controller
   * @access public
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * View Image
   */
  public function view($image_id) {
    $this->load->model('Image_model');
    $result = $this->Image_model->get_image($image_id);
    $image_path = base_url('images/pictures/'.$result['filename']);

    ob_start();
    $watermark = imagecreatefromjpeg(base_url('images/watermark.png'));
    $white = imagecolorallocate($watermark,225,225,225);
    imagecolortransparent($watermark,$white);
    $watermark_width = imagesx($watermark);
    $watermark_height = imagesy($watermark);
    $photo = imagecreatetruecolor($watermark_width, $watermark_height);
    $photo = imagecreatefromjpeg($image_path);
    $size = getimagesize($image_path);
    $dest_x = $size[0] - $watermark_width - 5;
    $dest_y = $size[1] - $watermark_height - 5;
    imagecopymerge($photo, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, 100);
    imagejpeg($photo);
    imagedestroy($photo);
    imagedestroy($watermark);
    $image = ob_get_contents();

    ob_end_clean();

    header('content-type: image/jpeg');
    echo $image;
  }

  public function test() {
    echo '<img src="'.site_url('image/view/1').'" alt="" width="1000px"/>';
  }


}
