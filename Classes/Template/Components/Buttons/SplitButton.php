<?php

declare(strict_types=1);

namespace Extrameile\EmSysNote\Template\Components\Buttons;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */


/**
 * SplitButton
 *
 * This button type renders a bootstrap split button.
 * It takes multiple button objects as parameters
 *
 * EXAMPLE USAGE TO ADD A SPLIT BUTTON TO THE FIRST BUTTON GROUP IN THE LEFT BAR:
 *
 * $buttonBar = $this->moduleTemplate->getDocHeaderComponent()->getButtonBar();
 *
 * $saveButton = $buttonBar->makeInputButton()
 *      ->setName('save')
 *      ->setValue('1')
 *      ->setIcon($this->iconFactory->getIcon('actions-document-save', Icon::SIZE_SMALL))
 *      ->setTitle('Save');
 *
 * $saveAndCloseButton = $buttonBar->makeInputButton()
 *      ->setName('save_and_close')
 *      ->setValue('1')
 *      ->setTitle('Save and close')
 *      ->setIcon($this->iconFactory->getIcon('actions-document-save-close', Icon::SIZE_SMALL));
 *
 * $saveAndShowPageButton = $buttonBar->makeInputButton()
 *      ->setName('save_and_show')
 *      ->setValue('1')
 *      ->setTitle('Save and show')
 *      ->setIcon($this->iconFactory->getIcon('actions-document-save-view', Icon::SIZE_SMALL));
 *
 * $splitButtonElement = $buttonBar->makeSplitButton()
 *      ->addItem($saveButton, TRUE)
 *      ->addItem($saveAndCloseButton)
 *      ->addItem($saveAndShowPageButton);
 */
class SplitButton extends \TYPO3\CMS\Backend\Template\Components\Buttons\SplitButton
{

    /**
     * Renders the HTML markup of the button
     *
     * @return string
     */
    public function render(): string
    {
        $items = $this->getButton();
        $attributes = [
            'type' => 'submit',
            'class' => 'btn btn-sm btn-default ' . $items['primary']->getClasses(),
        ];
        $attributesString = '';

        foreach ($attributes as $key => $value) {
            $attributesString .= ' ' . \htmlspecialchars($key) . '="' . \htmlspecialchars($value) . '"';
        }

        $content = '
        <div class="btn-group t3js-splitbutton">
            <button' . $attributesString . '>
                <a href="' . $items['primary']->getHref() . '">
                ' . $items['primary']->getIcon()->render('inline') . '
                ' . \htmlspecialchars($items['primary']->getTitle()) . '
                </a>
            </button>
            <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">';

        $content .= $this->renderOptions($items['options']);

        $content .= '
            </ul>
        </div>
        ';

        return $content;
    }

    /**
     * @param \TYPO3\CMS\Backend\Template\Components\Buttons\LinkButton[] $options
     * @return string
     */
    private function renderOptions(array $options): string
    {
        $content = '';

        /** @var \TYPO3\CMS\Backend\Template\Components\Buttons\LinkButton $option */
        foreach ($options as $option) {
            $optionAttributes = [
                'href' => $option->getHref(),
                'title' => $option->getTitle(),
            ];

            if (!empty($option->getClasses())) {
                $optionAttributes['class'] = $option->getClasses();
            }

            $optionAttributesString = '';

            foreach ($optionAttributes as $key => $value) {
                $optionAttributesString .= ' ' . \htmlspecialchars($key) . '="' . \htmlspecialchars($value) . '"';
            }

            $content .= '
                <li>
                    <a' . $optionAttributesString . '>' . $option->getIcon()->render('inline') . ' '
                . \htmlspecialchars($option->getTitle()) . '</a>
                </li>
            ';
        }

        return $content;
    }
}
