<?php

/**
 * @file
 * Definition of Drupal\cloudflare\Tests.
 */

namespace Drupal\cloudflare\Tests\StateTest;

use Drupal\Core\KeyValueStore\KeyValueMemoryFactory;
use DateTime;
use Drupal\Tests\UnitTestCase;

/**
 * Tests functionality of CloudFlareState object.
 *
 * @group cloudflare
 */
class StateTest extends UnitTestCase {

  /**
   * Tests tag count tracking functionality.
   */
  public function testTagPurgeDailyCountIncrements() {
    $timestamp_stub = $this->getMockBuilder('Drupal\cloudflare\Timestamp')
      ->disableOriginalConstructor()
      ->getMock();

    // Configure the stub.
    $timestamp_stub->method('now')
      ->will($this->onConsecutiveCalls(
        new DateTime('2010-02-01 00:00:00'),
        new DateTime('2010-02-01 00:01:00'),
        new DateTime('2010-02-01 00:02:00')
      ));

    $drupal_state_service = new \Drupal\Core\State\State(new KeyValueMemoryFactory());
    $cloudflare_state = new \Drupal\cloudflare\State($drupal_state_service, $timestamp_stub);
    $initial_count = $cloudflare_state->getTagDailyCount();
    $this->assertEquals(0, $initial_count, 'Tested state with empty counts');

    $cloudflare_state->incrementTagPurgeDailyCount();
    $count = $cloudflare_state->getTagDailyCount();
    $this->assertEquals(1, $count, 'Tested state with first increment of day');

    $cloudflare_state->incrementTagPurgeDailyCount();
    $count = $cloudflare_state->getTagDailyCount();
    $this->assertEquals(2, $count, 'Tested state with first increment of day');

    $cloudflare_state->incrementTagPurgeDailyCount();
    $count = $cloudflare_state->getTagDailyCount();
    $this->assertEquals(3, $count, 'Tested state with first increment of day');
  }

  /**
   * Tests tag count boundary functionality.
   */
  public function testTagPurgeBoundaryIncrements() {
    $timestamp_stub = $this->getMockBuilder('Drupal\cloudflare\Timestamp')
      ->disableOriginalConstructor()
      ->getMock();

    // Configure the stub.
    $timestamp_stub->method('now')
      ->will($this->onConsecutiveCalls(
        new DateTime('2010-02-01 00:00:00'),
        new DateTime('2010-02-02 00:01:00'),
        new DateTime('2010-02-03 00:02:00')
      ));

    $drupal_state_service = new \Drupal\Core\State\State(new KeyValueMemoryFactory());
    $cloudflare_state = new \Drupal\cloudflare\State($drupal_state_service, $timestamp_stub);
    $initial_count = $cloudflare_state->getTagDailyCount();
    $this->assertEquals(0, $initial_count, 'Tested state with empty counts');

    $cloudflare_state->incrementTagPurgeDailyCount();
    $count = $cloudflare_state->getTagDailyCount();
    $this->assertEquals(1, $count, 'Tested state with first increment of day');

    $cloudflare_state->incrementTagPurgeDailyCount();
    $count = $cloudflare_state->getTagDailyCount();
    $this->assertEquals(1, $count, 'Tested state with first increment of day');

    $cloudflare_state->incrementTagPurgeDailyCount();
    $count = $cloudflare_state->getTagDailyCount();
    $this->assertEquals(1, $count, 'Tested state with first increment of day');
  }

  /**
   * Tests tag count tracking functionality.
   */
  public function testApiRateLimitCountIncrements() {
    $timestamp_stub = $this->getMockBuilder('Drupal\cloudflare\Timestamp')
      ->disableOriginalConstructor()
      ->getMock();

    // Configure the stub.
    $timestamp_stub->method('now')
      ->will($this->onConsecutiveCalls(
        new DateTime('2010-02-01 00:00:00'),
        new DateTime('2010-02-01 00:01:00'),
        new DateTime('2010-02-01 00:02:00')
      ));

    $drupal_state_service = new \Drupal\Core\State\State(new KeyValueMemoryFactory());
    $cloudflare_state = new \Drupal\cloudflare\State($drupal_state_service, $timestamp_stub);
    $initial_count = $cloudflare_state->getTagDailyCount();
    $this->assertEquals(0, $initial_count, 'Tested state with empty counts');

    $cloudflare_state->incrementApiRateCount();
    $count = $cloudflare_state->getApiRateCount();
    $this->assertEquals(1, $count, 'Tested state with first increment of day');

    $cloudflare_state->incrementApiRateCount();
    $count = $cloudflare_state->getApiRateCount();
    $this->assertEquals(2, $count, 'Tested state with first increment of day');

    $cloudflare_state->incrementApiRateCount();
    $count = $cloudflare_state->getApiRateCount();
    $this->assertEquals(3, $count, 'Tested state with first increment of day');
  }

  /**
   * Tests tag count boundary functionality.
   */
  public function testApiRateLimitBoundaryIncrements() {
    $timestamp_stub = $this->getMockBuilder('Drupal\cloudflare\Timestamp')
      ->disableOriginalConstructor()
      ->getMock();

    // Configure the stub.
    $timestamp_stub->method('now')
      ->will($this->onConsecutiveCalls(
        new DateTime('2010-02-01 00:00:00'),
        new DateTime('2010-02-02 00:01:00'),
        new DateTime('2010-02-03 00:02:00'),
        new DateTime('2010-02-03 00:10:00'),
        new DateTime('2010-02-03 00:15:00')
      ));

    $drupal_state_service = new \Drupal\Core\State\State(new KeyValueMemoryFactory());
    $cloudflare_state = new \Drupal\cloudflare\State($drupal_state_service, $timestamp_stub);
    $initial_count = $cloudflare_state->getApiRateCount();
    $this->assertEquals(0, $initial_count, 'Tested state with empty counts');

    $cloudflare_state->incrementApiRateCount();
    $count = $cloudflare_state->getApiRateCount();
    $this->assertEquals(1, $count, 'Tested state with first increment of day');

    $cloudflare_state->incrementApiRateCount();
    $count = $cloudflare_state->getApiRateCount();
    $this->assertEquals(1, $count, 'Tested state with first increment of day');

    $cloudflare_state->incrementApiRateCount();
    $count = $cloudflare_state->getApiRateCount();
    $this->assertEquals(1, $count, 'Tested state with first increment of day');

    $cloudflare_state->incrementApiRateCount();
    $count = $cloudflare_state->getApiRateCount();
    $this->assertEquals(1, $count, 'Tested state with first increment of day');

    $cloudflare_state->incrementApiRateCount();
    $count = $cloudflare_state->getApiRateCount();
    $this->assertEquals(1, $count, 'Tested state with first increment of day');
  }

}
