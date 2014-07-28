<?php
define ('IMAGE_CACHE_DB', 0);
define ('IMAGE_CACHE_FILESYSTEM', 1);
class ImageHelper extends Helper {
	
	public $helpers = array('Html');
	public $originalPath; // path to search images
	public $cachePath;// path for writing cache images
	public $relativePath; // path for outputting images in html code
	// resources to the images
	protected $oldImage;
	protected $workingImage;
	protected $newImage;
	
	protected $currentSizei = array();
	protected $fileType;
	public $cacheType  = IMAGE_CACHE_FILESYSTEM; // whether to use db cache or filesystem cache
	public $cacheFilename;
	public $markup = true;
	public $htmlAttributes = array();
	protected $resizeTypes = null;
	public $direct = false; // direct output?
	
	public function __construct(){
		// path to search images
		$this->originalPath = WWW_ROOT;
		// path for writing cache images
		$this->cachePath = WWW_ROOT . 'img'.DS.'cache' . DS;
		// path for outputting images in html code
		$this->relativePath = '/img/cache/';
		
		if(!function_exists("gd_info")) {
			trigger_error( 'You do not have the GD Library installed.  This class requires the GD library to function properly.' . "\n"
			. 'visit http://us2.php.net/manual/en/ref.image.php for more information');
		}
		if (!is_dir($this->cachePath)) {
			mkdir($this->cachePath, 0777, true);
		}
		if (!is_dir($this->cachePath)) {
			echo 'Cache directory does not exists: '. $this->cachePath;
			exit(); 
		}
		if (!is_writable($this->cachePath)) {
			echo 'Cache directory is not writable: '.$this->cachePath;
			exit();
		}
	}
	
	function o() {
		$path = $this->relativePath . $this->cacheFilename;

		if ($this->options['direct']) {
			readfile($this->cachePath . $this->cacheFilename);
			return;
		}
		if ($this->options['full']) {
			$path = Router::url($path, true);
		}
		if ($this->options['markup']) {
			return $this->Html->image($path, $this->htmlAttributes);
		} else {
			return $path;
		}
	}
	
	protected function getResizeTypes() {
		if (!empty($this->resizeTypes)) {
			return $this->resizeTypes;
		}
		$view =& ClassRegistry::getObject('View');
		if (!isset($view->viewVars['resizeTypes'])) {
			$view->viewVars['resizeTypes'] = ClassRegistry::init('ResizeType')->find('all');
		}
		$this->resizeTypes = array();
		foreach ($view->viewVars['resizeTypes'] as $entry) {
			$this->resizeTypes[$entry['ResizeType']['slug']] = $entry['ResizeType'];
		}
		return $this->resizeTypes;
	}
	
	function show($data, $type, $htmlAttributes = array(), $options = array()) {
		$resizeTypes = $this->getResizeTypes();
		if (!isset($resizeTypes[$type])) {
			return trigger_error('resizeType not found: ' . $type);
		}
		$resizeData = Set::merge($resizeTypes[$type], $options);
		if ($resizeData['type'] == 'crop') {
			$resizeData['crop'] = true;
		}
		foreach ($data['ResizeType'] as $entry) {
			if ($entry['slug'] == $type) {
				$resizeData = Set::merge($resizeData, $entry);
				if (count($entry['ImageSize'])) {
					$resizeData['crop'] = $entry['ImageSize'];					
				} else if ($entry['type'] == 'crop') {
					$resizeData['crop'] = true;
				}
			}
		}
		$parts = explode('.', $data['Document']['title']);
		$targetFilename = array_slice($parts, 0, count($parts)-1);
		$targetFilename = implode('.', $targetFilename);
		return  $this->resize('files/'.$data['Document']['filename'], $resizeData, $htmlAttributes, $targetFilename);
	}
	
	public function resize($file, $options = array(), $htmlAttributes = array(), $targetFilename = null){
		//$this->log($options, 'images');
		$this->htmlAttributes = $htmlAttributes;
		$defaults = array('width' => null, 'height' => null, 'largest' => false, 'enlarge' => false, 'keepRatio' => true, 'filename' => $file, 'crop' => false, 'direct' => false, 'markup' => true, 'full' => false);
		if (isset($options['width']) && !$options['width']) {
			unset($options['width']);
		}
		if (isset($options['height']) && !$options['height']) {
			unset($options['height']);
		}
		if ($targetFilename === null) {
			$targetFilename = $file;
		}
		$this->options = $options = Set::merge($defaults, $options);
		extract($options);
		if($this->checkFile($file)){
			// Get new dimensions
			list($width_orig, $height_orig) = getimagesize($this->filePath);
			$this->originalSize = array('width' => $width_orig,'height'=> $height_orig);
			$ratio_orig = $width_orig/$height_orig;
			if ($width === null && $height === null) {
				#trigger_error('resizing: must provide width or height');
				$width = $width_orig;
				$height = $height_orig;
			}
			if ($width === null) {
				$keepRatio = true;
				$width = $height * $ratio_orig;
				if ($type == 'resize' && $crop) {
					$heightNew = $crop['y2'] - $crop['y1'];
					$width = ($crop['x2'] - $crop['x1']) * ($height / $heightNew);
				}
			}
			if ($height === null) {
				$keepRatio = true;
				$height = $width / $ratio_orig;
				if ($type == 'resize' && $crop) {
					$widthNew = $crop['x2'] - $crop['x1'];
					$height = ($crop['y2'] - $crop['y1'] ) * ($width / $widthNew);
				}
			}
			if ($width_orig <= $width && $height_orig <= $height && !$enlarge) { 
				$width = $width_orig;
				$height = $height_orig;	
				$crop = false;
			} else {
				if ($keepRatio) {
					if ($crop) {
						$required = array('x1','y1','x2','y2');
						if ( !is_array($crop) || array_intersect($required, array_keys($crop)) !== $required) {
							$crop = array();
							$ratio = $width/$height;
							if ($ratio < $ratio_orig) {
								$differenz = ($width_orig - $width/$height * $height_orig);
								$crop = array('y1' => 0, 'y2' => $height_orig, 'x1' => $differenz/2, 'x2' => $width_orig-$differenz/2);
							} else {
								$differenz = ($height_orig - $height/$width * $width_orig);
								$crop = array('x1' => 0, 'x2' => $width_orig, 'y1' => $differenz/2, 'y2' => $height_orig-$differenz/2);
							}
						}
					} else {
						if($largest){
							if ($width/$height < $ratio_orig) {
								$width = $height*$ratio_orig;
							} else {
								$height = $width/$ratio_orig;
								$this->log('here', 'imageresize');
								$this->Log($this->filePath);
							}
						} else {
							if ($width/$height > $ratio_orig) {
								$width = $height*$ratio_orig;
							} else {
								$height = $width/$ratio_orig;
								$this->log('here2', 'imageresize');
								$this->log($this->filePath);
							}
						}
					}
				}
			}
			$width = round($width);
			$height = round($height);
			if (!$crop) {
				$crop = array('x1' => 0, 'y1' => 0, 'x2' => $width_orig,'y2' => $height_orig);
			}
			$this->currentSize = compact('width', 'height');
			$this->crop = $crop;
			foreach($this->crop as $key => $value){
				$this->crop[$key] = round($value);
			}
			if($this->checkCache($file, array_merge($this->currentSize, $this->crop), $targetFilename)){
				return $this->o();
			}
			//checkMemoryForImage($this->filePath, $this->fileType);
			$this->openImage();
			
			$this->newImage = imagecreatetruecolor($this->currentSize['width'], $this->currentSize['height']);
			
			if($this->fileType == 'PNG'){
				imagesavealpha($this->newImage, true);
				$trans_colour = imagecolorallocatealpha($this->newImage, 0, 0, 0, 127);
				imagefill($this->newImage, 0, 0, $trans_colour);
			}
			
			if ($this->fileType == 'GIF') {
				$trans_colour = imagecolorallocate($this->newImage, 0,0,0);
				imagecolortransparent($this->newImage, $trans_colour);
			}
			
			imagecopyresampled($this->newImage, $this->oldImage, 0, 0, $crop['x1'], $crop['y1'], $this->currentSize['width'], $this->currentSize['height'], $crop['x2']-$crop['x1'], $crop['y2']-$crop['y1']);				
			// Save image to cache and return html
		
			$this->saveFile();
			$this->__destruct();
			return $this->o();
		}
	}

    protected function openImage() {
        switch($this->fileType) {
            case 'GIF':
                $this->oldImage = imagecreatefromgif($this->filePath);
                break;
            case 'JPG':
                $this->oldImage = imagecreatefromjpeg($this->filePath);
                break;
            case 'PNG':
                $this->oldImage = imagecreatefrompng($this->filePath);
                break;
            case 'BMP':
                $this->oldImage = imagecreatefromwbmp($this->filePath);
                break;
        }
    }

	public function checkFile($file) {
		if (!strstr($file, '://'))
			$filePath = rtrim($this->originalPath, DS) . DS . $file;
		else
			$filePath = $file;
		$this->filePath = $filePath;
		if (($info = getimagesize($filePath)) !== false){
			$ext = strtolower(ltrim(image_type_to_extension($info[2]),'.'));	
			if($ext === 'gif'){
				return  $this->fileType = 'GIF';
			} elseif($ext === 'jpg' || $ext === 'jpeg'){
				return  $this->fileType = 'JPG';
			} elseif($ext === 'png'){
				return $this->fileType = 'PNG';
			} elseif($ext === 'bmp'){
				return  $this->fileType = 'BMP';
			} else { //unknown file format
				trigger_error('unknown file format (' . $file.', path: '.$this->originalPath .')');
				return $this->fileType = false;
			}
		}
		return false;
	}
	
	protected function checkCache($original, $attributes, $targetFilename = null) {
		if ($this->cacheType === IMAGE_CACHE_DB) {
			return $this->checkDatabaseCache($original, $attributes, $targetFilename) && Configure::read() == 0;
		} elseif ($this->cacheType === IMAGE_CACHE_FILESYSTEM)  {
			return $this->checkFilesystemCache($original, $attributes ,$targetFilename )&& Configure::read() == 0;
		}
	}
	
	protected function checkFilesystemCache($original, $attributes, $targetFilename = null){   
		if (!isset($attributes['width'], $attributes['height'])) {
			return trigger_error('too few arguments');
		}
		if ($targetFilename === null) {
			$targetFilename = $original;
		}
		$this->cacheFilename =  implode('x', $this->currentSize) .'_'. str_replace(array('http://', '/', '\\'), array('','_','_'), $targetFilename)  ;
		$path = $this->cachePath . $this->cacheFilename;
		if (!file_exists($path) || (@filemtime($path) < @filemtime($this->originalPath . $original))) {
				return false;
		} else {
				return true;
		}
	}
	
	function checkDatabaseCache($original, $attributes, $targetFilename = null) {
		if (!isset($attributes['width'], $attributes['height'])) {
			return trigger_error('too few arguments');
		}
		$defaults = array('x1' => 0, 'x2' => round($attributes['width']), 'y1' => 0, 'y2' => round($attributes['height']));
		$attributes = array_merge($defaults, $attributes);
		extract($attributes);
		$imageCacheModel =& ClassRegistry::init('Filemanager.ImageCache');
		$r =  $imageCacheModel->cacheFile($original, $attributes, $targetFilename);
		$this->cacheFilename = $r[0];
		return $r[1];
	}

	public function saveFile(){
		switch($this->fileType) {
			case 'GIF':
				if ($this->options['direct']) {
					header('Content-Type: image/gif');
				}

				imagegif($this->newImage,$this->cachePath . $this->cacheFilename);
				break;
			case 'JPG':
                if ($this->options['direct']) {
                    header('Content-Type: image/jpeg');
                }
                imagejpeg($this->newImage,$this->cachePath . $this->cacheFilename, 100);
			case 'BMP': // make BMPs to JPGs
				if ($this->options['direct']) {
					header('Content-Type: image/jpeg');
				}
				imagejpeg($this->newImage,$this->cachePath . $this->cacheFilename, 100);
				break;
			case 'PNG':
				if ($this->options['direct']) {
					header('Content-Type: image/png');							
				}
				imagepng($this->newImage,$this->cachePath . $this->cacheFilename, 9);
				break;
		}
	}
	
	public function __destruct() {
		if(is_resource($this->newImage)) 
			@ImageDestroy($this->newImage);
		if(is_resource($this->oldImage)) 
			@ImageDestroy($this->oldImage);
		if(is_resource($this->workingImage)) 
			@ImageDestroy($this->workingImage);
	}
}

