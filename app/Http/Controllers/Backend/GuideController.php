<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;

/**
 * Shows the guides in docs/ so they can be read while signed in. Edit the
 * markdown files to change them.
 */
class GuideController extends Controller
{
    /**
     * Guides by the name used in the address bar.
     */
    public const GUIDES = [
        'staff' => ['title' => 'Help', 'path' => 'docs/backend-guide.md'],
        'developer' => ['title' => 'Developer Guide', 'path' => 'docs/developer-guide.md'],
    ];

    public function show(string $guide = 'staff')
    {
        abort_unless(isset(self::GUIDES[$guide]), 404);

        $title = self::GUIDES[$guide]['title'];

        $html = Str::markdown(file_get_contents(base_path(self::GUIDES[$guide]['path'])), [
            'html_input' => 'strip',
            // Give headings ids that match the guides' contents links,
            // e.g. "## Signing in" gets id="signing-in"
            'heading_permalink' => [
                'apply_id_to_heading' => true,
                'id_prefix' => '',
                'fragment_prefix' => '',
                'symbol' => '',
            ],
        ], [new HeadingPermalinkExtension()]);

        return view('backend.guide', ['guide' => $this->fixLinks($html), 'title' => $title]);
    }

    /**
     * The guides link to each other and to source files by relative path,
     * which works in an editor but not here. Point links between guides at
     * their backend pages, and show links to source files as plain text.
     */
    private function fixLinks(string $html): string
    {
        foreach (self::GUIDES as $name => $guide) {
            $html = str_replace(
                'href="' . basename($guide['path']) . '"',
                'href="' . route('backend.guide', $name) . '"',
                $html
            );
        }

        return preg_replace('#<a href="\.\./[^"]*">(.*?)</a>#s', '$1', $html);
    }
}
