<?php

declare(strict_types=1);

namespace TFHInc\ArtisanFormat\Traits;

use Illuminate\Console\Command;

/**
 * Artisan Format - Sections
 *
 * Format sections of information that are easy to read.
 */
trait ArtisanFormatSections
{
    /**
     * Print a Section Divider
     *
     * @param string $style
     * @param boolean $top
     * @param boolean $bottom
     * @return Illuminate\Console\Command $this
     */
    public function sectionDivider(string $style = null, bool $top = false, bool $bottom = false)
    {
        if ($top) {

            $this->line(
                config('artisan-format.sections.top_prefix') .
                str_repeat(config('artisan-format.sections.divider_character'), config('artisan-format.sections.divider_length')) .
                addslashes(config('artisan-format.sections.top_suffix')),
                $style
            );

        } elseif ($bottom) {

            $this->line(
                config('artisan-format.sections.bottom_prefix') .
                str_repeat(config('artisan-format.sections.divider_character'), config('artisan-format.sections.divider_length')) .
                config('artisan-format.sections.bottom_suffix'),
                $style
            );

        } else {

            $this->line(
                config('artisan-format.sections.line_prefix') .
                str_repeat(config('artisan-format.sections.header_divider_character'), config('artisan-format.sections.divider_length')) .
                config('artisan-format.sections.line_suffix'),
                $style
            );

        }

        return $this;
    }

    /**
     * Print a Top Section Divider
     *
     * @param string $style
     * @return Illuminate\Console\Command $this
     */
    public function sectionDividerTop(string $style = null)
    {
        $this->sectionDivider($style, true, false);

        return $this;
    }

    /**
     * Print a Bottom Section Divider
     *
     * @param string $style
     * @return Illuminate\Console\Command $this
     */
    public function sectionDividerBottom(string $style = null)
    {
        $this->sectionLineBreak($style);
        $this->sectionDivider($style, false, true);

        return $this;
    }

    /**
     * Print a Section Line
     *
     * @param string $string
     * @param string $style
     * @return Illuminate\Console\Command $this
     */
    public function sectionLine(string $string, string $style = null)
    {
        $this->sectionLineBreak($style);

        $chunks = explode("~!#", wordwrap($string, (config('artisan-format.sections.divider_length') - 3), "~!#"));

        foreach ($chunks as $string) {

            $formatted_full_string = config('artisan-format.sections.line_prefix') . ' ' . $string;
            $formatted_full_string_length = (int) strlen($formatted_full_string);
            $remaining_line_space_length = (int) ((config('artisan-format.sections.divider_length') - $formatted_full_string_length) + 1);

            if ($remaining_line_space_length > 0) {
                $white_space = str_repeat(" ", $remaining_line_space_length) . config('artisan-format.sections.line_suffix');
            } else {
                $white_space = config('artisan-format.sections.line_suffix');
            }

            $this->line($formatted_full_string . $white_space, $style);

        }

        return $this;
    }

    /**
     * Print a Section Info Line
     *
     * @param string $string
     * @return Illuminate\Console\Command $this
     */
    public function sectionLineInfo(string $string)
    {
        $this->sectionLine($string, 'info');
        
        return $this;
    }

    /**
     * Print a Section Comment Line
     *
     * @param string $string
     * @return Illuminate\Console\Command $this
     */
    public function sectionLineComment(string $string)
    {
        $this->sectionLine($string, 'comment');
        
        return $this;
    }

    /**
     * Print a Section Question Line
     *
     * @param string $string
     * @return Illuminate\Console\Command $this
     */
    public function sectionLineQuestion(string $string)
    {
        $this->sectionLine($string, 'question');
        
        return $this;
    }

    /**
     * Print a Section Error Line
     *
     * @param string $string
     * @return Illuminate\Console\Command $this
     */
    public function sectionLineError(string $string)
    {
        $this->sectionLine($string, 'error');
        
        return $this;
    }

    /**
     * Print a Section Box
     *
     * @param string $header
     * @param array|string|null $content
     * @param null|string |null$style
     * @return Illuminate\Console\Command $this
     */
    public function sectionBox(string $header, $content = null, string $style = null)
    {
        $this->sectionDividerTop($style);
        $this->sectionLine($header, $style);

        if (gettype($content) !== 'NULL') {
        
            $this->sectionLineBreak($style);
            $this->sectionDivider($style, false, false);

        }

        if (gettype($content) === 'string') {

            $this->sectionLine($content, $style);

        } elseif (gettype($content) === 'array') {

            foreach ($content as $key => $string) {
                $this->sectionLine(((gettype($key) === 'string') ? $key . ' => ' : null) . (string) $string, $style);
            }

        }

        $this->sectionDividerBottom($style);

        return $this;
    }

    /**
     * Print an Info Section Box
     *
     * @param string $header
     * @param array|string|null $content
     * @return Illuminate\Console\Command $this
     */
    public function sectionBoxInfo(string $header, $content = null)
    {
        $this->sectionBox($header, $content, 'info');

        return $this;
    }

    /**
     * Print an Comment Section Box
     *
     * @param string $header
     * @param array|string|null $content
     * @return Illuminate\Console\Command $this
     */
    public function sectionBoxComment(string $header, $content = null)
    {
        $this->sectionBox($header, $content, 'comment');

        return $this;
    }

    /**
     * Print an Question Section Box
     *
     * @param string $header
     * @param array|string|null $content
     * @return Illuminate\Console\Command $this
     */
    public function sectionBoxQuestion(string $header, $content = null)
    {
        $this->sectionBox($header, $content, 'question');

        return $this;
    }

    /**
     * Print an Error Section Box
     *
     * @param string $header
     * @param array|string|null $content
     * @return Illuminate\Console\Command $this
     */
    public function sectionBoxError(string $header, $content = null)
    {
        $this->sectionBox($header, $content, 'error');

        return $this;
    }

    /**
     * Print a Section line break, with prefix and suffix, a given number of times
     *
     * @param string $style
     * @return Illuminate\Console\Command $this
     */
    public function sectionLineBreak(string $style = null)
    {
        foreach (range(1, config('artisan-format.sections.line_break_size')) as $increment) {
            $this->line(config('artisan-format.sections.line_prefix') . str_repeat(' ', config('artisan-format.sections.divider_length')) . config('artisan-format.sections.line_suffix'), $style);
        }

        return $this;
    }
}