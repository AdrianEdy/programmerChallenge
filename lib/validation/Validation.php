<?php
    class Validation
    {   
        public $messages = [
            'required'      => 'Your ?input must be filled in',
            'between'       => 'Your ?input must be ?min to ?max characters long',
            'limit'         => 'Your ?input must be ?limit digit ?chara',
            'fileType'      => 'Your ?file is only valid ?type',
            'fileSize'      => 'Your ?file only valid ?size or less'
        ];
        protected $fileCategory   = [
            'image' => ['jpg', 'jpeg', 'png', 'gif']
        ];
        protected $checkBetween = [];
        protected $checkLimit   = [];
        protected $fileSize     = [];

        public function validatePost($request)
        {
            $errors         = [];
            $messages       = $this->messages;
            $replaceBetween = ['?input', '?min', '?max'];
            $replaceLimit   = ['?input', '?limit', '?chara'];

            $checkBetween   = $this->checkBetween;
            foreach ($checkBetween as $key => $value) {
                $replace = [$key, $value[0], $value[1]];
                $check   = preg_replace('/(\r|\n)/', '', $request[$key]);
              
                if (empty($check)) {
                    array_push($errors, str_replace('?input', $key, $messages['required']));
                } else {
                    if (strlen($check) < $value[0] || strlen($check) > $value[1]) {
                        array_push(
                            $errors, 
                            str_replace($replaceBetween, $replace, $messages['between'])
                        );
                    }
                }
            }

            $checkLimit = $this->checkLimit;
            foreach ($checkLimit as $key => $value) {
                if (isset($request[$key])) {
                    $replace = [$key, $value[0], $value[1]];
                    if ($value[1] === 'number') {
                        if (strlen($request[$key]) != $value[0] ||
                            !is_numeric($request['password'])) {
                            array_push(
                                $errors, 
                                str_replace($replaceLimit, $replace, $messages['limit'])
                            );
                        }
                    }
                }
            }
            

            return $errors;
        }

        public function validateFile($category, $request)
        {
            $errors       = [];
            $messages     = $this->messages;
            $fileCategory = $this->fileCategory;
            $replaceType  = ['?file', '?type'];
            $replaceSize  = ['?file', '?size'];
            $fileSize     = $this->fileSize[$category];

            foreach ($request as $file) {
                if (isset($file) && !is_null($file)) {
                    $fileType  = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
    
                    if (!in_array($fileType, $fileCategory[$category])) {
                        $combineType     = preg_filter('/^/', '.', $fileCategory[$category]);
                        $combineTypeList = implode(', ', $fileCategory[$category]);
                        $fillPlace       = [$category, $combineTypeList];
                        $replaced        = str_replace($replaceType, $fillPlace, $messages['fileType']);
                        array_push($errors, $replaced);
                    } else {
                        if ($file['size'] > $fileSize) {
                            $sizeInMb  = $fileSize / 1000000;
                            $sizeInMb  = $sizeInMb . 'MB';
                            $fillPlace = [$category, $sizeInMb];
                            $replaced  = str_replace($replaceType, $fillPlace, $messages['fileType']);
                            array_push($errors, $replaced);
                        }
                    }
                }
            }

            return $errors;
        }
    }
?>