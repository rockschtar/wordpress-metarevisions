# rockschtar/wordpress-metarevision

> ⚠️ **Deprecated / abandoned.** Since **WordPress 6.4** meta-field revisioning is built into WordPress core. Register your meta with `register_post_meta( $post_type, $meta_key, [ 'revisions_enabled' => true ] )` (or use the `wp_post_revision_meta_keys` filter) instead of this plugin. See [Trac #20564](https://core.trac.wordpress.org/ticket/20564). This package is no longer maintained.

# Description

WordPress [Must Use Plugin](https://codex.wordpress.org/Must_Use_Plugins). Enables meta-data revisions via simplified hooks/filters for usage with composer based based WordPress projects ([roots/bedrock](https://github.com/roots/bedrock) or [johnpbloch/wordpress](https://github.com/johnpbloch/wordpress)).

# Requirements

  - PHP 7.1+
  - [Composer](https://getcomposer.org/) to install

# Install

```
composer require rockschtar/wordpress-metarevisions
```

# License

rockschtar/wordpress-metarevisions is open source and released under MIT license. See LICENSE.md file for more info.

## Usage

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
    

# Question? Issues?

rockschtar/wordpress-metarevisions is hosted on GitHub. Feel free to open issues there for suggestions, questions and real issues.
    
