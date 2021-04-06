<?php
declare(strict_types=1);

namespace App\Helper\Zipper;

use App\Helper\TokenHelper;
use App\Repository\TranslationRepository;
use ZipArchive;

abstract class TranslationZipper
{
    private const TEMP_PATH = '/tmp';

    private TranslationRepository $translationRepository;

    public function __construct(TranslationRepository $translationRepository)
    {
        $this->translationRepository = $translationRepository;
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
        $translations = $this->translationRepository->findAll();
        $groupedTranslations = [];
        foreach ($translations as $translation) {
            $language = $translation->getLanguage()->getIsoCode();
            $key = $translation->getTranslationKey()->getName();
            $groupedTranslations[$language][$key] = $translation->getValue();
        }

        return $groupedTranslations;
    }

    abstract protected function addFiles(ZipArchive $zip): void;
}
