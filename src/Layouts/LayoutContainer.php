<?php
/**
 * Class LayoutContainer
 *
 * Layout component for containing other elements.
 */

namespace DevinciIT\Modulr\Layouts;

class LayoutContainer
{
    /**
     * Render the container wrapper.
     *
     * This is a lightweight structural component.
     */
    public function render(string $content, array $options = []): string
    {
        $class = $options['class'] ?? 'container';
        $tag = $options['tag'] ?? 'div';

        return $this->wrap($content, $class, $tag);
    }

    /**
     * Core wrapping logic (single responsibility).
     */
    protected function wrap(string $content, string $class, string $tag): string
    {
        return sprintf(
            '<%s class="%s">%s</%s>',
            $tag,
            htmlspecialchars($class),
            $content,
            $tag
        );
    }
}