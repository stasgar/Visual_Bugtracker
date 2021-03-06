<?php

namespace App\Services\ImageUpload;

use Illuminate\Http\UploadedFile;

/**
 * Class AbstractFileUploadService is used to unify a file upload process.
 *
 * @package App\Services\FileUpload
 */
abstract class AbstractFileUploadService
{
    protected $basePath;

    /**
     * FileUploadContract constructor.
     * @param string $basePath File destination path.
     */
    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @param UploadedFile $file
     * @param string $newName
     * @param string|null $oldName Defines a file name to be deleted/stashed.
     * @return string $newName
     */
    abstract public function upload(UploadedFile $file, string $newName = null, string $oldName = null): string;

    /**
     * @param string $name
     * @return bool
     */
    abstract public function delete(string $name): bool;
}
