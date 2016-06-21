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
            return ['attachment'];
        }
    }

    /**
     * Build the attachments for the payload.
     * @param string $pretext
     * @param string $text
     */
    public function buildAttachment($pretext = '', $text = '')
    {
        $attachment = ['mrkdwn_in' => ['pretext', 'text']];

        if ($pretext !== '' && $pretext !== null) {
            $attachment['pretext'] = $pretext;
        }

        if ($text !== '' && $text != null) {
            // We add 5 line breaks to trigger collapsing of text
            // in slack.
            $attachment['text'] = "\n\n\n\n\n" . $text;
        }

        return $attachment;
    }
}
