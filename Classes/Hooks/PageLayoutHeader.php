<?php

declare(strict_types=1);

namespace Extrameile\EmSysNote\Hooks;

use Extrameile\EmSysNote\Domain\Model\SysNote;
use Extrameile\EmSysNote\Factory\ButtonFactory;
use Extrameile\EmSysNote\Template\Components\Buttons\SplitButton;
use TYPO3\CMS\Backend\Controller\PageLayoutController;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PageLayoutHeader
{
    public const TABLE = 'sys_note';

    /**
     * @var int $pageId
     */
    protected $pageId;

    /**
     * @var \Extrameile\EmSysNote\Factory\ButtonFactory
     */
    private $buttonFactory;

    public function __construct(?ButtonFactory $buttonFactory = null)
    {
        $this->pageId = (int)$GLOBALS['_GET']['id'];
        $this->buttonFactory = $buttonFactory ?? GeneralUtility::makeInstance(ButtonFactory::class);
    }

    /**
     * @param mixed[] $parameters
     * @param \TYPO3\CMS\Backend\Controller\PageLayoutController $pageLayoutController
     * @return string
     * @noinspection PhpUnusedParameterInspection
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function render($parameters, PageLayoutController $pageLayoutController)
    {
        if (!$this->hasTableAccess(static::TABLE)) {
            return '';
        }

        /** @var \TYPO3\CMS\Backend\Template\Components\ButtonBar $buttonBar */
        $buttonBar = $pageLayoutController->buttonBar;

        /** @var \Extrameile\EmSysNote\Template\Components\Buttons\SplitButton $splitButton */
        $splitButton = GeneralUtility::makeInstance(SplitButton::class);

        $splitButton->addItem($this->buttonFactory->getButton(static::TABLE, $this->pageId, SysNote::SYS_NOTE_TYPE_NOTE), true);
        $splitButton->addItem($this->buttonFactory->getButton(static::TABLE, $this->pageId, SysNote::SYS_NOTE_TYPE_TODO));
        $splitButton->addItem($this->buttonFactory->getButton(static::TABLE, $this->pageId, SysNote::SYS_NOTE_TYPE_TEMPLATE));
        $splitButton->addItem($this->buttonFactory->getButton(static::TABLE, $this->pageId, SysNote::SYS_NOTE_TYPE_INSTRUCTION));

        $buttonBar->addButton($splitButton, ButtonBar::BUTTON_POSITION_RIGHT, 5);

        // nothing to add, we only need the hook in place
        return '';
    }


    /**
     * Gets the current backend user.
     *
     * @return \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
     */
    protected function getBackendUser()
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     * Determines whether user has access to a table.
     *
     * @param string $table
     * @return bool
     */
    protected function hasTableAccess($table)
    {
        return $this->getBackendUser()->check('tables_select', $table);
    }
}
