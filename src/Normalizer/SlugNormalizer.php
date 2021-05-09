<?php

declare(strict_types=1);

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\CommonMark\Normalizer;

/**
 * Creates URL-friendly strings based on the given string input
 *
 * @psalm-immutable
 */
final class SlugNormalizer implements TextNormalizerInterface
{
    /**
     * {@inheritdoc}
     *
     * @psalm-pure
     */
    public function normalize(string $text, array $context = []): string
    {
        // Add any requested prefix
        $slug = ($context['prefix'] ?? '') . $text;
        // Trim whitespace
        $slug = \trim($slug);
        // Convert to lowercase
        $slug = \mb_strtolower($slug);
        // Try replacing whitespace with a dash
        $slug = \preg_replace('/\s+/u', '-', $slug) ?? $slug;
        // Try removing characters other than letters, numbers, and marks.
        $slug = \preg_replace('/[^\p{L}\p{Nd}\p{Nl}\p{M}-]+/u', '', $slug) ?? $slug;
        // Trim to requested length if given
        if ($length = $context['length'] ?? false) {
            $slug = \mb_substr($slug, 0, $length);
        }

        return $slug;
    }
}
