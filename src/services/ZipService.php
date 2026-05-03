<?php
    class ZipService {        
        /**
         * Creates a zip file from a given directory.
         * @param  string $sourceDir
         * @param  string $outputFile
         * @return void
         */
        public function create($sourceDir, $outputFile) {
            $zip = new ZipArchive();

            if ($zip->open($outputFile, ZIPARCHIVE::CREATE) === true) {
                $this->addDirectory($sourceDir, $zip);
                $zip->close();
            }
        }
        
        /**
         * Recursively adds a directory and its contents to the zip archive.
         * @param  string $dir Directory to add
         * @param  ZipArchive $zip ZipArchive instance to add files to
         * @return void
         */
        private function addDirectory($dir, $zip) {
            if (is_dir($dir)) {
                if ($da = opendir($dir)) {
                    while (($archivo = readdir($da)) !== false) {

                        if ($archivo != "." && $archivo != "..") {
                            $fullPath = $dir . $archivo;

                            if (is_dir($fullPath)) {
                                $this->addDirectory($fullPath . "/", $zip);
                            } else {
                                $zip->addFile($fullPath, $fullPath);
                            }
                        }
                    }
                    closedir($da);
                }
            }
        }
    }