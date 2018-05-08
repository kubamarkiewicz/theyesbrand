<?php namespace KubaMarkiewicz\Api\Models;

use System\Models\File as FileBase;
use Str;

class File extends FileBase 
{
    
    /**
     * Generates a disk name from the supplied file name. 
     * SEO friendly
     */
    protected function getDiskName()
    {
        if ($this->disk_name !== null)
            return $this->disk_name;

        $ext = strtolower(pathinfo($this->file_name, PATHINFO_EXTENSION));
        $name = self::sanitize_filename(pathinfo($this->file_name, PATHINFO_FILENAME));

        return $this->disk_name = $ext !== null ? $name.'.'.$ext : $name;
    }


	/**
    * Generates a partition for the file.
    */
    protected function getPartitionDirectory()
    {
        return implode('/', array_slice(str_split(md5($this->disk_name), 3), 0, 3)) . '/';
    }



    /**
     * Sanitize filename
     *
     * @param  string  $title
     * @param  string  $separator
     * @param  string  $language
     * @return string
     */
    public static function sanitize_filename($title, $separator = ' ', $language = 'en')
    {
        $title = Str::ascii($title, $language);

        // Replace @ with the word 'at'
        $title = str_replace('@', $separator.'at'.$separator, $title);

        // Remove all characters that are not the separator, letters, numbers, or whitespace.
        $title = preg_replace('![^'.preg_quote($separator).' -_\pL\pN\s]+!u', '', $title);

        // Replace all separator characters and whitespace by a single separator
        $title = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $title);

        return trim($title, $separator);
    }
    

}