<?php

namespace Plugin;

use GeniePress\Fields\DateField;
use GeniePress\Fields\DateTimeField;
use GeniePress\Genie;
use GeniePress\Interfaces\GenieComponent;
use GeniePress\Utilities\CreateTaxonomy;
use GeniePress\Utilities\HookInto;
use Plugin\PostTypes\Testimonial;

class Plugin implements GenieComponent
{

    public static function setup()
    {
        /**
         * Make sure we load jQuery
         */
        HookInto::action('init')
            ->run(function () {
                wp_enqueue_script('jquery');
            });


        /**
         * Override the date format
         */
        HookInto::filter('genie_field_generate_date_picker')
            ->run(function (DateField $field) {
                return $field->displayFormat('m-d-Y')
                    ->returnFormat('Y-m-d')
                    ->instructions('Please pick a date');
            });

        /**
         * Override the date & time format
         */
        HookInto::filter('genie_field_generate_date_time_picker')
            ->run(function (DateTimeField $field) {
                return $field->displayFormat('m-d-Y H:i:s')
                    ->returnFormat('Y-m-d H:i:s')
                    ->instructions('Please pick a date & time');
            });
    }

}
