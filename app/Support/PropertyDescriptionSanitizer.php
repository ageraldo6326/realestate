<?php

namespace App\Support;

use DOMComment;
use DOMDocument;
use DOMElement;
use DOMNode;

class PropertyDescriptionSanitizer
{
    private const ALLOWED_TAGS = [
        'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's', 'blockquote',
        'ul', 'ol', 'li', 'h1', 'h2', 'h3', 'h4', 'a',
    ];

    private const DROP_CONTENT_TAGS = [
        'script', 'style', 'iframe', 'object', 'embed', 'form', 'input', 'svg', 'math',
    ];

    /**
     * Conserva el marcado editorial permitido de CKEditor sin exponer HTML activo.
     */
    public static function sanitize($html): string
    {
        $html = trim((string) $html);

        if ($html === '') {
            return '';
        }

        if (! class_exists(DOMDocument::class)) {
            return nl2br(htmlspecialchars(strip_tags($html), ENT_QUOTES, 'UTF-8'));
        }

        $previousUseInternalErrors = libxml_use_internal_errors(true);

        try {
            $document = new DOMDocument('1.0', 'UTF-8');
            $document->loadHTML(
                '<?xml encoding="UTF-8"><div id="property-description-root">' . $html . '</div>',
                LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
            );

            $root = $document->getElementById('property-description-root');

            if (! $root instanceof DOMElement) {
                return nl2br(htmlspecialchars(strip_tags($html), ENT_QUOTES, 'UTF-8'));
            }

            self::sanitizeChildren($root);

            $sanitized = '';
            foreach (iterator_to_array($root->childNodes) as $child) {
                $sanitized .= $document->saveHTML($child);
            }

            return trim($sanitized);
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previousUseInternalErrors);
        }
    }

    private static function sanitizeChildren(DOMNode $node): void
    {
        foreach (iterator_to_array($node->childNodes) as $child) {
            if ($child instanceof DOMComment) {
                $node->removeChild($child);
                continue;
            }

            if (! $child instanceof DOMElement) {
                continue;
            }

            $tagName = strtolower($child->tagName);

            if (in_array($tagName, self::DROP_CONTENT_TAGS, true)) {
                $node->removeChild($child);
                continue;
            }

            self::sanitizeChildren($child);

            if (! in_array($tagName, self::ALLOWED_TAGS, true)) {
                self::unwrap($child);
                continue;
            }

            self::sanitizeAttributes($child, $tagName);
        }
    }

    private static function unwrap(DOMElement $element): void
    {
        $parent = $element->parentNode;

        if (! $parent) {
            return;
        }

        while ($element->firstChild) {
            $parent->insertBefore($element->firstChild, $element);
        }

        $parent->removeChild($element);
    }

    private static function sanitizeAttributes(DOMElement $element, string $tagName): void
    {
        $allowedAttributes = $tagName === 'a' ? ['href', 'target', 'rel'] : [];

        foreach (iterator_to_array($element->attributes) as $attribute) {
            $attributeName = strtolower($attribute->name);

            if (! in_array($attributeName, $allowedAttributes, true)) {
                $element->removeAttributeNode($attribute);
                continue;
            }

            if ($attributeName === 'href' && ! self::isSafeUrl($attribute->value)) {
                $element->removeAttributeNode($attribute);
            }
        }

        if ($element->getAttribute('target') !== '_blank') {
            $element->removeAttribute('target');
        } else {
            $element->setAttribute('rel', 'noopener noreferrer');
        }
    }

    private static function isSafeUrl(string $url): bool
    {
        $url = preg_replace('/[\x00-\x20]+/u', '', html_entity_decode($url, ENT_QUOTES, 'UTF-8'));

        if (! preg_match('/^([a-z][a-z0-9+.-]*):/i', $url, $matches)) {
            return true;
        }

        return in_array(strtolower($matches[1]), ['http', 'https', 'mailto'], true);
    }
}
