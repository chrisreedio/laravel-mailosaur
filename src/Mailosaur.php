<?php

namespace ChrisReedIO\Mailosaur;

use Mailosaur\MailosaurClient;

class Mailosaur
{
    public function __construct(
        protected MailosaurClient $client,
        protected ?string $serverId = null,
        protected ?string $domain = null,
    ) {}

    public function client(): MailosaurClient
    {
        return $this->client;
    }

    public function serverId(): ?string
    {
        return $this->serverId;
    }

    public function domain(): ?string
    {
        return $this->domain;
    }

    public function messages(): \Mailosaur\Operations\Messages
    {
        return $this->client->messages;
    }
}
