<?php

class BackstoryEndpointTest extends TestCase {
    public function test() {
        $endpoint = $this->api()->backstory();

        $this->assertEndpointUrl('v2/backstory', $endpoint);
    }

    public function testQuestions() {
        $endpoint = $this->api()->backstory()->questions();

        $this->assertEndpointIsBulk($endpoint);
        $this->assertEndpointIsLocalized($endpoint);
        $this->assertEndpointUrl('v2/backstory/questions', $endpoint);

        $this->mockResponse('[1,2,3,4,5,6,8,12,13]');
        $this->assertEquals([1,2,3,4,5,6,8,12,13], $endpoint->ids());
    }

    public function testAnswers() {
        $endpoint = $this->api()->backstory()->answers();

        $this->assertEndpointIsBulk($endpoint);
        $this->assertEndpointIsLocalized($endpoint);
        $this->assertEndpointUrl('v2/backstory/answers', $endpoint);

        $this->mockResponse('["7-54","188-189","22-109","15-84"]');
        $this->assertEquals(["7-54","188-189","22-109","15-84"], $endpoint->ids());
    }
}
