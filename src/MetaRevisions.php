<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\MetaRevisions;

/**
 * Class MetaRevisions
 * @package Rockschtar\WordPress\MetaRevisions
 */
class MetaRevisions {
    private function __construct() {
        add_action('admin_init', array($this, 'revision_fields_display_callbacks'));
        add_action('_wp_put_post_revision', array($this, '_wp_save_revisioned_meta_fields'));
        add_filter('wp_save_post_revision_post_has_changed', array($this, '_wp_check_revisioned_meta_fields_have_changed'), 10, 3);
        add_filter('_wp_post_revision_fields', array(&$this, '_wp_post_revision_fields'), 10, 2);
        add_action('wp_creating_autosave', array($this, '_wp_autosave_post_revisioned_meta_fields'));
        add_action('wp_before_creating_autosave', array($this, '_wp_autosave_post_revisioned_meta_fields'));
        add_action('wp_restore_post_revision', array($this, '_wp_restore_post_revision_meta'), 10, 2);
    }

    /**
     * @return static
     */
    public static function &init() {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
        return $instance;
    }

    final public function revision_fields_display_callbacks(): void {
        $field_callbacks = apply_filters('rswpmr_revision_meta_fields_callbacks', array());

        foreach ($field_callbacks as $field_callback) {
            $filter = '_wp_post_revision_field_' . $field_callback['field'];
            $callback = $field_callback['callback'];
            add_filter($filter, $callback, 10, 2);
        }
    }

    final public function _wp_save_revisioned_meta_fields($revision_id): void {
        $revision = get_post($revision_id);
        $post_id = $revision->post_parent;

        $partent_post_type = get_post_type($post_id);

        $revision_meta_fields = apply_filters('rswpmr_revision_meta_fields', array());
        $fields = array_key_exists($partent_post_type, $revision_meta_fields) ? $revision_meta_fields[$partent_post_type] : false;

        if (!$fields) {
            return;
        }

        foreach ($fields as $meta_key => $meta_title) {
            $meta_value = get_post_meta($post_id, $meta_key, true);
            add_metadata('post', $revision_id, $meta_key, $meta_value);
        }
    }

    final public function _wp_autosave_post_revisioned_meta_fields($new_autosave): void {
        $posted_data = isset($_POST['data']) ? $_POST['data']['wp_autosave'] : $_POST;
        $post_type = $posted_data['post_type'];
        $meta_fields = apply_filters('rswpmr_revision_meta_fields', array());
        $meta_fields = $meta_fields[$post_type];

        foreach ($meta_fields as $meta_key => $meta_title) {

            if (isset($posted_data[$meta_key]) && get_post_meta($new_autosave['ID'], $meta_key, true) !== wp_unslash($posted_data[$meta_key])) {
                delete_metadata('post', $new_autosave['ID'], $meta_key);
                if (!empty($posted_data[$meta_key])) {
                    add_metadata('post', $new_autosave['ID'], $meta_key, $posted_data[$meta_key]);
                }
            }
        }
    }

    public function _wp_restore_post_revision_meta($post_id, $revision_id): void {

        $partent_post_type = get_post_type($post_id);
        $revision_meta_fields = apply_filters('rswpmr_revision_meta_fields', array());
        $metas_revisioned = $revision_meta_fields[$partent_post_type];

        if ($metas_revisioned !== null && 0 !== \count($metas_revisioned)) {
            foreach ($metas_revisioned as $meta_key => $meta_title) {
                // Clear any existing metas
                delete_post_meta($post_id, $meta_key);
                // Get the stored meta, not stored === blank
                $meta_values = get_post_meta($revision_id, $meta_key);
                if (0 !== count($meta_values) && is_array($meta_values)) {
                    foreach ($meta_values as $meta_value) {
                        add_post_meta($post_id, $meta_key, $meta_value);
                    }
                }
            }
        }
    }

    final public function _wp_check_revisioned_meta_fields_have_changed($post_has_changed, \WP_Post $last_revision, \WP_Post $post): bool {
        $post_type = get_post_type($post->ID);
        $revision_meta_fields = apply_filters('rswpmr_revision_meta_fields', array());
        $fields = $revision_meta_fields[$post_type];

        foreach ($fields as $key => $val) {
            if (get_post_meta($post->ID, $key) !== get_post_meta($last_revision->ID, $key)) {
                $post_has_changed = true;
                break;
            }
        }

        return $post_has_changed;
    }

    final public function _wp_post_revision_fields($fields, $autosave) {
        $post_type = $autosave['post_type'];

        $revision_meta_fields = apply_filters('rswpmr_revision_meta_fields', array());
        $meta_fields = $revision_meta_fields[$post_type];

        foreach ($meta_fields as $key => $value) {
            $fields[$key] = $value;
        }

        return $fields;
    }

}