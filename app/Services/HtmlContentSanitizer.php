<?php

namespace App\Services;

use DOMDocument;
use DOMElement;
use DOMNode;

class HtmlContentSanitizer
{
    private const ALLOWED_TAGS = [
        'p', 'br', 'strong', 'em', 'b', 'i', 'u', 'h2', 'h3', 'h4',
        'ul', 'ol', 'li', 'blockquote', 'a', 'img', 'figure', 'figcaption',
    ];

    private const ALLOWED_ATTRIBUTES = [
        'a' => ['href', 'title', 'target', 'rel'],
        'img' => ['src', 'alt', 'title', 'width', 'height', 'loading', 'decoding'],
    ];

    public function sanitizePreservingLineBreaks(?string $content): ?string
    {
        $content = trim((string) $content);

        if ($content === '') {
            return null;
        }

        if ($content !== strip_tags($content)) {
            return $this->sanitize($content);
        }

        $content = str_replace(["\r\n", "\r"], "\n", $content);
        $paragraphs = preg_split('/\n{2,}/', $content) ?: [];

        return implode('', array_map(static function (string $paragraph): string {
            $escaped = htmlspecialchars(trim($paragraph), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

            return '<p>' . nl2br($escaped, false) . '</p>';
        }, array_filter($paragraphs, static fn (string $paragraph): bool => trim($paragraph) !== '')));
    }

    public function sanitize(?string $html): ?string
    {
        $html = trim((string) $html);

        if ($html === '') {
            return null;
        }

        if (!class_exists(DOMDocument::class)) {
            return $this->safeTextFallback($html);
        }

        $document = new DOMDocument('1.0', 'UTF-8');
        $previousErrors = libxml_use_internal_errors(true);
        $document->loadHTML(
            '<?xml encoding="UTF-8"><div id="seo-content-root">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();
        libxml_use_internal_errors($previousErrors);

        $root = $document->getElementById('seo-content-root');

        if (!$root) {
            return $this->safeTextFallback($html);
        }

        $this->sanitizeChildren($root);

        $clean = '';
        foreach ($root->childNodes as $child) {
            $clean .= $document->saveHTML($child);
        }

        return trim($clean) ?: null;
    }

    private function sanitizeChildren(DOMNode $parent): void
    {
        for ($node = $parent->firstChild; $node !== null;) {
            $next = $node->nextSibling;

            if ($node instanceof DOMElement) {
                $tag = strtolower($node->tagName);

                if (!in_array($tag, self::ALLOWED_TAGS, true)) {
                    if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed'], true)) {
                        $parent->removeChild($node);
                        $node = $next;
                        continue;
                    }

                    $this->sanitizeChildren($node);
                    while ($node->firstChild) {
                        $parent->insertBefore($node->firstChild, $node);
                    }
                    $parent->removeChild($node);
                } else {
                    $this->sanitizeAttributes($node, $tag);
                    $this->sanitizeChildren($node);
                }
            }

            $node = $next;
        }
    }

    private function sanitizeAttributes(DOMElement $element, string $tag): void
    {
        $allowed = self::ALLOWED_ATTRIBUTES[$tag] ?? [];

        for ($index = $element->attributes->length - 1; $index >= 0; $index--) {
            $attribute = $element->attributes->item($index);

            if (!$attribute || !in_array(strtolower($attribute->name), $allowed, true)) {
                if ($attribute) {
                    $element->removeAttributeNode($attribute);
                }
            }
        }

        if ($tag === 'a') {
            if (!$this->isSafeUrl($element->getAttribute('href'), true)) {
                $element->removeAttribute('href');
            }

            if ($element->getAttribute('target') === '_blank') {
                $element->setAttribute('rel', 'noopener noreferrer');
            } else {
                $element->removeAttribute('target');
                $element->removeAttribute('rel');
            }
        }

        if ($tag === 'img') {
            if (!$this->isSafeUrl($element->getAttribute('src'), false)) {
                $element->parentNode?->removeChild($element);
                return;
            }

            $element->setAttribute('loading', 'lazy');
            $element->setAttribute('decoding', 'async');
        }
    }

    private function isSafeUrl(string $url, bool $allowContactSchemes): bool
    {
        $url = trim($url);

        if ($url === '') {
            return false;
        }

        if ($url[0] === '/' || $url[0] === '#') {
            return true;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
        $allowedSchemes = $allowContactSchemes ? ['http', 'https', 'mailto', 'tel'] : ['http', 'https'];

        return $scheme === '' || in_array($scheme, $allowedSchemes, true);
    }

    private function safeTextFallback(string $html): string
    {
        $text = trim(strip_tags($html));

        return $text === '' ? '' : '<p>' . htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</p>';
    }
}
