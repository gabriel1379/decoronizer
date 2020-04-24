<?php

namespace LocalizationDataBuilder\Communication;

use LocalizationDataBuilder\Config\Config;

class Output
{
    protected const LINE_BREAK_HTML = '<br>';
    protected const LINE_BREAK_CONSOLE = '
    ';

    /**
     * @var \LocalizationDataBuilder\Config\Config $config
     */
    protected $config;

    /**
     * @param \LocalizationDataBuilder\Config\Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $text
     *
     * @return void
     */
    public function output(string $text): void
    {
        if (false === $this->config->isVerbose()) {
            return;
        }

        echo($text);
    }

    /**
     * @return void
     */
    public function renderHeader(): void
    {
        if (true === $this->config->isConsoleMode()) {
            return;
        }

        $this->output(file_get_contents(__DIR__ . '\Presentation\Theme\header.html'));
    }

    /**
     * @return void
     */
    public function renderFoot(): void
    {
        if (true === $this->config->isConsoleMode()) {
            return;
        }

        $this->output(file_get_contents(__DIR__ . '\Presentation\Theme\footer.html'));
    }

    /**
     * @return void
     */
    public function renderSeparatorLine(): void
    {
        if (true === $this->config->isConsoleMode()) {
            $separatorLine = $this->composeMessageLine('------------------------------------------%s');

            $this->output($separatorLine);

            return;
        }

        $this->output("<hr>");
    }

    /**
     * @param string $currentTargetFile
     * *
     * @return void
     */
    public function renderNewFileInfo(string $currentTargetFile): void
    {
        $processingNewFileHeaderMessage = $this
            ->composeMessageLine('--- %s.json ---%s', $currentTargetFile);

        $this->output($processingNewFileHeaderMessage);
    }

    /**
     * @param string $destinationFolder
     *
     * @return void
     */
    public function renderWriteFolderInfo(string $destinationFolder): void
    {
        $this->renderSeparatorLine();

        $folderCreatedMessage = $this
            ->composeMessageLine('Folder "%s" created.%s', $destinationFolder);

        $this->output($folderCreatedMessage);
    }

    /**
     * @param string $destinationFile
     *
     * @return void
     */
    public function renderInfoWrittenFile(string $destinationFile): void
    {
        $fileWrittenMessage = $this
            ->composeMessageLine('File "%s" written.%s', $destinationFile);

        $this->output($fileWrittenMessage);
    }

    /**
     * @param string $replacing
     * @param string $forLocale
     * @param int $count
     *
     * @return void
     */
    public function renderReplaceInfo(string $replacing, string $forLocale, int $count): void
    {
        if (true === $this->config->isConsoleMode()) {
            $lineBreak = $this->getLineBreak();
            $replacementMessage = sprintf(
                'Replace %s for %s : %s%s',
                $replacing,
                $forLocale,
                $count,
                $lineBreak
            );

            $this->output($replacementMessage);

            return;
        }

        $this->output('Replace 
        <span><b>' . $replacing . '</b></span> 
        for 
        <span>' . $forLocale . '</span> 
        : 
        <span>' . $count . '</span> 
        <br>\n');
    }

    /**
     * @param string $mainMessage
     * @param string $data
     *
     * @return string
     */
    protected function composeMessageLine(string $mainMessage, string $data = ''): string
    {
        $lineBreak = $this->getLineBreak();

        if ('' === $data) {
            $messageLine = sprintf($mainMessage, $lineBreak);

            return $messageLine;
        }

        $messageLine = sprintf($mainMessage, $data, $lineBreak);

        return $messageLine;
    }

    /**
     * @return string
     */
    protected function getLineBreak(): string
    {
        if (true === $this->config->isConsoleMode()) {
            return static::LINE_BREAK_CONSOLE;
        }

        return static::LINE_BREAK_HTML;
    }
}