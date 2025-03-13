<?php

namespace App\Utils;

class HtmlParser
{
    /**
     * Extract raw text content from HTML by removing all tags while preserving content structure
     *
     * @param  string $html The HTML content to parse
     * @return string The extracted plain text
     */
    public function getRawText(string $html): string
    {
        // Remove all style and script tags and their content
        $html = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $html);
        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);

        // Remove HTML comments
        $html = preg_replace('/<!--(.*?)-->/s', '', $html);

        // Define block-level elements that should have line breaks after them
        $blockElements = [
            'address', 'article', 'aside', 'blockquote', 'canvas', 'dd', 'div',
            'dl', 'dt', 'fieldset', 'figcaption', 'figure', 'footer', 'form',
            'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'header', 'hr', 'li', 'main',
            'nav', 'noscript', 'ol', 'p', 'pre', 'section', 'table', 'tfoot',
            'ul', 'video', 'tr', 'td', 'th',
        ];

        // Add line breaks after block elements for better readability
        foreach ($blockElements as $element) {
            $html = preg_replace('/<\/'.$element.'>/i', '</'.$element.">\n", $html);
        }

        // Replace <br> and <br/> with newlines
        $html = preg_replace('/<br\s*\/?>/i', "\n", $html);

        // Convert non-breaking spaces to regular spaces
        $html = str_replace('&nbsp;', ' ', $html);

        // Decode HTML entities
        $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Remove all remaining tags but keep their content
        $text = strip_tags($html);

        // Normalize whitespace
        $text = preg_replace('/\s+/', ' ', $text);

        // Remove extra line breaks and normalize spacing
        $text = preg_replace('/\n\s*\n/', "\n\n", $text);
        $text = trim($text);

        return $text;
    }
}
