<?php

declare(strict_types=1);

namespace Extrameile\EmSysNote\Factory;

use Extrameile\EmSysNote\Domain\Model\SysNote;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Template\Components\Buttons\LinkButton;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ButtonFactory
{
    /**
     * @var \TYPO3\CMS\Core\Imaging\IconFactory|null
     */
    private $iconFactory;
    /**
     * @var \TYPO3\CMS\Backend\Routing\UriBuilder|null
     */
    private $uriBuilder;

    public function __construct(?UriBuilder $uriBuilder = null, ?IconFactory $iconFactory = null)
    {
        $this->iconFactory = $iconFactory ?? GeneralUtility::makeInstance(IconFactory::class);
        $this->uriBuilder = $uriBuilder ?? GeneralUtility::makeInstance(UriBuilder::class);
    }

    public function getButton(string $table, int $pageId, int $noteCategory = SysNote::SYS_NOTE_TYPE_DEFAULT)
    {

        $icon = $this->iconFactory->getIcon('sysnote-type-' . $noteCategory, Icon::SIZE_SMALL);
        $link = $this->getLink($table, $pageId, $noteCategory);
        $type = $this->getLanguageService()->sL('LLL:EXT:em_sys_note/Resources/Private/Language/locallang.xlf:category.' . $noteCategory);

        return GeneralUtility::makeInstance(LinkButton::class)
            ->setIcon($icon)
            ->setHref($link)
            ->setTitle('Create ' . $type)
            ->setShowLabelText('Create ' . $type);
    }

    private function getLink(string $table, int $pageId, int $noteCategory = SysNote::SYS_NOTE_TYPE_DEFAULT): string
    {
        $params = [
            'edit' => [
                $table => [
                    $pageId => 'new',
                ],
            ],
            'defVals' => [
                $table => [
                    'position' => \TYPO3\CMS\SysNote\Domain\Repository\SysNoteRepository::SYS_NOTE_POSITION_TOP,
                    'category' => $noteCategory,
                ],
            ],
            'returnUrl' => GeneralUtility::getIndpEnv('REQUEST_URI'),
        ];

        return (string)$this->uriBuilder->buildUriFromRoute(
            'record_edit',
            $params
        );
    }


    /**
     * @return \TYPO3\CMS\Core\Localization\LanguageService
     */
    protected function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }
}
