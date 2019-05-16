# rockschtar/wordpress-metarevision

# Description

WordPress [Must Use Plugin](https://codex.wordpress.org/Must_Use_Plugins). Enables meta-data revisions via simplified hooks/filters for usage with roots/bedrock based WordPress projects.

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

rockschtar/wordpress-cronjob is hosted on GitLab. Feel free to open issues there for suggestions, questions and real issues.
    