
# WordPress MetaRevisons

## Usage

https://img.shields.io/badge/license-MIT-blue.svg

This library allows you to store changes in post meta fields to the built in WordPress Revision Management System.

    MetaRevisions::init();

    add_filter('rswpmr_revision_meta_fields', function($fields) {
        $fields['your_post_type_name']['your_post_meta_field'] = __('Your Meta Field Title');
        return $fields;
    });

    add_filter('rswpmr_revision_meta_fields_callbacks', function($field_callbacks) {
        $field_callbacks[] = array('field' => 'your_post_meta_field', 'callback' => function($value, $field) {
            //option to convert your post meta value to a readable value
            return $value;
        });

        return $field_callbacks;
    });