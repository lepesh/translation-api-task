<?php
declare(strict_types=1);

namespace App\Helper\Zipper;

use App\Entity\Translation;
use App\Helper\TokenHelper;
use ZipArchive;

abstract class TranslationZipper
{
    private const TEMP_PATH = '/tmp';

    /** @var array|Translation[] */
    private array $translations;

    public function __construct(array $translations)
    {
        $this->translations = $translations;
    }

    /**
     * @return string zip file content
     */
    public function zip(): string
    {
        $filePath = sprintf('%s/%s.zip', self::TEMP_PATH, TokenHelper::generateToken());
        $zip = new ZipArchive();
        if ($zip->open($filePath, ZipArchive::CREATE) === true) {
            $this->addFiles($zip);
            $zip->close();
        }
        $content = file_get_contents($filePath);
        // remove temporary zip file
        unlink($filePath);

        return $content;
    }

    protected function groupTranslations(): array
    {
        $groupedTranslations = [];
        foreach ($this->translations as $translation) {
            $language = $translation->getLanguage()->getIsoCode();
            $key = $translation->getTranslationKey()->getName();
            $groupedTranslations[$language][$key] = $translation->getValue();
        }

        return $groupedTranslations;
    }

    abstract protected function addFiles(ZipArchive $zip): void;
}
