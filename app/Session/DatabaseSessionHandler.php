<?php declare(strict_types=1);

namespace App\Session;

use Illuminate\Session\DatabaseSessionHandler as BaseDatabaseSessionHandler;

class DatabaseSessionHandler extends BaseDatabaseSessionHandler
{
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function write($sessionId, $data): bool
    {
        $payload = $this->getDefaultPayload($data);

        if (! $this->exists) {
            $this->read($sessionId);
        }

        if ($this->exists) {
            $this->performUpdate($sessionId, $payload);
        } else {
            // Append the current session ID to the payload
            $this->appendCurrentIdToPayload($payload);

            $this->performInsert($sessionId, $payload);
        }

        return $this->exists = true;
    }

    private function appendCurrentIdToPayload(&$payload): void
    {
        $payload['previous_id'] = $this->container->make('session')->getId();
    }
}
