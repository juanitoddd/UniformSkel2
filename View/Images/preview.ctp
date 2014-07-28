<?php
#$params['markup'] = false;
$params['direct'] = true;
$data = (array) $this->params;
$data = $data['params'];
$params = array_merge($params, array_intersect_key(
        $data,
        array(
                'crop' => null,
                'width' => null,
                'height' => null,
                'id' => null
        )
));
//debug($data);

echo $this->Image->resize('files'.DS.$this->data['path'].DS.$this->data['filename'], $params);
