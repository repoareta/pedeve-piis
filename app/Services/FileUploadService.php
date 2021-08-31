<?php

namespace App\Services;

class FileUploadService
{
    private $fileInstance, 
            $pathToSave,
            $oldFile;

    /**
     * __construct
     *
     * @param  mixed $fileInstance
     * @param  string $pathToSave
     * @param  string $oldFile
     * @return void
     */
    public function __construct($fileInstance, $pathToSave, $oldFile)
    {
        $this->fileInstance = $fileInstance;
        $this->pathToSave = $pathToSave;
        $this->oldFile = $oldFile;
    }
    
    /**
     * handle file upload
     *
     * @return string
     */
    public function upload()
    {
        $originalName = pathinfo($this->fileInstance->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = pathinfo($this->fileInstance->getClientOriginalName(), PATHINFO_EXTENSION);

        if (file_exists($this->oldFile)) {
            $timeStamps = str_replace(['-', ':', ' '], '', date('dmYHis')) . rand(0, 999);
            $originalName = $originalName . '_' . $timeStamps;
        }

        $renamedFile = $originalName . '.' . $extension;

        $this->fileInstance->storeAs(
            $this->pathToSave,
            $renamedFile,
            'public'
        );

        return $renamedFile;
    }
}