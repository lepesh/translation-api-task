<?php
declare(strict_types=1);

namespace App\Helper\Zipper;

use ZipArchive;

class TranslationJsonZipper extends TranslationZipper
{
    public const JSON_EXTENSION = 'json';

    protected function addFiles(ZipArchive $zip): void
    {
        $groupedTranslations = $this->groupTranslations();
        foreach ($groupedTranslations as $langIso => $groupedTranslation) {
            $filename = sprintf('%s.%s', $langIso, self::JSON_EXTENSION);
            $zip->addFromString($filename, json_encode($groupedTranslation));
        }
    }
}
