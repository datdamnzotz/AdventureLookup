<?php

namespace AppBundle\Field;

use AppBundle\Entity\Author;
use AppBundle\Entity\Edition;
use AppBundle\Entity\Environment;
use AppBundle\Entity\Item;
use AppBundle\Entity\Monster;
use AppBundle\Entity\Publisher;
use AppBundle\Entity\Setting;
use AppBundle\Exception\FieldDoesNotExistException;
use Doctrine\Common\Collections\ArrayCollection;

class FieldProvider
{
    /**
     * @var Field[]|ArrayCollection
     */
    private $fields;

    public function __construct()
    {
        $this->fields = new ArrayCollection([
            'title' => new Field(
                'title',
                'string',
                false,
                true,
                false,
                'Title',
                'The title of the adventure.',
                10
            ),
            'description' => new Field(
                'description',
                'text',
                false,
                true,
                false,
                'Description',
                'Description of the adventure.',
                5
            ),
            'authors' => new Field(
                'authors',
                'string',
                true,
                true,
                true,
                'Authors',
                'Names of people with writing or story credits on the module. Do not include editors or designers.',
                1,
                10,
                Author::class
            ),
            'edition' => new Field(
                'edition',
                'string',
                false,
                true,
                true,
                'System / Edition',
                'The system the game was designed for and the edition of that system if there is one.',
                1,
                300,
                Edition::class
            ),
            'environments' => new Field(
                'environments',
                'string',
                true,
                true,
                true,
                'Environments',
                'The different types of environments the module will take place in.',
                2,
                290,
                Environment::class
            ),
            'items' => new Field(
                'items',
                'string',
                true,
                true,
                true,
                'Notable Items',
                "The notable magic or non-magic items that are obtained in the module. Only include named items, don't include a +1 sword.",
                2,
                250,
                Item::class
            ),
            'publisher' => new Field(
                'publisher',
                'string',
                false,
                true,
                true,
                'Publisher',
                'Publisher of the adventure.',
                1,
                30,
                Publisher::class
            ),
            'setting' => new Field(
                'setting',
                'string',
                false,
                true,
                true,
                'Setting',
                'The narrative universe the module is set in.',
                1,
                280,
                Setting::class
            ),
            'commonMonsters' => new Field(
                'commonMonsters',
                'string',
                true,
                true,
                true,
                'Common Monsters',
                'The common monsters featured in the module.',
                2,
                260,
                Monster::class
            ),
            'bossMonsters' => new Field(
                'bossMonsters',
                'string',
                true,
                true,
                true,
                'Boss Monsters',
                'The boss monsters and villains featured in the module.',
                2,
                270,
                Monster::class
            ),

            'numPages' => new Field(
                'numPages',
                'integer',
                false,
                false,
                true,
                'Length (# of Pages)',
                'Total page count of all written material in the module or at least primary string.',
                1,
                160
            ),
            'minStartingLevel' => new Field(
                'minStartingLevel',
                'integer',
                false,
                false,
                true,
                'Min. Starting Level',
                'The minimum level characters are expected to be when taking part in the module.',
                1,
                190
            ),
            'maxStartingLevel' => new Field(
                'maxStartingLevel',
                'integer',
                false,
                false,
                true,
                'Max. Starting Level',
                'The maximum level characters are expected to be when taking part in the module.',
                1,
                180
            ),
            'startingLevelRange' => new Field(
                'startingLevelRange',
                'string',
                false,
                false,
                true,
                'Starting Level Range',
                'In case no min. / max. starting levels but rather low/medium/high are given.',
                1,
                170
            ),

            'soloable' => new Field(
                'soloable',
                'boolean',
                false,
                false,
                true,
                'Suitable for Solo Play',
                null,
                1,
                70
            ),
            'pregeneratedCharacters' => new Field(
                'pregeneratedCharacters',
                'boolean',
                false,
                false,
                true,
                'Has Pregenerated Characters',
                'Whether or not this contains character sheets.',
                1,
                100
            ),
            'handouts' => new Field(
                'handouts',
                'boolean',
                false,
                false,
                true,
                'Handouts',
                'Whether or not handouts are provided.',
                1,
                90
            ),
            'tacticalMaps' => new Field(
                'tacticalMaps',
                'boolean',
                false,
                false,
                true,
                'Battle Mats',
                'Whether or not battle mats are provided.',
                1,
                80
            ),

            'foundIn' => new Field(
                'foundIn',
                'string',
                false,
                true,
                true,
                'Found In',
                'If the adventure is part of a larger product, like a magazine or anthology, list it here.',
                1,
                5
            ),
            'partOf' => new Field(
                'partOf',
                'string',
                false,
                true,
                true,
                'Part Of',
                'The series of adventures that the module is a part of, if applicable.',
                1,
                5
            ),
            'year' => new Field(
                'year',
                'integer',
                false,
                false,
                true,
                'Publication Year',
                'The year this adventure was first published.',
                1,
                20
            ),

            'link' => new Field(
                'link',
                'url',
                false,
                false,
                false,
                'Link',
                'Links to legitimate sites where the module can be procured.'
            ),
            'thumbnailUrl' => new Field(
                'thumbnailUrl',
                'url',
                false,
                false,
                false,
                'Thumbnail URL',
                'URL of the thumbnail image.'
            ),
        ]);
    }

    /**
     * @return Field[]|ArrayCollection
     */
    public function getFields(): ArrayCollection
    {
        return $this->fields;
    }

    /**
     * @return Field[]|ArrayCollection
     */
    public function getFieldsAvailableAsFilter(): ArrayCollection
    {
        return $this->fields->filter(function (Field $field) {
            return $field->isAvailableAsFilter();
        });
    }

    /**
     * @param $name
     */
    public function getField($name): Field
    {
        if (!$this->fields->containsKey($name)) {
            throw new FieldDoesNotExistException(sprintf('Field with id "%s" does not exist!', $name));
        }

        return $this->fields->get($name);
    }
}
