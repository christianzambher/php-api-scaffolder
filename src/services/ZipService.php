<?php
    class ZipService {
        public function create($sourceDir, $outputFile) {
            $zip = new ZipArchive();

            if ($zip->open($outputFile, ZIPARCHIVE::CREATE) === true) {
                $this->addDirectory($sourceDir, $zip);
                $zip->close();
            }
        }

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