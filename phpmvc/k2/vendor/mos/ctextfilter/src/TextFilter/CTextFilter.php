<?php

namespace Mos\TextFilter;

/**
 * Filter and format content.
 *
 */
class CTextFilter
{
    /**
     * Supported filters.
     */
    private $filters = [
        "jsonfrontmatter",
        "yamlfrontmatter",
        "bbcode",
        "clickable",
        "shortcode",
        "markdown",
        "nl2br",
        "purify",
        "titlefromh1",
     ];



     /**
      * Current document parsed.
      */
    private $current;



    /**
     * Call each filter.
     *
     * @deprecated deprecated since version 1.2 in favour of parse().
     *
     * @param string       $text    the text to filter.
     * @param string|array $filters as comma separated list of filter,
     *                              or filters sent in as array.
     *
     * @return string the formatted text.
     */
    public function doFilter($text, $filters)
    {
        // Define all valid filters with their callback function.
        $callbacks = [
            'bbcode'    => 'bbcode2html',
            'clickable' => 'makeClickable',
            'shortcode' => 'shortCode',
            'markdown'  => 'markdown',
            'nl2br'     => 'nl2br',
            'purify'    => 'purify',
        ];

        // Make an array of the comma separated string $filters
        if (is_array($filters)) {
            $filter = $filters;
        } else {
            $filters = strtolower($filters);
            $filter = preg_replace('/\s/', '', explode(',', $filters));
        }

        // For each filter, call its function with the $text as parameter.
        foreach ($filter as $key) {

            if (!isset($callbacks[$key])) {
                throw new Exception("The filter '$filters' is not a valid filter string due to '$key'.");
            }
            $text = call_user_func_array([$this, $callbacks[$key]], [$text]);
        }

        return $text;
    }



    /**
     * Return an array of all filters supported.
     *
     * @return array with strings of filters supported.
     */
    public function getFilters()
    {
        return $this->filters;
    }



    /**
     * Check if filter is supported.
     *
     * @param string $filter to use.
     *
     * @throws mos/TextFilter/Exception  when filter does not exists.
     *
     * @return boolean true if filter exists, false othwerwise.
     */
    public function hasFilter($filter)
    {
        return in_array($filter, $this->filters);
    }



    /**
     * Add array items to frontmatter.
     *
     * @param array|null $matter key value array with items to add
     *                           or null if empty.
     *
     * @return $this
     */
    private function addToFrontmatter($matter)
    {
        if (empty($matter)) {
            return $this;
        }

        if (is_null($this->current->frontmatter)) {
            $this->current->frontmatter = [];
        }

        $this->current->frontmatter = array_merge_recursive($this->current->frontmatter, $matter);
        return $this;
    }



    /**
     * Call a specific filter and store its details.
     *
     * @param string $filter to use.
     *
     * @throws mos/TextFilter/Exception  when filter does not exists.
     *
     * @return string the formatted text.
     */
    private function parseFactory($filter)
    {
        // Define single tasks filter with a callback.
        $callbacks = [
            "bbcode"    => "bbcode2html",
            "clickable" => "makeClickable",
            "shortcode" => "shortCode",
            "markdown"  => "markdown",
            "nl2br"     => "nl2br",
            "purify"    => "purify",
        ];

        // Do the specific filter
        $text = $this->current->text;
        switch ($filter) {
            case "jsonfrontmatter":
                $res = $this->jsonFrontMatter($text);
                $this->current->text = $res["text"];
                $this->addToFrontmatter($res["frontmatter"]);
                break;

            case "yamlfrontmatter":
                $res = $this->yamlFrontMatter($text);
                $this->current->text = $res["text"];
                $this->addToFrontmatter($res["frontmatter"]);
                break;

            case "titlefromh1":
                $title = $this->getTitleFromFirstH1($text);
                $this->current->text = $text;
                $this->addToFrontmatter(["title" => $title]);
                break;

            case "bbcode":
            case "clickable":
            case "shortcode":
            case "markdown":
            case "nl2br":
            case "purify":
                $this->current->text = call_user_func_array(
                    [$this, $callbacks[$filter]],
                    [$text]
                );
                break;

            default:
                throw new Exception("The filter '$filter' is not a valid filter     string.");
        }
    }



    /**
     * Call each filter and return array with details of the formatted content.
     *
     * @param string $text   the text to filter.
     * @param array  $filter array of filters to use.
     *
     * @throws mos/TextFilter/Exception  when filterd does not exists.
     *
     * @return array with the formatted text and additional details.
     */
    public function parse($text, $filter)
    {
        $this->current = new \stdClass();
        $this->current->frontmatter = null;
        $this->current->text = $text;

        foreach ($filter as $key) {
            $this->parseFactory($key);
        }

        return $this->current;
    }



    /**
     * Extract front matter from text.
     *
     * @param string $text       the text to be parsed.
     * @param string $startToken the start token.
     * @param string $stopToken  the stop token.
     *
     * @return array with the formatted text and the front matter.
     */
    private function extractFrontMatter($text, $startToken, $stopToken)
    {
        $tokenLength = strlen($startToken);

        $start = strpos($text, $startToken);
        
        $frontmatter = null;
        if ($start !== false) {
            $stop = strpos($text, $stopToken, $tokenLength - 1);

            if ($stop !== false) {
                $length = $stop - ($start + $tokenLength);

                $frontmatter = substr($text, $start + $tokenLength, $length);
                $textStart = substr($text, 0, $start);
                $text = $textStart . substr($text, $stop + $tokenLength);
            }
        }

        return [$text, $frontmatter];
    }



    /**
     * Extract JSON front matter from text.
     *
     * @param string $text the text to be parsed.
     *
     * @return array with the formatted text and the front matter.
     */
    public function jsonFrontMatter($text)
    {
        list($text, $frontmatter) = $this->extractFrontMatter($text, "{{{\n", "}}}\n");

        if (!empty($frontmatter)) {
            $frontmatter = json_decode($frontmatter, true);

            if (is_null($frontmatter)) {
                throw new Exception("Failed parsing JSON frontmatter.");
            }
        }

        return [
            "text" => $text,
            "frontmatter" => $frontmatter
        ];
    }



    /**
     * Extract YAML front matter from text.
     *
     * @param string $text the text to be parsed.
     *
     * @return array with the formatted text and the front matter.
     */
    public function yamlFrontMatter($text)
    {
        $needle = "---\n";
        list($text, $frontmatter) = $this->extractFrontMatter($text, $needle, $needle);

        if (function_exists("yaml_parse") && !empty($frontmatter)) {
            $frontmatter = yaml_parse($needle . $frontmatter);

            if ($frontmatter === false) {
                throw new Exception("Failed parsing YAML frontmatter.");
            }
        }

        return [
            "text" => $text,
            "frontmatter" => $frontmatter
        ];
    }



    /**
     * Get the title from the first H1.
     *
     * @param string $text the text to be parsed.
     *
     * @return string|null with the title, if its found.
     */
    public function getTitleFromFirstH1($text)
    {
        $matches = [];
        $title = null;

        if (preg_match("#<h1.*?>(.*)</h1>#", $text, $matches)) {
            $title = strip_tags($matches[1]);
        }

        return $title;
    }



    /**
     * Helper, BBCode formatting converting to HTML.
     *
     * @param string $text The text to be converted.
     *
     * @return string the formatted text.
     *
     * @link http://dbwebb.se/coachen/reguljara-uttryck-i-php-ger-bbcode-formattering
     */
    public function bbcode2html($text)
    {
        $search = [
            '/\[b\](.*?)\[\/b\]/is',
            '/\[i\](.*?)\[\/i\]/is',
            '/\[u\](.*?)\[\/u\]/is',
            '/\[img\](https?.*?)\[\/img\]/is',
            '/\[url\](https?.*?)\[\/url\]/is',
            '/\[url=(https?.*?)\](.*?)\[\/url\]/is'
        ];

        $replace = [
            '<strong>$1</strong>',
            '<em>$1</em>',
            '<u>$1</u>',
            '<img src="$1" />',
            '<a href="$1">$1</a>',
            '<a href="$1">$2</a>'
        ];

        return preg_replace($search, $replace, $text);
    }



    /**
     * Make clickable links from URLs in text.
     *
     * @param string $text the text that should be formatted.
     *
     * @return string with formatted anchors.
     *
     * @link http://dbwebb.se/coachen/lat-php-funktion-make-clickable-automatiskt-skapa-klickbara-lankar
     */
    public function makeClickable($text)
    {
        return preg_replace_callback(
            '#\b(?<![href|src]=[\'"])https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
            function ($matches) {
                return "<a href='{$matches[0]}'>{$matches[0]}</a>";
            },
            $text
        );
    }



    /**
     * Format text according to HTML Purifier.
     *
     * @param string $text that should be formatted.
     *
     * @return string as the formatted html-text.
     */
    public function purify($text)
    {
        $config   = \HTMLPurifier_Config::createDefault();
        $config->set("Cache.DefinitionImpl", null);
        //$config->set('Cache.SerializerPath', '/home/user/absolute/path');

        $purifier = new \HTMLPurifier($config);
    
        return $purifier->purify($text);
    }



    /**
     * Format text according to Markdown syntax.
     *
     * @param string $text the text that should be formatted.
     *
     * @return string as the formatted html-text.
     */
    public function markdown($text)
    {
        return \Michelf\MarkdownExtra::defaultTransform($text);
    }



    /**
     * For convenience access to nl2br
     *
     * @param string $text text to be converted.
     *
     * @return string the formatted text.
     */
    public function nl2br($text)
    {
        return nl2br($text);
    }



    /**
     * Shortcode to to quicker format text as HTML.
     *
     * @param string $text text to be converted.
     *
     * @return string the formatted text.
     */
    public function shortCode($text)
    {
        $patterns = [
            '/\[(FIGURE)[\s+](.+)\]/',
        ];

        return preg_replace_callback(
            $patterns,
            function ($matches) {
                switch ($matches[1]) {

                    case 'FIGURE':
                        return self::ShortCodeFigure($matches[2]);
                        break;

                    default:
                        return "{$matches[1]} is unknown shortcode.";
                }
            },
            $text
        );
    }



    /**
     * Init shortcode handling by preparing the option list to an array, for those using arguments.
     *
     * @param string $options for the shortcode.
     *
     * @return array with all the options.
     */
    public static function shortCodeInit($options)
    {
        preg_match_all('/[a-zA-Z0-9]+="[^"]+"|\S+/', $options, $matches);

        $res = array();
        foreach ($matches[0] as $match) {
            $pos = strpos($match, '=');
            if ($pos === false) {
                $res[$match] = true;
            } else {
                $key = substr($match, 0, $pos);
                $val = trim(substr($match, $pos+1), '"');
                $res[$key] = $val;
            }
        }

        return $res;
    }



    /**
     * Shortcode for <figure>.
     *
     * Usage example: [FIGURE src="img/home/me.jpg" caption="Me" alt="Bild på mig" nolink="nolink"]
     *
     * @param string $options for the shortcode.
     *
     * @return array with all the options.
     */
    public static function shortCodeFigure($options)
    {
        // Merge incoming options with default and expose as variables
        $options= array_merge(
            [
                'id' => null,
                'class' => null,
                'src' => null,
                'title' => null,
                'alt' => null,
                'caption' => null,
                'href' => null,
                'nolink' => false,
            ],
            self::ShortCodeInit($options)
        );
        extract($options, EXTR_SKIP);

        $id = $id ? " id='$id'" : null;
        $class = $class ? " class='figure $class'" : " class='figure'";
        $title = $title ? " title='$title'" : null;

        if (!$alt && $caption) {
            $alt = $caption;
        }

        if (!$href) {
            $pos = strpos($src, '?');
            $href = $pos ? substr($src, 0, $pos) : $src;
        }

        $start = null;
        $end = null;
        if (!$nolink) {
            $start = "<a href='{$href}'>";
            $end = "</a>";
        }

        $html = <<<EOD
<figure{$id}{$class}>
{$start}<img src='{$src}' alt='{$alt}'{$title}/>{$end}
<figcaption markdown=1>{$caption}</figcaption>
</figure>
EOD;

        return $html;
    }
}
