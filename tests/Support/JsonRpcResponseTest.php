<?php

namespace Tochka\JsonRpc\Tests\Support;

use PHPUnit\Framework\TestCase;
use Tochka\JsonRpc\Support\JsonRpcResponse;

class JsonRpcResponseTest extends TestCase
{
    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcResponse::result
     */
    public function testResult(): void
    {
        $data = ['data' => 'data'];
        $id = '12345';

        $response = JsonRpcResponse::result($data, $id);

        $this->assertEquals($data, $response->result);
        $this->assertEquals('2.0', $response->jsonrpc);
        $this->assertEquals($id, $response->id);
        $this->assertNull($response->error);
    }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcResponse::error
     */
    public function testError(): void
    {
        $error = ['error' => 'error'];
        $id = '12345';

        $response = JsonRpcResponse::error($error, $id);

        $this->assertEquals($error, $response->error);
        $this->assertEquals('2.0', $response->jsonrpc);
        $this->assertEquals($id, $response->id);
        $this->assertNull($response->result);
    }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcResponse::toArray
     */
    public function testToArrayResult(): void
    {
        $data = ['data' => 'data'];
        $id = '12345';
        $result = [
            'jsonrpc' => '2.0',
            'result'  => $data,
            'id'      => $id,
        ];

        $response = JsonRpcResponse::result($data, $id)->toArray();

        $this->assertEquals($result, $response);
    }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcResponse::toArray
     */
    public function testToArrayError(): void
    {
        $error = ['error' => 'message'];
        $id = '12345';
        $result = [
            'jsonrpc' => '2.0',
            'error'   => $error,
            'id'      => $id,
        ];

        $response = JsonRpcResponse::error($error, $id)->toArray();

        $this->assertEquals($result, $response);
    }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcResponse::toJson
     */
    public function testToJson(): void
    {
        $data = ['data' => 'data'];
        $id = '12345';
        $result = json_encode([
            'jsonrpc' => '2.0',
            'result'  => $data,
            'id'      => $id,
        ], JSON_UNESCAPED_UNICODE);

        $response = JsonRpcResponse::result($data, $id)->toJson();

        $this->assertJsonStringEqualsJsonString($result, $response);
    }
}
