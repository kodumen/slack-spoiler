<?php

use Faker\Factory;
use App\Library\MessageFormatter;

class MessageFormatterTest extends TestCase
{
    private $faker;
    private $data;
    private $formatter;

    public function setUp()
    {
        $this->faker = Factory::create();
        $this->formatter = new MessageFormatter();
        $this->data = [
            $this->faker->text,
            $this->faker->address,
            $this->faker->name,
            $this->faker->uuid,
            $this->faker->word,
        ];

        $this->text = "{$this->data[0]} " .
            "`!{$this->data[1]}` " .
            "{$this->data[2]} " .
            "`!{$this->data[3]}` " .
            "{$this->data[4]}";
    }

    public function testFormat()
    {
        $result = $this->formatter->format($this->text);

        $this->assertEquals(
            [
                'attachments' => [
                    [
                        'pretext' => $this->data[0],
                        'text' => "\n\n\n\n\n" . $this->data[1],
                        'mrkdwn_in' => ['pretext', 'text'],
                    ],
                    [
                        'pretext' => $this->data[2],
                        'text' => "\n\n\n\n\n" . $this->data[3],
                        'mrkdwn_in' => ['pretext', 'text'],
                    ],
                    [
                        'pretext' => $this->data[4],
                        'mrkdwn_in' => ['pretext', 'text'],
                    ]
                ]
            ],
            $result
        );
    }

    /**
     * Test the buildAttachmen() method.
     */
    public function testBuildAttachment()
    {
        $attachment = $this->formatter->buildAttachment($this->data[0], $this->data[1]);

        $this->assertEquals(
            [
                'pretext' => $this->data[0],
                'text' => "\n\n\n\n\n" . $this->data[1],
                'mrkdwn_in' => ['pretext', 'text'],
            ],
            $attachment
        );

        $attachment = $this->formatter->buildAttachment($this->data[0]);

        $this->assertEquals(
            [
                'pretext' => $this->data[0],
                'mrkdwn_in' => ['pretext', 'text'],
            ],
            $attachment
        );

        $attachment = $this->formatter->buildAttachment('', $this->data[1]);

        $this->assertEquals(
            [
                'text' => "\n\n\n\n\n" . $this->data[1],
                'mrkdwn_in' => ['pretext', 'text'],
            ],
            $attachment
        );
    }
}
