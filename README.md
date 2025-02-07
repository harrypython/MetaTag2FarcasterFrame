# MetaTag2FarcasterFrame

MetaTag2FarcasterFrame is a PHP script that fetches HTML content from a provided URL, extracts HTML Meta Tags, Open Graph Meta Tags, and Twitter Meta Tags, and generates a new HTML page with the extracted meta tags along with additional specified meta tags.

## How It Works

1. Fetches the HTML content from the provided URL.
2. Extracts the standard HTML Meta Tags, Open Graph Meta Tags, and Twitter Meta Tags.
3. Reconstructs an HTML page containing the extracted meta tags along with additional specified meta tags.

## Meta Tags Included

- Standard HTML Meta Tags
- Open Graph Meta Tags
- Twitter Meta Tags
- Additional Meta Tags:
  - `fc:frame` with value `vNext`
  - `fc:frame:image` with the same value as `og:image`
  - `fc:frame:image:aspect_ratio` with value `1:1`
  - `fc:frame:button:1` with value `View on Manifold`
  - `fc:frame:button:1:action:type` with value `link`
  - `fc:frame:button:1:target` with the value of the provided URL
  - `og:image:alt` with the same value as `og:description`

## About Farcaster

Farcaster is an innovative, open-source, decentralized social network built on Ethereum. It allows users to create public social profiles and communities to interact with others. Unlike centralized social networks, Farcaster gives users complete control over their data.

## Creating Frames for Warpcast

Frames are mini-applications that run directly within a Farcaster social feed. They can be used to create rich in-feed experiences for web applications, such as NFT galleries, polls, and interactive journeys.

This script can be used to generate HTML content with meta tags that are compatible with Farcaster Frames, making it easier to create interactive and engaging experiences within the Farcaster social feed.

## Usage

1. Ensure you have PHP installed on your server.
2. Place the `MetaTag2FarcasterFrame` script in your desired directory.
3. Access the script via your browser with a URL parameter, e.g., `http://yourdomain.com/MetaTag2FarcasterFrame.php?url=YOUR_TARGET_URL`.

## Example

```php
http://yourdomain.com/MetaTag2FarcasterFrame.php?url=https://example.com
```

This will generate an HTML page with the meta tags from the provided URL and include the additional specified meta tags.

## License

This project is licensed under the MIT License.
