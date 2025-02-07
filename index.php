<?php
/**
 * This script fetches HTML content from a provided URL, extracts HTML, Open Graph, and Twitter meta tags,
 * and generates a new HTML page with the extracted meta tags along with additional specified meta tags.
 *
 * @package MetaTag2FarcasterFrame
 */

/**
 * Fetch HTML content from a given URL.
 *
 * @param string $url The URL to fetch HTML content from.
 * @return string The fetched HTML content.
 */
function fetchHtmlContent($url) {
    $options = [
        'http' => [
            'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0\r\n"
        ]
    ];
    $context = stream_context_create($options);
    return file_get_contents($url, false, $context);
}

/**
 * Extract meta tags from HTML content.
 *
 * @param string $html The HTML content to extract meta tags from.
 * @return array An associative array of extracted meta tags.
 */
function extractMetaTags($html) {
    $doc = new DOMDocument();
    @$doc->loadHTML($html);
    $metaTags = [];

    // Fetching regular meta tags
    foreach ($doc->getElementsByTagName('meta') as $meta) {
        if ($meta->getAttribute('name')) {
            $metaTags['meta'][$meta->getAttribute('name')] = $meta->getAttribute('content');
        }
    }

    // Fetching Open Graph meta tags
    foreach ($doc->getElementsByTagName('meta') as $meta) {
        if ($meta->getAttribute('property')) {
            $metaTags['og'][$meta->getAttribute('property')] = $meta->getAttribute('content');
        }
    }

    // Fetching Twitter meta tags
    foreach ($doc->getElementsByTagName('meta') as $meta) {
        if ($meta->getAttribute('name') && strpos($meta->getAttribute('name'), 'twitter') !== false) {
            $metaTags['twitter'][$meta->getAttribute('name')] = $meta->getAttribute('content');
        }
    }

    return $metaTags;
}

/**
 * Generate new HTML with meta tags.
 *
 * @param array $metaTags An associative array of extracted meta tags.
 * @param array $additionalMetaTags An associative array of additional meta tags to be added.
 * @param string $url The URL value to be used for certain meta tags.
 * @return string The generated HTML content.
 */
function generateHtmlWithMetaTags($metaTags, $additionalMetaTags, $url) {
    $html = "<!DOCTYPE html>\n<html>\n<head>\n";

    // Adding extracted meta tags
    foreach ($metaTags as $type => $tags) {
        foreach ($tags as $name => $content) {
            $html .= "<meta " . ($type === 'og' ? 'property' : 'name') . "=\"$name\" content=\"$content\">\n";
        }
    }

    // Adding new meta tags
    foreach ($additionalMetaTags as $name => $content) {
        $html .= "<meta name=\"$name\" content=\"$content\">\n";
    }

    // Adding specific new meta tags based on the request
    if (isset($metaTags['og']['og:image'])) {
        $html .= "<meta name=\"fc:frame:image\" content=\"{$metaTags['og']['og:image']}\">\n";
        $html .= "<meta name=\"fc:frame:image:aspect_ratio\" content=\"1:1\">\n";
    }
    if (isset($metaTags['og']['og:description'])) {
        $html .= "<meta property=\"og:image:alt\" content=\"{$metaTags['og']['og:description']}\">\n";
    }
    $html .= "<meta name=\"fc:frame:button:1\" content=\"View on Manifold\">\n";
    $html .= "<meta name=\"fc:frame:button:1:action:type\" content=\"link\">\n";
    $html .= "<meta name=\"fc:frame:button:1:target\" content=\"$url\">\n";

    $html .= "</head>\n<body>\n</body>\n</html>";
    return $html;
}

// Main logic
if (isset($_GET['url'])) {
    $url = $_GET['url'];
    $htmlContent = fetchHtmlContent($url);
    $metaTags = extractMetaTags($htmlContent);

    // Define additional meta tags here
    $additionalMetaTags = [
        'fc:frame' => 'vNext'
    ];

    $newHtml = generateHtmlWithMetaTags($metaTags, $additionalMetaTags, $url);
    echo $newHtml;
} else {
    echo "No URL provided.";
}

?>
