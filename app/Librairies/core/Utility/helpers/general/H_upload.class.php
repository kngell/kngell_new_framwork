<?php
class H_upload
{
    //=======================================================================
    //Upload image
    //=======================================================================
    public static function upload_img($path, $file)
    {
        $targetDir = $path[1];
        //filename
        $filename = (pathinfo(basename($file['name']))['filename'] == 'image') ? self::rename_image($file) : basename($file['name']);
        $targetFilePath = $targetDir . DS . $filename;
        //upload file in the server
        if (move_uploaded_file($file['tmp_name'], $path[0] . $targetFilePath)) {
            self::syncronize_src_folder($path, $targetFilePath);
            return $targetFilePath;
        }
        return 'error';
    }

    //synchronize image between src and public folder on dev mod
    public static function syncronize_src_folder($path = [], $img = '')
    {
        if (isset($path) && isset($img)) {
            $imgModel = new ImageManager($path[0], IMAGE_ROOT_SRC);
            $img_infos = $imgModel->get_imagesInfos($img);
            $new_img = $imgModel->resizeImage($img_infos, $img);
            $imgModel->saveImage($img_infos, $new_img, $img);
            $imgModel->destroyImage($new_img);
            $imgModel = null;
            return true;
        }
    }

    //rename image
    public static function rename_image($file)
    {
        $ext = pathinfo(basename($file['name']), PATHINFO_EXTENSION);
        return md5(rand()) . '.' . $ext;
    }

    //=======================================================================
    //Validate and upload
    //=======================================================================
    public static function upload_files($files, $model, $container = null)
    {
        $paths = [];
        $status = [];
        $imageManager = $container->load([ImageManager::class => []])->Image;
        if ($files) {
            foreach ($files as $file) {
                $result = self::validate_and_upload_file($file, $model, $imageManager);
                if ($result['status'] == true) {
                    $paths[] = $result['url'];
                    $result['url'] = ImageManager::asset_img($result['url']);
                } else {
                    $imageManager = null;
                    return ['success' => false, 'msg' => FH::showMessage('danger', $result['msg']), 'upload_result' => $result];
                }
                $status[] = $result;
            }
            if ($paths) {
                self::cleanFiles($paths, $model);
                $imageManager = null;
                return ['success' => true, 'msg' => self::updateModel(serialize($paths), $model), 'upload_result' => $status];
            }
            $imageManager = null;
            return ['success' => false, 'msg' => self::updateModel('', $model), 'upload_result' => $status];
        } else {
            self::cleanFiles([], $model);
        }
        $imageManager = null;
        return ['success' => true, 'msg' => self::updateModel('', $model), 'upload_result' => $status];
    }

    // Clean files
    public static function cleanFiles($paths, $m)
    {
        $actual_files = self::modelImageField($m);
        if ($actual_files) {
            $real_paths = array_filter($actual_files, function ($path) use ($paths, $m) {
                $u = explode(DS, $path);
                $file = array_pop($u);
                $targetpth = array_pop($u) . DS . $file;
                if (!in_array($targetpth, array_merge($paths, ['users' . DS . 'avatar.png', '\users/avatar.png']))) {
                    $del = self::deleteImage($targetpth, $m);
                } else {
                    return $path;
                }
            });
            return $real_paths;
        }
        return false;
    }

    //Validate file
    public static function validate_and_upload_file($file, $model, $imgMgr)
    {
        $path_dir = self::get_path($model)[1];
        $arr_file = [
            'allowType' => ['JPG', 'PNG', 'JPEG', 'GIF', 'PDF', 'DOC', 'DOCX'],
            'filename' => basename($file['name']),
            'targetDir' => $path_dir,
            'targetFilePath' => $path_dir . DS . basename($file['name']),
            'fileType' => strtoupper(pathinfo($path_dir . DS . basename($file['name']), PATHINFO_EXTENSION)),
            'size' => 10 * 1024 * 1024
        ];
        $status = [
            'name' => $file['name'],
            'type' => $file['type'],
            'url' => '',
            'msg' => 'Invalid Type',
            'status' => false
        ];
        // Validate file Name
        if (empty($arr_file['filename'])) {
            $status['status'] = true;
            $media = self::get_mediaKey($model) ;
            $status['url'] = $model->$media != '' ? $model->$media : '';
            $arr_file = [];
            $path_dir = '';
            return $status;
        }
        //Validate type
        if (!in_array($arr_file['fileType'], $arr_file['allowType'])) {
            $arr_file = [];
            $path_dir = '';
            return $status;
        }
        // Validate length width
        $img_infos = $imgMgr->get_imagesInfos($file['tmp_name']);
        if ($img_infos[0] > '1840' && $img_infos[1] > '860') {
            $status['msg'] = 'Invalid file size! Please change your file.';
            $arr_file = [];
            $path_dir = '';
            return $status;
        }
        //Validate size
        if ($file['size'] == 0) {
            $mediaKey = self::get_mediaKey($model);
            if ($mediaKey == 'profileImage' && $model->$mediaKey == '') {
                $status['url'] = ImageManager::asset_img('users' . US . 'avatar.png');
                $arr_file = [];
                $path_dir = '';
                return $status;
            }
        }
        if ($file['size'] > $arr_file['size']) {
            $status['msg'] = 'Invalid file size! Please change your file.';
            $arr_file = [];
            $path_dir = '';
            return $status;
        }
        //Validate existing file
        $actual_Path = self::modelImageField($model);
        if ($actual_Path !== false && file_exists(IMAGE_ROOT . $arr_file['targetFilePath'])) {
            if (in_array(IMG . $arr_file['targetFilePath'], $actual_Path)) {
                $status['msg'] = 'Success';
                $status['url'] = $arr_file['targetFilePath'];
                $status['status'] = true;
                $arr_file = [];
                $path_dir = '';
                $actual_Path = '';
                return $status;
            }
        }
        $path = self::upload_img(self::get_path($model), $file);
        if ($path == 'error') {
            $arr_file = [];
            $path_dir = '';
            $actual_Path = '';
            $status['msg'] = 'Error moving file to Server';
        } else {
            $status['msg'] = 'Success';
            $status['url'] = $path;
            $status['status'] = true;
        }
        $arr_file = [];
        $path_dir = '';
        $actual_Path = '';
        $path = '';
        return $status;
    }

    //Delete Image
    private static function deleteImage($path, $m)
    {
        if ($m->getAllItem(['where' => [self::get_mediaKey($m) => serialize([$path])]])->count() <= 1) {
            if (file_exists(IMAGE_ROOT . $path)) {
                unlink(IMAGE_ROOT . $path);
                unlink(str_replace('public', 'src', IMAGE_ROOT) . $path);
                return true;
            }
        }
        return false;
    }

    //re-arrange files
    public static function reArrayFiles($files, $m)
    {
        $fileAry = [];
        $file_count = count($files['name']);
        $file_keys = array_keys($files);

        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $fileAry[$i][$key] = $files[$key][$i];
            }
        }
        return $fileAry;
    }

    //update model
    private static function updateModel($path, $model)
    {
        $table = $model->get_tableName();
        $md = $model;
        switch ($table) {
            case 'realisations':
                $md->brand = $path;
                break;
            case 'users':
                $md->profileImage = $path;
                break;
            case 'posts':
                $md->postImg = $path;
                break;
            case 'candidatures':
                $md->cv = $path;
                break;
            case 'formations_inscriptions':
                $md->cv = $path;
                break;
            case 'post_file_url':
                $md->fileUrl = $path;
                break;
            case 'products':
                $md->p_media = $path;
                break;

            default:
                // code...
                break;
        }
        return $md;
    }

    //Get image key
    public static function get_mediaKey($model)
    {
        $table = $model->get_tableName();
        switch ($table) {
            case 'realisations':
                return 'brand';
                break;
            case 'users':
                return 'profileImage';
                break;
            case 'posts':
                return 'postImg';
                break;
            case 'candidatures':
                return 'cv';
                break;
            case 'formations_inscriptions':
                return 'cv';
                break;
            case 'post_file_url':
                return 'fileUrl';
                break;
            case 'products':
                return 'p_media';
                break;
            default:
                // code...
                break;
        }
    }

    //get path
    private static function get_path($model)
    {
        $table = $model->get_tableName();
        switch ($table) {
            case 'realisations':
                $path = [IMAGE_ROOT, 'brand'];
                break;
            case 'users':
                $path = [IMAGE_ROOT, 'users'];
                break;
            case 'posts':
                $path = [IMAGE_ROOT, 'blog-post'];
                break;
            case 'candidatures':
                $path = [IMAGE_ROOT, 'candidats'];
                break;
            case 'post_file_url':
                $path = [IMAGE_ROOT, 'postsImg'];
                break;
            case 'products':
                $path = [IMAGE_ROOT, 'products'];
                break;
            default:
                // code...
                break;
        }
        return $path;
    }

    // Image field
    private static function modelImageField($model)
    {
        switch ($model->get_tableName()) {
            case 'realisations':
                return !empty($model->brand) ? $model->brand : false;
                break;
            case 'users':
                return !empty($model->profileImage) ? [$model->profileImage] : false;
                break;
            case 'candidatures':
                return !empty($model->cv) ? $model->cv : false;
                break;
            case 'posts':
                return !empty($model->postImg) ? $model->postImg : false;
                break;
            case 'post_file_url':
                return !empty($model->fileUrl) ? $model->fileUrl : $model->fileUrl;
                break;
            case 'products':
                return !empty($model->p_media) ? $model->p_media : false;
                break;

            default:

                break;
        }
    }

    //upload post Url base 64
    public static function uploadPostUrl($postContent)
    {
        $dom = new \DomDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHtml($postContent);
        $images = $dom->getElementsByTagName('img');
        $bs64 = 'base64'; //variable to check the image is base64 or not
        foreach ($images as $k => $img) {
            $data = $img->getAttribute('src');
            if (strpos($data, $bs64) == true) { //if the Image is base 64
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
                $image_name = 'post_url' . time() . $k . '.png';
                $path = UPLOAD_ROOT . 'postsImg' . DS . $image_name;
                file_put_contents($path, $data);
                $img->removeAttribute('src');
                $img->setAttribute('src', $image_name);
            } else { //put '/' to prevent lossing image  actual path
                $image_name = '/' . $data;
                $img->setAttribute('src', $image_name);
            }
        };
        $editor_content_save = $dom->saveHTML();
        return $editor_content_save;
    }

    //manage upload image un save
    public static function manage_uploadImage($lastID, $table, $data)
    {
        if (in_array($table, ['posts', 'realisations']) && isset($data['imageUrlsAry'])) {
            $imgUrlsAry = explode(',', $data['imageUrlsAry']);
            $urlModel = GlobalsManager::get('global_session')->get(CONTAINER_NAME)->load([PostFileUrlManager::class => []])->PostFileUrl;
            $tempUrls = $urlModel->getAllbyIndex('IS NULL');
            $tempUrls->delete('imgID', $lastID . $table);
            if ($tempUrls->count() > 0) {
                foreach ($imgUrlsAry as $key => $url) {
                    foreach ($tempUrls->get_results() as $urlModel) {
                        if ($url == $urlModel->fileUrl) {
                            $urlModel->id = $urlModel->pfuID;
                            $urlModel->imgID = $lastID . $table;
                            if ($urlModel->save()) {
                                unset($imgUrlsAry[$key]);
                            }
                        }
                    }
                }
            } elseif (!empty(array_filter($imgUrlsAry))) {
                foreach ($imgUrlsAry as $key => $url) {
                    $tempUrls->imgID = $lastID . $table;
                    $tempUrls->fileUrl = $url;
                    if ($tempUrls->save()) {
                        unset($imgUrlsAry[$key]);
                    }
                }
            }
            // $tempUrls->deleteAllNullIndex();
            self::removeUnusedUrls();
        }
    }

    //remove unused urls
    public static function removeUnusedUrls()
    {
        $postsFiles = array_diff(scandir(UPLOAD_ROOT . 'postsImg'), ['.', '..']);
        $urls = (new PostFileUrlManager())->getAllItem();
        $urlsAry = array_column($urls->get_results(), 'fileUrl');
        foreach ($postsFiles as $key => $file) {
            if (!in_array(UPLOAD . 'postsImg' . DS . $file, $urlsAry)) {
                unlink(UPLOAD_ROOT . 'postsImg' . DS . $file);
                $urls->delete('', ['fileUrl' => UPLOAD . 'postsImg' . DS . $file]);
            }
        }
    }
}