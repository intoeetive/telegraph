<?php

/** @noinspection PhpUnhandledExceptionInspection */

namespace DefStudio\Telegraph\Concerns;

use DefStudio\Telegraph\Telegraph;

/**
 * @mixin Telegraph
 */
trait ComposesMessages
{
    public function message(string $message): Telegraph
    {
        return match (config('telegraph.default_parse_mode')) {
            self::PARSE_MARKDOWN => $this->markdown($message),
            default => $this->html($message)
        };
    }

    public function html(string $message): Telegraph
    {
        $this->endpoint = self::ENDPOINT_MESSAGE;
        $this->data['text'] = $message;
        $this->data['chat_id'] = $this->getChat()->chat_id;
        $this->data['parse_mode'] = 'html';

        return $this;
    }

    public function markdown(string $message): Telegraph
    {
        $this->endpoint = self::ENDPOINT_MESSAGE;
        $this->data['text'] = $message;
        $this->data['chat_id'] = $this->getChat()->chat_id;
        $this->data['parse_mode'] = 'markdown';

        return $this;
    }

    public function protected(): Telegraph
    {
        $this->data['protect_content'] = true;

        return  $this;
    }

    public function silent(): Telegraph
    {
        $this->data['disable_notification'] = true;

        return  $this;
    }

    public function withoutPreview(): Telegraph
    {
        $this->data['disable_web_page_preview'] = true;

        return  $this;
    }
}
