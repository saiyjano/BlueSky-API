function lade_bluesky_feed(string $user, int $limit = 5): array
{
    $url = "https://bsky.app/profile/$user/rss";

    $context = stream_context_create([
        'http' => [
            'timeout' => 5,
            'user_agent' => 'Mozilla/5.0'
        ]
    ]);

    $rss_raw = @file_get_contents($url, false, $context);
    if (!$rss_raw) {
        return [];
    }

    $rss = @simplexml_load_string($rss_raw, 'SimpleXMLElement', LIBXML_NOCDATA);
    if (!$rss || !isset($rss->channel->item)) {
        return [];
    }

    $posts = [];

    foreach ($rss->channel->item as $item) {

        // HTML + Hashtags BEHALTEN
        $text = html_entity_decode(
            (string)$item->description,
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        );

        $posts[] = [
            'text' => $text,
            'link' => (string)$item->link,
            'date' => date('d.m.Y', strtotime((string)$item->pubDate))
        ];

        if (count($posts) >= $limit) {
            break;
        }
    }

    return $posts;
}
