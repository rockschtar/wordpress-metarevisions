<?php


namespace Rockschtar\WordPress\MetaRevisions\Tests;


use PHPUnit\Framework\TestCase;
use Rockschtar\WordPress\MetaRevisions\MetaRevisions;
use function Brain\Monkey\setUp;
use function Brain\Monkey\tearDown;

class MetaRevisionsTest extends TestCase {
    public function setUp(): void {
        parent::setUp();
        setUp();

    }

    public function tearDown(): void {
        tearDown();
        parent::tearDown();
    }

    public function testHooksAdded(): void {
        $metaRevisions = MetaRevisions::init();
        self::assertTrue(has_action('admin_init', [$metaRevisions, 'revision_fields_display_callbacks']));
        self::assertTrue(has_action('_wp_put_post_revision', [$metaRevisions, '_wp_save_revisioned_meta_fields']));
        self::assertTrue(has_action('wp_creating_autosave', [$metaRevisions, '_wp_autosave_post_revisioned_meta_fields']));
        self::assertTrue(has_action('wp_before_creating_autosave', [$metaRevisions, '_wp_autosave_post_revisioned_meta_fields']));
        self::assertTrue(has_action('wp_restore_post_revision', [$metaRevisions, '_wp_restore_post_revision_meta']));
    }


}