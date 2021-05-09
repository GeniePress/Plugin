<?php

namespace Plugin\PostTypes;

use GeniePress\Abstracts\CustomPost;
use GeniePress\Fields\CheckboxField;
use GeniePress\Fields\DateField;
use GeniePress\Fields\DateTimeField;
use GeniePress\Fields\EmailField;
use GeniePress\Fields\FileField;
use GeniePress\Fields\FlexibleContentField;
use GeniePress\Fields\GalleryField;
use GeniePress\Fields\GroupField;
use GeniePress\Fields\ImageField;
use GeniePress\Fields\LayoutField;
use GeniePress\Fields\MessageField;
use GeniePress\Fields\NumberField;
use GeniePress\Fields\PostObjectField;
use GeniePress\Fields\RadioField;
use GeniePress\Fields\RangeField;
use GeniePress\Fields\RelationshipField;
use GeniePress\Fields\RepeaterField;
use GeniePress\Fields\SelectField;
use GeniePress\Fields\TabField;
use GeniePress\Fields\TaxonomyField;
use GeniePress\Fields\TextAreaField;
use GeniePress\Fields\TextField;
use GeniePress\Fields\TrueFalseField;
use GeniePress\Fields\UrlField;
use GeniePress\Fields\UserField;
use GeniePress\Fields\WysiwygField;
use GeniePress\Utilities\CreateCustomPostType;
use GeniePress\Utilities\CreateSchema;
use GeniePress\Utilities\When;
use GeniePress\Utilities\Where;

/**
 * Class Sample
 *
 * @package Plugin\PostTypes
 */
class Sample extends CustomPost
{

    /**
     * the post type
     *
     * @var string
     */
    static $postType = 'sample';

    /**
     * A sample array to use in ACF
     *
     * @var string[]
     */
    protected static $options = [
        'a' => 'One',
        'b' => 'Two',
        'c' => 'Three',
    ];



    public static function setup()
    {
        parent::setup();

        CreateCustomPostType::called(static::$postType)
            ->backendOnly()
            ->icon('dashicons-admin-comments')
            ->removeSupportFor(['editor'])
            ->register();

        CreateSchema::called('Sample')
            ->withFields([

                TabField::called('tab_basic')
                    ->label('Basic Fields'),

                MessageField::called('nada')
                    ->label('Message Field')
                    ->message('<p>This is a <i>message field</i></p>'),

                TextField::called('name')
                    ->label('Text Field')
                    ->required(true),

                TextAreaField::called('textarea')
                    ->label('Text Area Field')
                    ->rows(3),
                SelectField::called('choice')
                    ->label('Select Field')
                    ->choices(static::$options)
                    ->default('a')
                    ->returnFormat('value')
                    ->required(true)
                    ->wrapperWidth(50),
                EmailField::called('email')
                    ->wrapperWidth(50),
                DateField::called('started')
                    ->label('Date Field')
                    ->wrapperWidth(50)
                    ->returnFormat('Y-m-d'),
                DateTimeField::called('started_time')
                    ->label('Date TimeField')
                    ->wrapperWidth(50)
                    ->returnFormat('Y-m-d H:i:s'),

                NumberField::called('number')
                    ->label('Number Field')
                    ->wrapperWidth(50),

                NumberField::called('amount')
                    ->label('Number Field (as currency)')
                    ->min(1)
                    ->max(100)
                    ->step(1)
                    ->prepend('£')
                    ->default(10)
                    ->instructions('Enter an amount from 1-100')
                    ->wrapperWidth(50),

                GroupField::called('group')
                    ->label('Group Field')
                    ->layout('table')
                    ->withFields([

                        RangeField::called('range')
                            ->label('Range Field')
                            ->min(1)
                            ->max(5)
                            ->step(1)
                            ->wrapperWidth(33),

                        CheckboxField::called('checkbox')
                            ->label('Checkbox Field')
                            ->choices(static::$options)
                            ->layout('horizontal')
                            ->wrapperWidth(33),

                        RadioField::called('radio')
                            ->label('Radio Field')
                            ->choices(static::$options)
                            ->wrapperWidth(33)
                            ->layout('horizontal'),

                    ]),

                TrueFalseField::called('true_false')
                    ->label('True False Field')
                    ->message('Yes, do this!')
                    ->wrapperWidth(50),

                UrlField::called('url')
                    ->label('Url Field')
                    ->wrapperWidth(50),

                /**
                 * Tabs & Images
                 */
                TabField::called('tab_images')
                    ->label('Images & Files'),

                ImageField::called('image')
                    ->label('Image Field')
                    ->previewSize('thumbnail')
                    ->wrapperWidth(50),

                GalleryField::called('gallery')
                    ->label('Gallery Field')
                    ->wrapperWidth(50),

                FileField::called('file')
                    ->label('File Field'),

                /**
                 * Editor
                 */
                TabField::called('tab_wysiwyg')
                    ->label('Editor'),

                WysiwygField::called('long_text')
                    ->label('WYSIWYG Field'),

                /**
                 * Repeater
                 */
                TabField::called('tab_repeater')
                    ->label('Repeater'),

                RepeaterField::called('repeater')
                    ->label('Repeater Field')
                    ->layout('table')
                    ->buttonLabel('New Contact')
                    ->withFields([
                        TextField::called('first_name'),
                        TextField::called('last_name'),
                        TextField::called('email_address'),
                    ]),

                /**
                 * Relationships
                 */
                TabField::called('tab_relationships')
                    ->label('Relationships'),

                PostObjectField::called('page_id_1')
                    ->label('Post Object Field')
                    ->wrapperWidth(50)
                    ->multiple(false)
                    ->postObject('page')
                    ->returnFormat('id'),

                RelationshipField::called('page_id_2')
                    ->label('Relationship Field')
                    ->postObject(['post', 'page'])
                    ->returnFormat('id')
                    ->wrapperWidth(50)
                    ->min(1),

                UserField::called('user_id')
                    ->label('User Field')
                    ->wrapperWidth(50),

                TaxonomyField::called('taxonomy')
                    ->taxonomy('category')
                    ->wrapperWidth(50)
                    ->loadTerms(true)
                    ->saveTerms(true),

                /**
                 * Layouts
                 */
                TabField::called('tab_layouts')
                    ->label('Layouts'),

                FlexibleContentField::called('flexible_content')
                    ->label('Flexible Content')
                    ->withLayouts([
                        LayoutField::called('layout_1')
                            ->label('Title and Image')
                            ->withFields([
                                TextField::called('title'),
                                ImageField::called('photo'),
                            ]),
                        LayoutField::called('layout_2')
                            ->label('Gallery')
                            ->withFields([
                                TextField::called('title'),
                                GalleryField::called('gallery'),
                            ]),

                    ]),

                TabField::called('tab_conditional')
                    ->label('Conditional Fields'),

                SelectField::called('option')
                    ->choices([
                        1 => 'One',
                        2 => 'Two',
                        3 => 'Other',
                    ])
                    ->default(1)
                    ->wrapperWidth(50),

                TextField::called('other_option')
                    ->wrapperWidth(50)
                    ->shown(When::field('option')->equals(3)),

            ])
            ->shown(Where::field('post_type')->equals(static::$postType))
            ->instructionPlacement('field')
            ->attachTo(static::class)
            ->register();
    }

}
