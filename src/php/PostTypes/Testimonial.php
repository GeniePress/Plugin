<?php

namespace Plugin\PostTypes;

use Exception;
use GeniePress\Abstracts\CustomPost;
use GeniePress\Debug;
use GeniePress\Fields\SelectField;
use GeniePress\Fields\TextField;
use GeniePress\Utilities\AddShortcode;
use GeniePress\Utilities\CreateCustomPostType;
use GeniePress\Utilities\CreateSchema;
use GeniePress\Utilities\RegisterAjax;
use GeniePress\Utilities\RegisterApi;
use GeniePress\Utilities\When;
use GeniePress\Utilities\Where;
use GeniePress\View;
use Plugin\Exceptions\PluginException;

/**
 * Class Testimonial
 *
 * This is a sample component
 *
 * @package Plugin\PostTypes
 *
 * @property string $name
 * @property string $location
 */
class Testimonial extends CustomPost
{

    /**
     * TYhe post type
     *
     * @var string
     */
    static $postType = 'testimonial';

    /**
     * A sample array to use in ACF
     *
     * @var string[]
     */
    protected static $locations = [
        'gb' => 'London',
        'fr' => 'France',
    ];



    /**
     * Setup
     */
    public static function setup()
    {
        /**
         * we need to make sure call the parent setup()
         */
        parent::setup();

        /**
         * Create the post type
         */
        CreateCustomPostType::called(static::$postType)
            ->icon('dashicons-admin-comments')
            ->register();

        /**
         * Create the schema
         */
        CreateSchema::called('Testimonial')
            ->withFields([
                TextField::called('name')
                    ->required(true)
                    ->wrapperWidth(50),
                SelectField::called('location')
                    ->choices(static::$locations)
                    ->default('london')
                    ->returnFormat('value')
                    ->required(true)
                    ->shown(When::field('name')->notEmpty())
                    ->wrapperWidth(50),
            ])
            ->shown(Where::field('post_type')->equals(static::$postType))
            // This is important as it tells Genie to attach this
            // parse fields against the object.
            ->attachTo(static::class)
            ->register();

        /**
         * register out Ajax endpoint
         */
        RegisterAjax::url('testimonial/create')
            ->run([static::class, 'addTestimonial']);

        /**
         * This provides the same functionality as an api endpoint.
         * Just without the nonce checks
         */
        RegisterApi::post('testimonial/create')
            ->run([static::class, 'addTestimonial']);

        /**
         * Another API that allows retrieval of testimonials
         * through the api endpoint
         */
        RegisterApi::get('testimonials')
            ->run(function () {
                return static::get()->toArray();
            });

        /**
         * Create a testimonial form
         */
        AddShortcode::called('testimonial_form')
            ->run(function () {
                return View::with('testimonials/form.twig')
                    ->addVar('locations', static::$locations)
                    ->render();
            });

        /**
         * A shortcode to display one testimonial
         */
        AddShortcode::called('testimonial')
            ->run(function ($attributes) {
                $attributes = (object) shortcode_atts([
                    'name' => $attributes[0],
                ], $attributes);

                // find the testimonial by the meta_key
                $testimonial = static::get([
                    'meta_key'   => 'name',
                    'meta_value' => $attributes->name,
                ])->first();

                // Display the testimonial
                return View::with('testimonials/testimonial.twig')
                    ->addVar('testimonial', $testimonial)
                    ->addVar('locations', static::$locations)
                    ->render();
            });

        /**
         * Show all testimonials
         */
        AddShortcode::called('testimonials')
            ->run(function ($attributes) {
                $attributes = (object) shortcode_atts([
                    'limit' => 10,
                ], $attributes);

                // get the required number of testimonials
                $testimonials = static::get([
                    'numberposts' => $attributes->limit,
                ]);

                // Display the testimonials
                return View::with('testimonials/testimonials.twig')
                    ->addVars([
                        'testimonials' => $testimonials,
                        'locations'    => static::$locations,
                    ])
                    ->render();
            });
    }



    /**
     * Add a testimonial - called from Ajax / Api
     * All 4 parameters are required and are checked by Genie
     *
     * @param $title
     * @param $text
     * @param $name
     * @param $location
     *
     * @return array
     */
    public static function addTestimonial($title, $text, $name, $location): array
    {
        // Create the testimonial
        $testimonial = static::create([
            'post_title'   => $title,
            'post_content' => $text,
            'name'         => $name,
            'location'     => $location,
            'post_status'  => 'draft',
        ]);

        return [
            'message' => 'Testimonial pending approval',
            'id'      => $testimonial->ID,
        ];
    }



    /**
     * Make sure that a Testimonial is valid before saving it
     *
     * @throws Exception
     */
    public function checkValidity()
    {

        if ( ! $this->post_title) {
            throw PluginException::withMessage('Please specify a title for this testimonial')
                ->withData($this->getData())
                ->withCode(1001);
        }

        if ( ! array_key_exists($this->location, static::$locations)) {
            throw PluginException::withMessage('Invalid location '.$this->location)
                ->withData($this->getData())
                ->withCode(1002);
        }
    }
}
