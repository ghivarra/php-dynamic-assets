<?php namespace App\Controller;

/**
 * Image Controller
 *
 * "I treat my works as my own child, be careful with my childrens"
 *
 * Created with love and proud by Ghivarra Senandika Rushdie
 *
 * @package PHP Dynamic Assets
 *
 * @var https://github.com/ghivarra
 * @var https://facebook.com/bcvgr
 * @var https://twitter.com/ghivarra
 *
**/

use Intervention\Image\ImageManager;

class ImageController extends BaseController
{
    protected $allowedImageType = ['image/png', 'image/jpeg', 'image/bmp', 'image/webp'];
    protected $maxWidth = 2048;
    protected $maxHeight = 2048;
    protected $options = ['height', 'width', 'forced'];

    //=================================================================================================================

	public function index()
	{
		$path = func_get_args();
        $path = ASSETPATH . 'images' . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $path);

        if (!file_exists($path) OR !is_writable($path))
        {
            return $this->returnJSON('File not found or restricted.', 404);
        }

        // get all params
        $get = [
            'width'    => $this->request->getGet('width'),
            'height'   => $this->request->getGet('height'),
            'priority' => $this->request->getGet('priority')
        ];

        // set etag
        $etag = '"'. md5($_SERVER['REQUEST_URI']) .'"';
        $mime = mime_content_type($path);

        // get image size
        $imageInfo = getimagesize($path);
        $params = [
            'width'    => isset($get['width']) ? (($get['width'] > $this->maxWidth) ? $this->maxWidth : $get['width']) : $imageInfo[0],
            'height'   => isset($get['height']) ? (($get['height'] > $this->maxHeight) ? $this->maxHeight : $get['height']) : $imageInfo[1],
            'priority' => isset($get['priority']) ? (in_array($get['priority'], $this->options) ? $get['priority'] : 'width') : 'width'
        ];

        // if same size
        if (($params['width'] == $imageInfo[0]) && ($params['height'] == $imageInfo[1]))
        {
            $filesize = filesize($path);

            header("Cache-Control: max-age=31536000, immutable");
            header("Content-Length: {$filesize}");
            header("Content-Type: {$mime}");
            header("Vary: Accept-Encoding");
            header("ETag: {$etag}");

            return file_get_contents($path);
        }

        // get image library
        $imageManipulator = new ImageManager();

        // create image
        $img = $imageManipulator->make($path);

        // set resize
        switch ($params['priority']) {
            case 'width':
                $img->resize($params['width'], NULL, function ($constraint) {
                    $constraint->aspectRatio();
                });
                break;

            case 'height':
                $img->resize(NULL, $params['height'], function ($constraint) {
                    $constraint->aspectRatio();
                });
                break;

            case 'forced':
                $img->resize($params['width'], $params['height']);
                break;
            
            default:
                return $this->response->setStatusCode(400)->setBody('Wrong Parameters');
                break;
        }

        header("Cache-Control: max-age=31536000, immutable");
        header("Content-Length: {$img->filesize()}");
        header("Content-Type: {$mime}");
        header("Vary: Accept-Encoding");
        header("ETag: {$etag}");

        // return
        return $img->response();
	}

	//=================================================================================================================
}