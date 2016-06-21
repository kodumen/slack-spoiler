<?php
namespace App\Library;

class MessageFormatter
{
    // Openning tag is `!
    // Closing is `
    public $pattern = '/`!(.+?)`/s';

    public function format($str)
    {
        if (!preg_match_all($this->pattern, $str, $matches)) {
            return 'NO SPOILERS';
        }

        $payload = [
            'response_type' => 'in_channel',
            'attachments' => []
        ];

        foreach ($matches[0] as $key => $match) {
            $offset = strpos($str, $match);
            $match_len = strlen($match);

            $pretext = $offset != 0 ? substr($str, 0, $offset) : '';

            $payload['attachments'][] = $this->buildAttachment(
                $pretext,
                $matches[1][$key]
            );

            $str = substr($str, $offset + $match_len);
        }

        if ($str != '') {
            $payload['attachments'][] = $this->buildAttachment($str);
        }

        return $payload;
    }

    /**
     * Build the attachments for the payload.
     * @param string $pretext
     * @param string $text
     * @return array
     */
    public function buildAttachment($pretext = '', $text = '')
    {
        $attachment = [
            'mrkdwn_in' => ['pretext', 'text'],
            'color'=> 'danger',
        ];

        if ($pretext !== '' && $pretext !== null && $pretext !== false) {
            $attachment['pretext'] = trim($pretext);
        }

        if ($text !== '' && $text != null && $pretext !== false) {
            // We add 5 line breaks to trigger collapsing of text
            // in slack.
            $attachment['text'] = "Spoiler\n\n\n\n\n" . trim($text);
        }

        return $attachment;
    }
}
