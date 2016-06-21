<?php

use Faker\Factory;
use App\Library\MessageFormatter;

class MessageFormatterTest extends TestCase
{
    private $faker;
    private $text;
    private $formatter;

    public function setUp()
    {
        $this->faker = Factory::create();
        $this->formatter = new MessageFormatter();
        $this->text = [
            $this->faker->text,
            '`!' . $this->faker->address . '`',
            $this->faker->name,
            '`!' . $this->faker->uuid . '`',
            $this->faker->word,
        ];

    }

    public function testFormat()
    {
        $result = $this->formatter->format(implode(' ', $this->text));

        $this->assertEquals(
            [
                'attachments' => [
                    [
                        'pretext' => $this->text[0],
                        'text' => "\n\n\n\n\n" . $this->text[1],
                        'mrkdwn_in' => ['pretext', 'text'],
                    ],
                    [
                        'pretext' => $this->text[2],
                        'text' => "\n\n\n\n\n" . $this->text[3],
                        'mrkdwn_in' => ['pretext', 'text'],
                    ],
                    [
                        'pretext' => $this->text[4],
                        'mrkdwn_in' => ['pretext', 'text'],
                    ]
                ]
            ],
            $result
        );
    }

    public function testBuildAttachment()
    {
        $attachment = $this->formatter->buildAttachment($this->text[0], $this->text[1]);

        $this->assertEquals(
            [
                'pretext' => $this->text[0],
                'text' => "\n\n\n\n\n" . $this->text[1],
                'mrkdwn_in' => ['pretext', 'text'],
            ],
            $attachment
        );

        $attachment = $this->formatter->buildAttachment($this->text[0]);

        $this->assertEquals(
            [
                'pretext' => $this->text[0],
                'mrkdwn_in' => ['pretext', 'text'],
            ],
            $attachment
        );

        $attachment = $this->formatter->buildAttachment('', $this->text[1]);

        $this->assertEquals(
            [
                'text' => "\n\n\n\n\n" . $this->text[1],
                'mrkdwn_in' => ['pretext', 'text'],
            ],
            $attachment
        );
    }
}
