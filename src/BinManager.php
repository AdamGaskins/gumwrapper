<?php

namespace PhpGum;

use Composer\Script\Event;
use ZipArchive;

/** @internal */
class BinManager
{
    public const GUM_VERSION = '0.4.0';

    public static function installBinary(Event $event)
    {
        $config = $event->getComposer()->getConfig();
        $binaryFolder = $config->get('bin-dir');
        $binaryPath = $binaryFolder.'/'.self::getBinaryName();

        if (file_exists($binaryPath) && mb_stripos(exec($binaryPath.' --version'), 'v'.self::GUM_VERSION.' ') !== false) {
            echo 'Gum version '.self::GUM_VERSION." already downloaded.\n";

            return;
        }

        echo 'Downloading gum v'.self::GUM_VERSION." binary.\n";

        $tmpDir = sys_get_temp_dir().DIRECTORY_SEPARATOR.mt_rand();
        mkdir($tmpDir);

        $url = static::getBinaryUrl();
        echo "Downloading $url...\n";

        $compressedFile = $tmpDir.basename(parse_url($url, PHP_URL_PATH));
        file_put_contents($compressedFile, file_get_contents($url));

        echo "Extracting binary...\n";

        if (mb_stripos($compressedFile, '.tar.gz') !== false) {
            exec('tar -xf '.escapeshellarg($compressedFile).' -C '.escapeshellarg($binaryFolder).' gum');
        } elseif (mb_stripos($compressedFile, '.zip') !== false) {
            $zip = new ZipArchive();
            $zip->open($compressedFile, ZipArchive::RDONLY);
            $zip->extractTo($binaryFolder, 'gum.exe');
            $zip->close();
        }
    }

    public static function getBinaryPath()
    {
        return implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'vendor', 'bin', self::getBinaryName()]);
    }

    public static function getBinaryName()
    {
        if (PHP_OS_FAMILY === 'Windows') {
            return 'gum.exe';
        }

        return 'gum';
    }

    protected static function getBinaryUrl()
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

        return null;
    }
}
