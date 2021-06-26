<?php
class AssetsController extends Controller
{
    public function __construct(string $controller, string $method)
    {
        parent::__construct($controller, $method);
    }

    public function download($file)
    {
        // if ($this->request->exists('post')) {
        $file = basename($this->request->getAll('url'));
        $filePath = FILES . 'download' . DS . $file;
        if (!empty($file) && file_exists($filePath)) {
            //Define Headers
            header('Cache-Control: public');
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . $file . '');
            header('Content-Transfer-Encoding: binary');
            header('Content-Type: binary/octet-stream');

            readfile($filePath);
            exit;
        }
        // }
    }

    public function upload($data)
    {
        $filename = array_pop($data);
        $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
        $pathRoot = in_array($file_ext, ['js', 'css']) ? LAZYLOAD_ROOT : UPLOAD_ROOT;
        $path = array_pop($data);
        $fileToGet = empty($path) ? $pathRoot . $filename : $pathRoot . $path . DS . $filename;
        if (!empty($filename) && file_exists($fileToGet) && !in_array($file_ext, ['png', 'jpg', 'jpeg', 'gif'])) {
            header('Content-Type: binary/octet-stream');
            header('Content-Length: ' . filesize($fileToGet));
            readfile($fileToGet);
            exit;
        }
    }

    public function img($filename)
    {
        $file = array_pop($filename);
        $path = array_pop($filename);
        $path1 = '';
        if (!empty($filename)) {
            foreach ($filename as $k => $v) {
                $path1 .= $v . DS;
            }
        }
        $path = $path1 . $path;
        $fileToGet = empty($path) ? IMAGE_ROOT . $file : IMAGE_ROOT . $path . DS . $file;
        $ntct = ['1' => 'image/gif',
            '2' => 'image/jpeg',
            '3' => 'image/png',
            '6' => 'image/bmp',
            '17' => 'image/ico'];
        if (!empty($file) && file_exists($fileToGet)) {
            header('Content-type: ' . $ntct[exif_imagetype($fileToGet)]);
            header('Content-Length: ' . filesize($fileToGet));
            readfile($fileToGet);
            exit;
        }
    }

    public function acme($data)
    {
        $filename = array_pop($data);
        $fileToGet = ACME_ROOT . $filename;
        if (!empty($filename) && file_exists($fileToGet)) {
            header('Content-Type: binary/octet-stream');
            header('Content-Length: ' . filesize($fileToGet));
            readfile($fileToGet);
            exit;
        }
    }

    public function dropzoneupload()
    {
    }
}