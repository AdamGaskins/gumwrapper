<?php

namespace GumWrapper;

use ZipArchive;

/** @internal */
class BinManager
{
    public const GUM_VERSION = '0.4.0';

    public function installBinary()
    {
        $binaryFolder = static::getBinaryFolder();

        $binary = $binaryFolder.self::getBinaryName();
        if (file_exists($binary)) {
            $version = exec($binary.' --version');
            if ($version && mb_stripos($version, 'v'.self::GUM_VERSION.' ') !== false) {
                return true;
            }
        }

        $tmpDir = sys_get_temp_dir().DIRECTORY_SEPARATOR.mt_rand();
        mkdir($tmpDir);

        $url = static::getBinaryUrl();
        $compressedFile = $tmpDir.basename(parse_url($url, PHP_URL_PATH));
        file_put_contents($compressedFile, file_get_contents($url));

        if (! file_exists($binaryFolder)) {
            mkdir($binaryFolder);
        }

        if (mb_stripos($compressedFile, '.tar.gz') !== false) {
            exec('tar -xf '.escapeshellarg($compressedFile).' -C '.escapeshellarg($binaryFolder).' gum');
        } elseif (mb_stripos($compressedFile, '.zip') !== false) {
            $zip = new ZipArchive();
            $zip->open($compressedFile, ZipArchive::RDONLY);
            $zip->extractTo($binaryFolder, 'gum.exe');
            $zip->close();
        }

        unlink($compressedFile);
        rmdir($tmpDir);
    }

    public function getBinaryPath()
    {
        return static::getBinaryFolder().static::getBinaryName();
    }

    public function getBinaryFolder()
    {
        $d = DIRECTORY_SEPARATOR;

        return realpath(__DIR__.$d.'..').$d.'lib'.$d;
    }

    public function getBinaryName()
    {
        if (PHP_OS_FAMILY === 'Windows') {
            return 'gum.exe';
        }

        return 'gum';
    }

    protected function getBinaryUrl()
    {
        $os = PHP_OS_FAMILY;
        $arch = php_uname('m');

        $base = 'https://github.com/charmbracelet/gum/releases/download/v'.self::GUM_VERSION.'/gum_'.self::GUM_VERSION;

        if ($os === 'Windows' && $arch === 'i386') {
            return $base.'_Windows_i386.zip';
        }
        if ($os === 'Windows') {
            return $base.'_Windows_x86_64.zip';
        }

        if ($os === 'Darwin' && $arch === 'arm64') {
            return $base.'_Darwin_arm64.tar.gz';
        }
        if ($os === 'Darwin') {
            return $base.'_Darwin_x86_64.tar.gz';
        }

        if ($os === 'Linux') {
            return $base.'_linux_x86_64.tar.gz';
        }

        throw new Exception("Platform $os $arch is not supported.");
    }
}
