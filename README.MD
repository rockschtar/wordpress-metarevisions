# rockschtar/cronjob

# Description

Library for use with roots/bedrock based WordPress projects. Simplifys the creation of WordPress cronjobs.

# Requirements

  - PHP 7.1+
  - [Composer](https://getcomposer.org/) to install

# License

rockschtar/wordpress-cronjob is open source and released under MIT license. See LICENSE.md file for more info.

# Usage

Create a cronjob class

    class TestCronjob extends AbstractCronjob {

        public function execute(): void {
            //do some stuff
        }

        public function config(): CronjobConfig {
            $config = new CronjobConfig();
            $config->setHook('do_test_cronjob');
            $config->setPluginFile('some_plugin.php');
            $config->setFirstRun(new \DateTime());
            $config->setRecurrence('daily');
            return $config;
        }
    }

Initialize the class

    TestCronjob::init();


# Question? Issues?

rockschtar/wordpress-cronjob is hosted on GitLab. Feel free to open issues there for suggestions, questions and real issues.

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