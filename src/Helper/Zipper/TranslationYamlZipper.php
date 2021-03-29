<?php

namespace App\Helper\Zipper;

use Symfony\Component\Yaml\Yaml;
use ZipArchive;

class TranslationYamlZipper extends TranslationZipper
{
    public const FILENAME = 'translations';
    public const YAML_EXTENSION = 'yaml';

    protected function addFiles(ZipArchive $zip): void
    {
        $groupedTranslations = $this->groupTranslations();
        $yaml = Yaml::dump($groupedTranslations);
        $zip->addFromString(sprintf('%s.%s', self::FILENAME, self::YAML_EXTENSION), $yaml);
    }
}
