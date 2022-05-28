<?php
declare(strict_types = 1);
namespace Inspire\Support;

/**
 * Description of Url
 *
 * @author aalves
 */
class Url
{

    const HTTP_CODE = 0;

    const CONTENT_TYPE = 1;

    const CONTENT_LENGTH = 2;

    /**
     * Check if URL exists
     *
     * @param string $url
     * @return int
     */
    public static function exists(string $url): int
    {
        return intval(self::headers($url, Url::HTTP_CODE));
    }

    /**
     * Check content length
     *
     * @param string $url
     * @return int
     */
    public static function size(string $url): int
    {
        return intval(self::headers($url, Url::CONTENT_LENGTH));
    }

    /**
     * Get information of URL
     *
     * @param string $url
     * @param int $header
     * @return boolean|NULL|mixed|NULL
     */
    public static function headers(string $url, int $header)
    {
        $headers = get_headers($url, true);
        switch ($header) {
            //
            case Url::HTTP_CODE:
                return strpos($headers[0], '200') > 0;
            //
            case Url::CONTENT_TYPE:
                return $headers['Content-Type'] ?? null;
            //
            case Url::CONTENT_LENGTH:
                return $headers['Content-Length'] ?? null;
        }
        return null;
    }

    /**
     * Donwload/get URL contents
     *
     * @param string $url
     * @return string|NULL
     */
    public static function getFile(string $url): ?string
    {
        return file_get_contents($url, false, stream_context_create([
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false
            ]
        ]));
    }

    /**
     * Check if is a valid URL
     *
     * @param string $url
     * @return bool
     */
    public static function isUrl(string $url, array $protocols = [
        'http',
        'https'
    ]): bool
    {
        $prot = implode('|', array_map('trim', $protocols));
        $regex = "(({$prot})\:\/\/)?";
        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";
        $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})";
        $regex .= "(\:[0-9]{2,5})?";
        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?";
        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?";
        return boolval(preg_match("/^$regex$/i", $url));
    }

    /**
     * Get only content of a URL (with no headers)
     *
     * @param string $url
     * @return string|NULL
     */
    public static function getRawBody(string $url): ?string
    {
        // Remove any invalid character from URL
        $url = pathinfo($url, PATHINFO_DIRNAME) . '/' . urlencode(basename($url));
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}

