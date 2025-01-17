<?php

/**
 * MIT License
 *
 * Copyright (c) 2024 cooldogedev
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * @auto-license
 */

declare(strict_types=1);

namespace cooldogedev\Spectrum\client\packet;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use function json_decode;
use function json_encode;
use const JSON_INVALID_UTF8_IGNORE;

final class ConnectPacket extends ProxyPacket
{
    public const NETWORK_ID = ProxyPacketIds::CONNECT;

    public string $address;
    public int $entityId;

    public array $clientData;
    public array $identityData;

    public static function create(string $address, int $entityId, array $clientData, array $identityData): ConnectPacket
    {
        $packet = new ConnectPacket();
        $packet->address = $address;
        $packet->entityId = $entityId;
        $packet->clientData = $clientData;
        $packet->identityData = $identityData;
        return $packet;
    }

    public function decodePayload(PacketSerializer $in): void
    {
        $this->address = $in->getString();
        $this->entityId = $in->getVarLong();
        $this->clientData = json_decode($in->getString(), true, JSON_INVALID_UTF8_IGNORE);
        $this->identityData = json_decode($in->getString(), true, JSON_INVALID_UTF8_IGNORE);
    }

    public function encodePayload(PacketSerializer $out): void
    {
        $out->putString($this->address);
        $out->putVarLong($this->entityId);
        $out->putString(json_encode($this->clientData, JSON_INVALID_UTF8_IGNORE));
        $out->putString(json_encode($this->identityData, JSON_INVALID_UTF8_IGNORE));
    }
}
