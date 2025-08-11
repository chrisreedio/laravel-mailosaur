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

    public function getMessage(\Mailosaur\Models\SearchCriteria $criteria, int $timeout = 10000, ?\DateTime $receivedAfter = null, ?string $dir = null): \Mailosaur\Models\Message
    {
        return $this->client->messages->get($this->requireServerId(), $criteria, $timeout, $receivedAfter, $dir);
    }

    public function searchMessages(\Mailosaur\Models\SearchCriteria $criteria, int $page = 0, int $itemsPerPage = 50, ?int $timeout = null, ?\DateTime $receivedAfter = null, bool $errorOnTimeout = true, ?string $dir = null): \Mailosaur\Models\MessageListResult
    {
        return $this->client->messages->search($this->requireServerId(), $criteria, $page, $itemsPerPage, $timeout, $receivedAfter, $errorOnTimeout, $dir);
    }

    public function allMessages(int $page = 0, int $itemsPerPage = 50, ?\DateTime $receivedAfter = null, ?string $dir = null): \Mailosaur\Models\MessageListResult
    {
        return $this->client->messages->all($this->requireServerId(), $page, $itemsPerPage, $receivedAfter, $dir);
    }

    public function deleteAllMessages(): void
    {
        $this->client->messages->deleteAll($this->requireServerId());
    }

    public function createMessage(\Mailosaur\Models\MessageCreateOptions $options): \Mailosaur\Models\Message
    {
        return $this->client->messages->create($this->requireServerId(), $options);
    }

    public function generateEmailAddress(): string
    {
        return $this->client->servers->generateEmailAddress($this->requireServerId());
    }

    private function requireServerId(): string
    {
        if (is_string($this->serverId) && $this->serverId !== '') {
            return $this->serverId;
        }

        throw new \RuntimeException('MAILOSAUR_SERVER_ID is not set in configuration.');
    }
}
